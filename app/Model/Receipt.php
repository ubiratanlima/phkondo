<?php

App::uses('AppModel', 'Model');

/**
 * Receipt Model
 *
 * @property Condo $Condo
 * @property Client $Client
 * @property ReceiptStatus $ReceiptStatus
 * @property Note $Note
 */
class Receipt extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'title';

    /**
     * Order
     *
     * @var string
     */
    public $order = array('Receipt.document_date' => 'DESC', 'Receipt.document' => 'DESC');

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'document' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'condo_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'fraction_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'client_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'total_amount' => array(
            'money' => array(
                'rule' => array('money'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'title' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'document_date' => array(
            'date' => array(
                'rule' => array('date'),
                //'message' => 'Your custom message here',
                //'allowEmpty' => false,
                'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'receipt_status_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'receipt_payment_type_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
                //'message' => 'Your custom message here',
                'allowEmpty' => true,
                'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Condo' => array(
            'className' => 'Condo',
            'foreignKey' => 'condo_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Fraction' => array(
            'className' => 'Fraction',
            'foreignKey' => 'fraction_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'Client' => array(
            'className' => 'Entity',
            'foreignKey' => 'client_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'ReceiptStatus' => array(
            'className' => 'ReceiptStatus',
            'foreignKey' => 'receipt_status_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'ReceiptPaymentType' => array(
            'className' => 'ReceiptPaymentType',
            'foreignKey' => 'receipt_payment_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'PaymentUser' => array(
            'className' => 'User',
            'foreignKey' => 'payment_user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ),
        'CancelUser' => array(
            'className' => 'User',
            'foreignKey' => 'cancel_user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Note' => array(
            'className' => 'Note',
            'foreignKey' => 'receipt_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'ReceiptNote' => array(
            'className' => 'ReceiptNote',
            'foreignKey' => 'receipt_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );

    /**
     * afterFind callback
     * 
     * @param array $results
     * @param boolean $primary
     * @access public
     * @return array
     */
    public function afterFind($results, $primary = false) {
        if ($this->noAfterFind) {
            $this->noAfterFind=false;
            return $results;
        }
        
        
        if (isset($results[0][$this->alias])) {
            foreach ($results as $key => $val) {
                if (isset($results[$key][$this->alias]['id'])) {
                    
                    $results[$key][$this->alias]['payable'] = $this->payable($results[$key][$this->alias]['id']);
                    $results[$key][$this->alias]['editable'] = $this->editable($results[$key][$this->alias]['id']);
                    $results[$key][$this->alias]['deletable'] = $this->deletable($results[$key][$this->alias]['id']);
                    $results[$key][$this->alias]['closeable'] = $this->closeable($results[$key][$this->alias]['id']);
                    $results[$key][$this->alias]['cancelable'] = $this->cancelable($results[$key][$this->alias]['id']);
                    
                }
            }
        }
        
        if (isset($results['id'])) {
            $results['payable'] = $this->payable($results['id']);
            $results['editable'] = $this->editable($results['id']);
            $results['deletable'] = $this->deletable($results['id']);
            $results['closeable'] = $this->closeable($results['id']);
            $results['cancelable'] = $this->cancelable($results['id']);
        }
        
        return $results;
    }

    function beforeDelete($cascade = true) {
        
        if ($this->field('receipt_status_id') == '3')
            return false;
            
        if ($this->hasPaidNotes($this->id))
            return false;

        return true;
    }

    function hasPaidNotes($id = null) {
        $this->noAfterFind = true;
        if (!empty($id)) {
            $this->id = $id;
        }

        $id = $this->id;
        if (!$this->exists()) {
            return false;
        }

        $notes = $this->Note->find('count', array('conditions' => array('Note.receipt_id' => $id, 'Note.note_status_id' => array('2', '3'))));
        return ($notes > 0) ? true : false;
    }

    public function payable($id = null) {
        $this->noAfterFind = true;
        if (!empty($id)) {
            $this->id = $id;
        }

        $id = $this->id;
        if (!$this->exists()) {
            return false;
        }
        if ($this->field('receipt_status_id') == '2') {
            return true;
        }
        return false;
    }

    public function editable($id = null) {
        $this->noAfterFind = true;
        if (!empty($id)) {
            $this->id = $id;
        }

        $id = $this->id;
        if (!$this->exists()) {
            return false;
        }
        if ($this->field('receipt_status_id') > '2') {
            return false;
        }
        return true;
    }

    public function deletable($id = null) {
        $this->noAfterFind = true;
        if (!empty($id)) {
            $this->id = $id;
        }

        $id = $this->id;
        if (!$this->exists()) {
            return false;
        }
        return $this->beforeDelete();
    }

    public function closeable($id = null) {
        $this->noAfterFind = true;
        if (!empty($id)) {
            $this->id = $id;
        }

        $id = $this->id;
        if (!$this->exists()) {
            return false;
        }

        if ($this->field('receipt_status_id') != '3') {
            return false;
        }
        
        $this->noAfterFind = true;
        if ($this->field('receipt_payment_type_id') == '') {
            return false;
        }
        return true;
    }

    public function cancelable($id = null) {
        $this->noAfterFind = true;
        if (!empty($id)) {
            $this->id = $id;
        }

        $id = $this->id;
        if (!$this->exists()) {
            return false;
        }

        if (in_array($this->field('receipt_status_id'), array('1','2', '4'))) {
            return false;
        }
        return true;
    }

}
