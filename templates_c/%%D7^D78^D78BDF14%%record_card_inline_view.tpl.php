<div class="row">
    <div class="col-md-12">
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'forms/form_fields.tpl', 'smarty_include_vars' => array('isViewForm' => true)));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    </div>
</div>

<div class="btn-toolbar pull-right">
    <button class="btn btn-default js-cancel">
        <?php echo $this->_tpl_vars['Captions']->GetMessageString('Close'); ?>

    </button>    
</div>