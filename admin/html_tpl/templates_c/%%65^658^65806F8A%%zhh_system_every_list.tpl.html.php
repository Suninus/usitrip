<?php /* Smarty version 2.6.25-dev, created on 2013-12-27 15:30:29
         compiled from zhh_system_every_list.tpl.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="main">
  <form action="" method="get" id="form_search" target="_self" name="form_search">
    <div class="searchBox">
      <h2 class="conSwitchH">��������</h2>
      <div class="searchCon conSwitchCon">
        <table width="700" border="0" cellpadding="0" cellspacing="0">
          <tr>    
            <td>����ʱ�䣺</td>
            <td><input type="text" class="textTime" name="added_start_date" value="<?php echo $this->_tpl_vars['added_start_date']; ?>
" onclick="GeCalendar.SetUnlimited(1); GeCalendar.SetDate(this);" style="ime-mode: disabled;" />
              ��
              <input type="text" class="textTime" name="added_end_date" value="<?php echo $this->_tpl_vars['added_end_date']; ?>
" style="ime-mode: disabled;" onclick="GeCalendar.SetUnlimited(1); GeCalendar.SetDate(this);" /></td>
            <td width="65">������</td>
            <td><input type="text" class="textAll" name="admin_user"/></td>
          </tr>          
          <tr>
            <td colspan="6" class="btnCenter">
               <button class="btn btnOrange" type="submit">�� ��</button>   <input name="output" class="btn btnOrange" type="submit" value="����Excel" />           
            </td>
           
          </tr>
        </table>
      </div>
    </div>
  </form>
  <div>
    <h2 class="conSwitchH">��Ʒ�б�</h2>
    <div class="minCon conSwitchCon">
      
      <div>
        <table class="listTable" id="ListTable" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <th width="40">&nbsp;</th>
            <th width="40">����</th>
            <th>����δ����</th>
            <th>���һ�ε�¼ʱ��</th>            
            <th style="padding-left:40px;">����</th>
          </tr>
          <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['datas']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
          <?php if (count ( $this->_tpl_vars['datas'][$this->_sections['i']['index']]['list'] ) > 0): ?>
          <tbody id="group_one">
              <tr id="Basic_<?php echo $this->_sections['i']['index']; ?>
">
              <td class="select"><input type="checkbox" name="readdata[]" id="readata_" value="<?php echo $this->_tpl_vars['datas'][$this->_sections['i']['index']]['id']; ?>
" /></td>
              <td><?php echo $this->_tpl_vars['datas'][$this->_sections['i']['index']]['name']; ?>
</td>  
              <td><?php echo $this->_tpl_vars['datas'][$this->_sections['i']['index']]['unread']; ?>
</td>   
              <td><?php echo $this->_tpl_vars['datas'][$this->_sections['i']['index']]['lastlogin']; ?>
</td>
              <td><a href="javascript:" class="showMore" >�鿴��ϸ</a></td>
            </tr>
            <tr class="trDetail" id="Detail_<?php echo $this->_sections['i']['index']; ?>
">
              <td colspan="9" class="TabselectBg">
                  <div class="darenInfo">                  
                 
                  <div class="con conSwitchCon" style="">
                    <table cellspacing="0" cellpadding="0" border="0" class="detailTable" >
                      
                      <tr>					  	
                        <th><b>δ����Ϣ����</b></th>
                        <th><b>����ʱ��</b></th>
                        <th><b>���ڴ���</b></th>
                        <th><b>�Ƿ��Ķ�</b></th>
                        
                      </tr>
                      <?php unset($this->_sections['n']);
$this->_sections['n']['name'] = 'n';
$this->_sections['n']['loop'] = is_array($_loop=$this->_tpl_vars['datas'][$this->_sections['i']['index']]['list']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['n']['show'] = true;
$this->_sections['n']['max'] = $this->_sections['n']['loop'];
$this->_sections['n']['step'] = 1;
$this->_sections['n']['start'] = $this->_sections['n']['step'] > 0 ? 0 : $this->_sections['n']['loop']-1;
if ($this->_sections['n']['show']) {
    $this->_sections['n']['total'] = $this->_sections['n']['loop'];
    if ($this->_sections['n']['total'] == 0)
        $this->_sections['n']['show'] = false;
} else
    $this->_sections['n']['total'] = 0;
if ($this->_sections['n']['show']):

            for ($this->_sections['n']['index'] = $this->_sections['n']['start'], $this->_sections['n']['iteration'] = 1;
                 $this->_sections['n']['iteration'] <= $this->_sections['n']['total'];
                 $this->_sections['n']['index'] += $this->_sections['n']['step'], $this->_sections['n']['iteration']++):
$this->_sections['n']['rownum'] = $this->_sections['n']['iteration'];
$this->_sections['n']['index_prev'] = $this->_sections['n']['index'] - $this->_sections['n']['step'];
$this->_sections['n']['index_next'] = $this->_sections['n']['index'] + $this->_sections['n']['step'];
$this->_sections['n']['first']      = ($this->_sections['n']['iteration'] == 1);
$this->_sections['n']['last']       = ($this->_sections['n']['iteration'] == $this->_sections['n']['total']);
?>  
                      <tr>					  	
                          <td><?php echo $this->_tpl_vars['datas'][$this->_sections['i']['index']]['list'][$this->_sections['n']['index']]['words_title']; ?>
<?php if ($this->_tpl_vars['datas'][$this->_sections['i']['index']]['list'][$this->_sections['n']['index']]['is_adjective']): ?><span class="urgentIcon">&nbsp;</span><?php endif; ?></td>
                          <td><?php echo $this->_tpl_vars['datas'][$this->_sections['i']['index']]['list'][$this->_sections['n']['index']]['added_time']; ?>
</td>                          
                          <td><?php echo $this->_tpl_vars['datas'][$this->_sections['i']['index']]['list'][$this->_sections['n']['index']]['login_num']; ?>
</td>
                          <td><?php if ($this->_tpl_vars['datas'][$this->_sections['i']['index']]['list'][$this->_sections['n']['index']]['is_read']): ?>�Ѷ�<?php else: ?>δ��<?php endif; ?></td>
                      </tr>
                      <?php endfor; endif; ?>
                    </table>
                  </div>
                 
             
                </div>
                
              </td>
              
            </tr>	
                
          
          </tbody>
          <?php endif; ?>
         <?php endfor; endif; ?>
          <tfoot>
            <tr>
              <td bgcolor="#f5f5f5" colspan="10">
                <div class="pageNum">
                  <input type="checkbox" id="checkall">
                  ȫѡ&nbsp;&nbsp;&nbsp;
                  ����&nbsp;&nbsp;&nbsp;<a href="javascript:Remove();" id="checkall_del">���ͳ������</a></div>
                <div class="pageNum"></div>
                <div class="page"></div>
              </td>
            </tr>
          </tfoot>
        </table>
      </div>

    </div>
  </div>
</div>
 <script type="text/javascript">
$("#checkall").click(function(){
     $("input[name='readdata[]']").attr("checked",$(this).attr("checked"));	 
});
function Remove(){
  var listArray = jQuery("input[name='readdata[]']:checked");
  var data = '';
  if (listArray.length > 0){
    for(var i=0; i<listArray.length; i++){
            if (i == listArray.length - 1){
                data += listArray[i].value;
            }else{
                data += listArray[i].value + ',';
            }
    }
    if (confirm('���Ҫ���ͳ������?\n����󽫲��ɻָ�!')){
        jQuery.ajax({
                    url: url_ssl("zhh_system_every_list.php"),
                    data: "action=remove&ajax=true&admin_id="+data,
                    type: "POST",
                    cache: false,
                    dataType: "html",
                    success: function (data){					
                        if (data == '1'){
                            window.location.reload();
                        }
                    },
                    error: function (msg){
                        alert(msg);
                    }
                    
        })
    }
  }else{
    alert('��ѡ��Ҫ��������ݣ�');
  }
}
$(document).ready(function(){	
    $("#ListTable>tbody>tr:odd").mouseover(function(){$(this).addClass("trHover");}).mouseout(function(){$(this).removeClass("trHover");});
    $("#ListTable>tbody>tr").each(function(index) {
        if((index+1)%4 == 0 ){
            $(this).addClass("trEven");
        }
    });
    
    $("#ListTable>tbody>tr:odd td:not('.select')").click(function(){
        
        $("tr[id^='Detail_']").hide();       
        var idName = $(this).parent().attr("id");
        var tempName = idName.substr(idName.indexOf("_"));
        
        if($(this).parent().hasClass("trClick")){
            $("#ListTable>tbody>tr:odd").removeClass("trClick");
            $("#ListTable>tbody>tr:odd").removeClass("trOut");

            $(this).parent().addClass("trOut");
            $("#Detail"+tempName).hide();
        }else{
            $("#ListTable>tbody>tr:odd").removeClass("trOut");
            $("#ListTable>tbody>tr:odd").removeClass("trClick");
            $(this).parent().addClass("trClick");
            
            $("#Detail"+tempName).show();
        }
    });


});

</script>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 