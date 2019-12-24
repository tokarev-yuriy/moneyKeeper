<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\CrudListController;
use App\MoneyKeeper\Models\Category;
use App\MoneyKeeper\Models\Wallet;
use App\MoneyKeeper\Models\Operation;
use App\MoneyKeeper\Models\ImportProfile;
use View, Input, Session, Config, Request, Auth, Validator, Redirect;

/**
 *  Tinkoff integration
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class ImportTinkoffController extends ImportController {

    /**
     * Get form of import file upload
     * 
     * 
     * @return <type>
     */	
	public function getIndex()
	{
        
        return view('account.import.tinkoff.index', array());
	}
    
    /**
     * Get form of import file upload
     * 
     * 
     * @return <type>
     */	
	public function postIndex()
	{
        
        if (Input::get('mode')=='save')  {
            return $this->saveTransactions();
        } else {
            return $this->parseFile();
        }
	}
    
    /**
     * Parse file
     * 
     * 
     * @return <type>
     */	
	public function parseFile()
	{
        
        $arProfileList = array();
        $arProfiles = ImportProfile::user()->select('id', 'name')->orderBy('name')->get();
        foreach($arProfiles as $obProfile) {
            $arProfileList[$obProfile->id] = $obProfile->name;
        }
        $arImportRows = array();
        $arTransactions = array();
        $arDicts = array();
        
        $validator = Validator::make(Input::all(), array(
              'walletId'=>'required|in:'.implode(',',array_keys(Operation::getWallets())),
              'importFile'=>'required|max:1048576',
        ));		
        if(!$validator->fails())
        {
            $profileId = Input::get('profileId');
            $walletId = Input::get('walletId');
            $round = Input::get('round');
            
            $importFile = Input::file('importFile')->openFile('r');
            while (!$importFile->eof()) {
                $arRow = $importFile->fgetcsv(';');
                $arImportRows[] = $arRow;
            }
            
            $hasProfile = false;
            
            foreach($arProfileList as $profileId=>$profileName) {
              $obProfile = ImportProfile::user()->find($profileId);
              
              if ($this->validateData($arImportRows, $obProfile)) {
                $hasProfile = $profileId;
                break;
              }
            }
            
            $messages = $validator->messages();
            if ($hasProfile && $obProfile) {
              
                if ($obProfile->encoding!='UTF8') {
                  foreach ($arImportRows as $k => $arRow) {
                    foreach ($arRow as $key => $value) {
                      $arRow[$key] = iconv($obProfile->encoding, "UTF8", $value);
                    }
                    $arImportRows[$k] = $arRow;
                  }
                }
                
                if ($obProfile->category_rules) {
                    $obProfile->category_rules = unserialize($obProfile->category_rules);
                }
                if (!$obProfile->category_rules) $obProfile->category_rules = array();
                
                $arTransactions = $this->parseData($arImportRows, $obProfile);
                
                $arDicts = $this->getDictionaries();
                
                foreach($arTransactions as $k=>$arTransaction) {
                    $wallet = $arDicts['wallets'][$walletId];
                    $arTransactions[$k]['wallet'] = $wallet;
                    if ($round>=0) {
                        $arTransactions[$k]['value'] = round($arTransactions[$k]['value'], intval($round));
                    } else {
                        $arTransactions[$k]['value'] = round($arTransactions[$k]['value'], 0);
                        if ($arTransactions[$k]['value']%(abs(intval($round)))>0) {
                            if ($arTransaction['type'] == 'spend') {
                                $arTransactions[$k]['value'] -= $round + $arTransactions[$k]['value']%(abs(intval($round)));
                            } else {
                                $arTransactions[$k]['value'] -= $arTransactions[$k]['value']%(abs(intval($round)));
                            }
                        }
                    }
                }
            } else {
                $messages->add('importFile', trans('mkeep.import_file_wrong'));
            }
        } else {
            $messages = $validator->messages();
        }
        
        return view('account.import.tinkoff.index', array('profileList'=>$arProfileList, 'errors'=>$messages, 'arTransactions'=>$arTransactions, 'arDictionaries'=>$arDicts));
	}
    
    /**
     * Save transactions
     * 
     * 
     * @return <type>
     */	
	public function saveTransactions()
	{
        
        $walletId = Input::get('walletId');
        $obWallet = Wallet::user()->find($walletId);
        $arTransactions = Input::get('importTransaction');
        if ($obWallet && is_array($arTransactions)) {
            foreach ($arTransactions as $arTransacton) {
                
                $obItem = new Operation();
                $obItem->comment = $arTransacton['comment'];
                $obItem->date = date('Y-m-d', strtotime($arTransacton['date']));
                $obItem->year = date('Y', strtotime($arTransacton['date']));
                $obItem->month = date('m', strtotime($arTransacton['date']));
                $obItem->user_id = Auth::id();
                $obItem->type = $arTransacton['type'];
                $obItem->value = floatval($arTransacton['value']);
                $obItem->category_id = intval($arTransacton['category_id']);
                if ($obItem->type=='income') {
                    $obItem->wallet_to_id = $obWallet->id;
                } elseif ($obItem->type=='spend') {
                    $obItem->wallet_from_id = $obWallet->id;
                }
                $obItem->save();
                
            }
        }
        
        return Redirect::to('/');
	}
    
    /**
     * Validate csv file with concrete profile
     * 
     * @param <type> $arRows 
     * @param <type> $obProfile 
     * 
     * @return <type>
     */    
    protected function validateData($arRows, $obProfile) {
        $hasErrors = false;
        if (count($arRows)<$obProfile->start_row) {
            return false;
        }
        if ($obProfile->control_row) {
          
            if ($obProfile->encoding!='UTF8') {
                foreach ( $arRows[$obProfile->control_row-1] as $key => $value) {
                   $arRows[$obProfile->control_row-1][$key] = @iconv($obProfile->encoding, "UTF8", $value);
                }
            }
          
            if (count($arRows)<$obProfile->control_row || stripos(implode(';', $arRows[$obProfile->control_row-1]), implode(';', str_getcsv($obProfile->control_string, ';')))===FALSE) {
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Parse csv file with concrete profile
     * 
     * @param <type> $arRows 
     * @param <type> $obProfile 
     * 
     * @return <type>
     */    
    protected function parseData($arRows, $obProfile) {
        $arTransactions = array();
        foreach ($arRows as $row=>$arRow) {
            if ($row+1 < $obProfile->start_row) {
                continue;
            }
            
            $arTransaction = $this->parseRow($arRow, $obProfile);
            if ($arTransaction) {
                $arTransactions[] = $arTransaction;
            }
        }
        
        return $arTransactions;
    }
    
    /**
     * Parse row with concrete profile
     * 
     * @param <type> $arRow 
     * @param <type> $obProfile 
     * 
     * @return <type>
     */    
    protected function parseRow($arRow, $obProfile) {
        
        $arTransaction = array();
        if (!$obProfile->date_col || !$arRow[$obProfile->date_col-1] || !strtotime($arRow[$obProfile->date_col-1])) {
            return false;
        }
        
        $arTransaction['date'] = date('Y-m-d', strtotime($arRow[$obProfile->date_col-1]));
        
        if (!$obProfile->summ_col || !$arRow[$obProfile->summ_col-1] || !floatval(str_replace(array(' ', ','), array('','.'), $arRow[$obProfile->summ_col-1]))) {
            return false;
        }
        
        $arTransaction['value'] = floatval(str_replace(array(' ', ','), array('','.'), $arRow[$obProfile->summ_col-1]));
        $arTransaction['comment'] = trim($arRow[$obProfile->desc_col-1]);
        $arTransaction['category'] = trim($arRow[$obProfile->category_col-1]);        
        if ($arTransaction['value']<0) {
            $arTransaction['type'] = 'spend';
            $arTransaction['value'] *= -1;
        } elseif(in_array('Debit', $arRow)) {
			$arTransaction['type'] = 'spend';
		} else {
            $arTransaction['type'] = 'income';
        }
        
        $arTransaction['category_id'] = $this->getCategoryId($arTransaction['comment'], $arTransaction['category'], $arTransaction['type'], $obProfile->category_rules);
        
        return $arTransaction;
    }

}
