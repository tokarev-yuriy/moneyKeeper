<?php
namespace App\MoneyKeeper\Integration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use App\MoneyKeeper\Models\Category;
use App\MoneyKeeper\Models\Wallet;
use App\MoneyKeeper\Models\Operation;
use Input, Request, Auth;

/**
 *  Integration class
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class Integration {

    protected $params;
    protected $rules;
    protected $obItem;

    function __construct ($obItem) {
        $this->obItem = $obItem;
        $this->params = json_decode($obItem->params, true);
        $this->rules = json_decode($obItem->category_rules, true);
    }

    /**
     *
     */
    public function sync() {
        
    }
	
	/**
	
	*/
	public function getTransactions() {
	}
	
	
	/**
     * Get categoryId by comment category and rules
     * 
     * @param <type> $comment 
     * @param <type> $category 
     * @param <type> $type 
     * 
     * @return <type>
     */    
    protected function getCategoryId ($comment, $category, $type) {
        
        $arCategories = Category::user()->select('id', 'name', 'icon')->whereIn('type', array('any', $type))->orderBy('sort')->get();
        
        foreach ($this->rules as $categoryId=>$rule) {
            $arRules = explode(',',$rule);
            foreach ($arRules as $rule) {
                $rule = trim($rule);
                if (stripos($comment, $rule)!==FALSE || stripos($category, $rule)!==FALSE) {
                    return $categoryId;
                }
            }
        }
        
        return $arCategories[0]->id;
    }
    
    
    public function call($url, $method="GET", $data=[], $headers=[]) {
        $curl_options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_AUTOREFERER => false,
            CURLOPT_CUSTOMREQUEST  => $method
        );
		
        switch($method) {
            case "POST":
                $curl_options[CURLOPT_POST] = true;
                $data = http_build_query($data);
                $curl_options[CURLOPT_POSTFIELDS] = $data;
                break;
            case "GET":
                if (is_array($data) && count($data)>0) {
                    $url .= '?' . http_build_query($data, null, '&');
                }
                break;
            default:
                break;
        }

        $curl_options[CURLOPT_URL] = $url;

        if (is_array($headers)) {
            $header = array();
            foreach($headers as $key => $parsed_urlvalue) {
                $header[] = "$key: $parsed_urlvalue";
            }
            $curl_options[CURLOPT_HTTPHEADER] = $header;
        }

        $ch = curl_init();
        curl_setopt_array($ch, $curl_options);
        $result = curl_exec($ch);
        
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        
        if ($result===false) {
            return curl_error($ch);
        } else {
            $json_decode = json_decode($result);
        }
        curl_close($ch);

        return array(
            'result' => $json_decode,
            'code' => $http_code,
            'headers' => $headers,
            'content_type' => $content_type
        );
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
                $obItem->comment = trim($arTransacton['comment']);
                $obItem->ext_id = $arTransacton['ext_id'];
                $obItem->date = date('Y-m-d', strtotime($arTransacton['date']));
                $obItem->year = date('Y', strtotime($arTransacton['date']));
                $obItem->month = date('m', strtotime($arTransacton['date']));
                $obItem->user_id = Auth::id();
                $obItem->type = $arTransacton['type'];
                $obItem->value = floatval($arTransacton['value']);
                $obItem->category_id = intval($arTransacton['category_id']);
				
				$arRules = explode(',',$this->rules[$obItem->category_id]);
				if (!in_array($obItem->comment, $arRules)) {
					$arRules[] = $obItem->comment;
					$this->rules[$obItem->category_id] = implode(',', $arRules);
				}
                if ($obItem->type=='income') {
                    $obItem->wallet_to_id = $obWallet->id;
                } elseif ($obItem->type=='spend') {
                    $obItem->wallet_from_id = $obWallet->id;
                }
                $obItem->save();
            }
			$this->obItem->category_rules = json_encode($this->rules);
			$this->obItem->last_sync = date("Y-m-d H:i:s");
			$this->obItem->save();
			return true;
        }
        
        return false;
	}
	
	/**
     * Get Dictionaries
     * 
     * 
     * @return <type>
     */    
    public function getDictionaries() {
        
        $arDicts = array(
            'wallets' => array(),
            'category_id' => array(),
            'category_icon' => array(),
            'type' => Category::getTypeVisualList(),
        );
        
        
        $arCategories = Category::user()->select('id', 'name', 'icon')->orderBy('sort')->get();
        $arIcons = Category::getCategoryIcons();
        foreach($arCategories as $arCategory) {
            $arDicts['category_id'][$arCategory->id] = $arCategory->name;
            $arDicts['category_icon'][$arCategory->id] = '';
            if ($arCategory->icon && isset($arIcons[$arCategory->icon])) {
                $arDicts['category_icon'][$arCategory->id] = $arIcons[$arCategory->icon];
            }
        }
        
        $arWallets = Wallet::user()->select('id', 'name')->orderBy('sort')->get();
        foreach($arWallets as $arWallet) {
            $arDicts['wallets'][$arWallet->id] = $arWallet->name;
        }
        
        return $arDicts;
    }
    
    /**
     *  Check if transaction has been already added
     */
    public function isTransactionExists($extId) {
        return Operation::user()->where('ext_id', $extId)->exists();
    }

}
