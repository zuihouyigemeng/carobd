<?php /* Smarty version Smarty-3.1.18, created on 2015-03-24 14:59:11
         compiled from "./templates/speed.tpl" */ ?>
<?php /*%%SmartyHeaderCode:165722065554058973b15c33-82614359%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '53871809663ca28429b4ee04cf6d3a2883771b1c' => 
    array (
      0 => './templates/speed.tpl',
      1 => 1423554685,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '165722065554058973b15c33-82614359',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_54058973bd2361_61309550',
  'variables' => 
  array (
    'title' => 0,
    'list' => 0,
    'objArray' => 0,
    'numberArray' => 0,
    'list1' => 0,
    'objArray1' => 0,
    'numberArray1' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54058973bd2361_61309550')) {function content_54058973bd2361_61309550($_smarty_tpl) {?><?php echo '<?xml';?> version="1.0"<?php echo '?>';?>

<<?php ?>?mso-application progid="Excel.Sheet"?<?php ?>>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
 xmlns:html="http://www.w3.org/TR/REC-html40">
 <DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
  <LastAuthor>USER</LastAuthor>
  <Created>2010-08-24T12:17:09Z</Created>
  <LastSaved>2010-08-25T03:54:56Z</LastSaved>
  <Version>11.9999</Version>
 </DocumentProperties>
 <ExcelWorkbook xmlns="urn:schemas-microsoft-com:office:excel">
  <WindowHeight>10695</WindowHeight>
  <WindowWidth>21435</WindowWidth>
  <WindowTopX>0</WindowTopX>
  <WindowTopY>105</WindowTopY>
  <ProtectStructure>False</ProtectStructure>
  <ProtectWindows>False</ProtectWindows>
 </ExcelWorkbook>
 <Styles>
  <Style ss:ID="Default" ss:Name="Normal">
   <Alignment ss:Vertical="Center"/>
   <Borders/>
   <Font ss:FontName="宋体" x:CharSet="134" ss:Size="12"/>
   <Interior/>
   <NumberFormat/>
   <Protection/>
  </Style>
  <Style ss:ID="s21">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Font ss:FontName="宋体" x:CharSet="134" ss:Size="14"/>
  </Style>
  <Style ss:ID="s24">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="2"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="2"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="2"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="2"/>
   </Borders>
   <Font ss:FontName="宋体" x:CharSet="134" ss:Size="14"/>
  </Style>
  <Style ss:ID="s25">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders/>
   <Font ss:FontName="宋体" x:CharSet="134" ss:Size="14" ss:Bold="1"/>
  </Style>
  <Style ss:ID="s26">
   <Alignment ss:Horizontal="Center" ss:Vertical="Center"/>
   <Borders>
    <Border ss:Position="Bottom" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Left" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Right" ss:LineStyle="Continuous" ss:Weight="1"/>
    <Border ss:Position="Top" ss:LineStyle="Continuous" ss:Weight="1"/>
   </Borders>
   <Font ss:FontName="宋体" x:CharSet="134" ss:Size="14"/>
  </Style>
  
 </Styles>
 <Worksheet ss:Name="statics">
  <Table x:FullColumns="1"
   x:FullRows="1" ss:StyleID="s21" ss:DefaultColumnWidth="150"
   ss:DefaultRowHeight="18.75">
   <Column ss:StyleID="s21" ss:AutoFitWidth="0" ss:Width="51.75" ss:Span="1"/>
   <Column ss:Index="3" ss:StyleID="s21" ss:AutoFitWidth="0" ss:Width="95"/>
   <Column ss:StyleID="s21" ss:AutoFitWidth="0" ss:Width="125"/>
   <Row ss:AutoFitHeight="0" ss:Height="26.25">
    <Cell ss:Index="2" ss:MergeAcross="4" ss:StyleID="s25"><Data ss:Type="String"><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</Data></Cell>
   </Row>
   <Row ss:AutoFitHeight="0" ss:Height="24.9375">
    <Cell ss:StyleID="s26" ss:Index="2"><Data ss:Type="String"><?php echo $_smarty_tpl->tpl_vars['list']->value[0];?>
</Data></Cell>
    <Cell ss:StyleID="s26"><Data ss:Type="String"><?php echo $_smarty_tpl->tpl_vars['list']->value[1];?>
</Data></Cell>
    <Cell ss:StyleID="s26"><Data ss:Type="String"><?php echo $_smarty_tpl->tpl_vars['list']->value[2];?>
</Data></Cell>
    <Cell ss:StyleID="s26"><Data ss:Type="String"><?php echo $_smarty_tpl->tpl_vars['list']->value[3];?>
</Data></Cell>
    <Cell ss:StyleID="s26"><Data ss:Type="String"><?php echo $_smarty_tpl->tpl_vars['list']->value[4];?>
</Data></Cell>
   </Row>
   <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['num'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['num']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['num']['name'] = 'num';
$_smarty_tpl->tpl_vars['smarty']->value['section']['num']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['objArray']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['num']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['num']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['num']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['num']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['num']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['num']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['num']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['num']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['num']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['num']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['num']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['num']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['num']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['num']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['num']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['total']);
?>
   <Row ss:AutoFitHeight="0" ss:Height="24.9375">
    <Cell ss:StyleID="s26" ss:Index="2"><Data ss:Type="String" ><?php echo $_smarty_tpl->tpl_vars['numberArray']->value[$_smarty_tpl->getVariable('smarty')->value['section']['num']['index']];?>
</Data></Cell>
     <Cell ss:StyleID="s26"><Data ss:Type="String"><?php echo $_smarty_tpl->tpl_vars['objArray']->value[$_smarty_tpl->getVariable('smarty')->value['section']['num']['index']][0];?>
</Data></Cell>
     <Cell ss:StyleID="s26"><Data ss:Type="String"><?php echo $_smarty_tpl->tpl_vars['objArray']->value[$_smarty_tpl->getVariable('smarty')->value['section']['num']['index']][1];?>
</Data></Cell>
    <Cell ss:StyleID="s26"><Data ss:Type="String"><?php echo $_smarty_tpl->tpl_vars['objArray']->value[$_smarty_tpl->getVariable('smarty')->value['section']['num']['index']][2];?>
</Data></Cell>
    <Cell ss:StyleID="s26" ><Data ss:Type="String"><?php echo $_smarty_tpl->tpl_vars['objArray']->value[$_smarty_tpl->getVariable('smarty')->value['section']['num']['index']][3];?>
</Data></Cell>
   </Row>
   <?php endfor; endif; ?>
   
   
   <Row ss:AutoFitHeight="0" ss:Height="24.9375">
    <Cell ss:StyleID="s26" ss:Index="2"><Data ss:Type="String"><?php echo $_smarty_tpl->tpl_vars['list1']->value[0];?>
</Data></Cell>
    <Cell ss:StyleID="s26"><Data ss:Type="String"><?php echo $_smarty_tpl->tpl_vars['list1']->value[1];?>
</Data></Cell>
    <Cell ss:StyleID="s26"><Data ss:Type="String"><?php echo $_smarty_tpl->tpl_vars['list1']->value[2];?>
</Data></Cell>
    <Cell ss:StyleID="s26"><Data ss:Type="String"><?php echo $_smarty_tpl->tpl_vars['list1']->value[3];?>
</Data></Cell>
    <Cell ss:StyleID="s26"><Data ss:Type="String"><?php echo $_smarty_tpl->tpl_vars['list1']->value[4];?>
</Data></Cell>
   </Row>
   <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['num'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['num']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['num']['name'] = 'num';
$_smarty_tpl->tpl_vars['smarty']->value['section']['num']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['objArray1']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['num']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['num']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['num']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['num']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['num']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['num']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['num']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['num']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['num']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['num']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['num']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['num']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['num']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['num']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['num']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['num']['total']);
?>
   <Row ss:AutoFitHeight="0" ss:Height="24.9375">
    <Cell ss:StyleID="s26" ss:Index="2"><Data ss:Type="String" ><?php echo $_smarty_tpl->tpl_vars['numberArray1']->value[$_smarty_tpl->getVariable('smarty')->value['section']['num']['index']];?>
</Data></Cell>
     <Cell ss:StyleID="s26"><Data ss:Type="String"><?php echo $_smarty_tpl->tpl_vars['objArray1']->value[$_smarty_tpl->getVariable('smarty')->value['section']['num']['index']][0];?>
</Data></Cell>
     <Cell ss:StyleID="s26"><Data ss:Type="String"><?php echo $_smarty_tpl->tpl_vars['objArray1']->value[$_smarty_tpl->getVariable('smarty')->value['section']['num']['index']][1];?>
</Data></Cell>
    <Cell ss:StyleID="s26"><Data ss:Type="String"><?php echo $_smarty_tpl->tpl_vars['objArray1']->value[$_smarty_tpl->getVariable('smarty')->value['section']['num']['index']][2];?>
</Data></Cell>
    <Cell ss:StyleID="s26"><Data ss:Type="String"><?php echo $_smarty_tpl->tpl_vars['objArray1']->value[$_smarty_tpl->getVariable('smarty')->value['section']['num']['index']][3];?>
</Data></Cell>
   </Row>
   <?php endfor; endif; ?>
  
   <Row ss:AutoFitHeight="0" ss:Height="24.9375" ss:Span="30"/>
  </Table>
  <WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
   <Unsynced/>
   <Print>
    <ValidPrinterInfo/>
    <PaperSizeIndex>9</PaperSizeIndex>
    <HorizontalResolution>200</HorizontalResolution>
    <VerticalResolution>200</VerticalResolution>
   </Print>
   <Selected/>
   <Panes>
    <Pane>
     <Number>3</Number>
     <ActiveRow>15</ActiveRow>
     <ActiveCol>2</ActiveCol>
    </Pane>
   </Panes>
   <ProtectObjects>False</ProtectObjects>
   <ProtectScenarios>False</ProtectScenarios>
  </WorksheetOptions>
 </Worksheet>
</Workbook>
<?php }} ?>
