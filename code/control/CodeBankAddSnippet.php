<?php
class CodeBankAddSnippet extends CodeBankEditSnippet {
    public static $url_segment='codeBank/add';
    public static $url_rule='/$Action/$ID/$OtherID';
    public static $url_priority=62;
    public static $session_namespace='CodeBankAddSnippet';
    
    public static $required_permission_codes=array(
                                                    'CODE_BANK_ACCESS'
                                                );
    
    public static $allowed_actions=array(
                                        'AddForm',
                                        'doAdd'
                                    );
    
    /**
     * Generates the form used for adding snippets
     * @return {Form} Form used to add snippets
     */
    public function AddForm() {
        $form=LeftAndMain::getEditForm();
        
        $form->setName('AddForm');
        $form->setActions(new FieldList(
                                        FormAction::create('doAdd', _t('CodeBank.SAVE', '_Save'))->addExtraClass('ss-ui-action-constructive')->setAttribute('data-icon', 'accept')->setUseButtonTag(true)
                                    ));
        
        $form->disableDefaultAction();
        $form->addExtraClass('cms-add-form cms-edit-form');
        $form->setTemplate($this->getTemplatesWithSuffix('_EditForm'));
        // TODO Can't merge $FormAttributes in template at the moment
        $form->addExtraClass('center '.$this->BaseCSSClasses());
        $form->setAttribute('data-pjax-fragment', 'CurrentForm');
        
        
        $this->extend('updateAddForm', $form);
        
        
        Requirements::javascript('CodeBank/javascript/CodeBank.EditForm.js');
        
        return $form;
    }
    
    /**
     * Handles adding the snippet to the database
     * @param {array} $data Data submitted by the user
     * @param {Form} $form Form submitted
     */
    public function doAdd($data, Form $form) {
        $record=$this->getRecord(null);
        $form->saveInto($record);
        $record->write();
        
        
        $this->redirect('admin/codeBank/show/'.$record->ID);
        return $this->getResponseNegotiator()->respond($this->request);
    }
    
    /**
     * Gets an empty snippet to be loaded
     * @return {Snippet} Empty snippet record
     */
    public function getRecord($id) {
        return new Snippet();
    }
}
?>