<?php
namespace App\MoneyKeeper\Integration;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

/**
 *  Tinkoff Integration class
 *
 *  @author   Yuriy Tokarev <yuriytok@gmail.com>
 */
class Tinkoff extends Integration {

    /**
     *
     */
    public function sync() {
        if ($this->getToken() && $this->getBills()) {
            $this->getOperations();
        }
        die();
    }
	
	
	/**
     *
     */
    public function getTransactions() {
		$arTransactions = [];
        if (!$this->getToken()) {
            throw new \Exception('Не удалось получить токен');
        }
        if (!$this->getBills()) {
            throw new \Exception('Не удалось получить счета');
        }
        $this->getOperations();
        foreach($this->operations as $obOperation) {
            $arTransaction = $this->parseOperation($obOperation);
            if ($arTransaction && !$this->isTransactionExists($arTransaction['ext_id'])) {
                $arTransactions[] = $arTransaction;
            }
        }
        
        return $arTransactions;
    }
	
	/**
	 *	Парсим транзакцию
	 */
	private function parseOperation($obOperation) {
		$arTransaction = [];
		
		$arTransaction['date'] = date('Y-m-d', strtotime($obOperation->date));
		$arTransaction['ext_id'] = md5(print_r($obOperation, true));
		
        
        if (!$obOperation->amount || !floatval($obOperation->amount)) {
            return false;
        }
        
        $arTransaction['value'] = round(floatval($obOperation->amount),-1);
		if ($arTransaction['value'] < $obOperation->amount) {
			$arTransaction['value'] += 10;
		}
		
		$comment = $obOperation->paymentPurpose;
		if (stripos($comment, 'Отражение операции оплаты по карте номер')!==false) {
			$comment = preg_replace('/Отражение операции оплаты по карте номер [0-9]+\\.\\.\\.[0-9]+/', '',$comment);
			$comment = trim(preg_replace('/. Договор [0-9]+/', '',$comment));
		}
        $arTransaction['comment'] = $comment;
        $arTransaction['category'] = $comment;
        if ($obOperation->operationType==17) {
            $arTransaction['type'] = 'spend';
        } elseif($obOperation->operationType!='01') {
			$arTransaction['type'] = 'spend';
		} else {
            $arTransaction['type'] = 'income';
        }
        
        $arTransaction['category_id'] = $this->getCategoryId($arTransaction['comment'], $arTransaction['category'], $arTransaction['type']);
        
        return $arTransaction;
	}
    
    /**
     *  Get User operations
     */
    protected function getOperations () {
        $this->operations = [];
        foreach($this->bills as $bill) {
            $this->operations += $this->getOperationsByBill($bill);
        }
    }
    
    /**
     *  Get User operations by bill
     */
    protected function getOperationsByBill($bill) {
        $operations = [];
        $response = $this->call("https://business.tinkoff.ru/openapi/api/v1/bank-statement", "GET", 
                    [
						'accountNumber'=>$bill,
						'from'=>date("Y-m-d", strtotime($this->obItem->last_sync)-10*24*60*60)
					],
                    [
                        'Authorization'=> 'Bearer '.$this->token,
                        'Content-Type'=> 'text/plain'
                    ]
                );
        
        if (is_array($response)) {
            if ($response['code']==200 && is_object($response['result']) && isset($response['result']->operation)) {
                foreach($response['result']->operation as $operation) {
                    $operations[] = $operation;
                }
            }
        }
        return $operations;
    }
    
    
    /**
     *  Get User Bills by Inn
     */
    protected function getBills() {
        $this->bills = [];
        $response = $this->call("https://business.tinkoff.ru/openapi/api/v3/bank-accounts", "GET", 
                    [],
                    [
                        'Authorization'=> 'Bearer '.$this->token,
                        'Content-Type'=> 'application/json'
                    ]
                );
        
        if (is_array($response)) {
            if ($response['code']==200 && is_array($response['result'])) {
                foreach($response['result'] as $account) {
                    $this->bills[] = $account->accountNumber;
                }
                return true;
            } elseif($response['result'] && $response['result']->errorMessage) {
                throw new \Exception($response['result']->errorMessage);
            }
        }
        return false;
    }
    
    /**
     *  Get token by refresh token
     */
    protected function getToken() {
        $this->token = $this->params['refreshToken'];
        return true;
    }

}
