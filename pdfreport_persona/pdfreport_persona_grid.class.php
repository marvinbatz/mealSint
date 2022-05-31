<?php
class pdfreport_persona_grid
{
   var $Ini;
   var $Erro;
   var $Pdf;
   var $Db;
   var $rs_grid;
   var $nm_grid_sem_reg;
   var $SC_seq_register;
   var $nm_location;
   var $nm_data;
   var $nm_cod_barra;
   var $sc_proc_grid; 
   var $nmgp_botoes = array();
   var $Campos_Mens_erro;
   var $NM_raiz_img; 
   var $Font_ttf; 
   var $logo = array();
   var $qr = array();
   var $codbar = array();
   var $p_idpersona = array();
   var $p_foto = array();
   var $p_nombre = array();
   var $p_noidentificacion = array();
   var $p_fechadenacimiento = array();
   var $anios = array();
   var $ec_nombre = array();
   var $co_nombre = array();
   var $p_email = array();
   var $p_telefono = array();
   var $p_cargo = array();
   var $p_institucion = array();
//--- 
 function monta_grid($linhas = 0)
 {

   clearstatcache();
   $this->inicializa();
   $this->grid();
 }
//--- 
 function inicializa()
 {
   global $nm_saida, 
   $rec, $nmgp_chave, $nmgp_opcao, $nmgp_ordem, $nmgp_chave_det, 
   $nmgp_quant_linhas, $nmgp_quant_colunas, $nmgp_url_saida, $nmgp_parms;
//
   include_once($this->Ini->path_third . "/barcodegen/class/BCGFont.php");
   include_once($this->Ini->path_third . "/barcodegen/class/BCGColor.php");
   include_once($this->Ini->path_third . "/barcodegen/class/BCGDrawing.php");
   include_once($this->Ini->path_third . "/barcodegen/class/BCGcode128.barcode.php");
   $this->nm_data = new nm_data("es");
   include_once("../_lib/lib/php/nm_font_tcpdf.php");
   $this->default_font = '';
   $this->default_font_sr  = '';
   $this->default_style    = '';
   $this->default_style_sr = 'B';
   $Tp_papel = array(110, 170);
   $old_dir = getcwd();
   $File_font_ttf     = "";
   $temp_font_ttf     = "";
   $this->Font_ttf    = false;
   $this->Font_ttf_sr = false;
   if (empty($this->default_font) && isset($arr_font_tcpdf[$this->Ini->str_lang]))
   {
       $this->default_font = $arr_font_tcpdf[$this->Ini->str_lang];
   }
   elseif (empty($this->default_font))
   {
       $this->default_font = "Times";
   }
   if (empty($this->default_font_sr) && isset($arr_font_tcpdf[$this->Ini->str_lang]))
   {
       $this->default_font_sr = $arr_font_tcpdf[$this->Ini->str_lang];
   }
   elseif (empty($this->default_font_sr))
   {
       $this->default_font_sr = "Times";
   }
   $_SESSION['scriptcase']['pdfreport_persona']['default_font'] = $this->default_font;
   chdir($this->Ini->path_third . "/tcpdf/");
   include_once("tcpdf.php");
   chdir($old_dir);
   $this->Pdf = new TCPDF('P', 'mm', $Tp_papel, true, 'UTF-8', false);
   $this->Pdf->setPrintHeader(false);
   $this->Pdf->setPrintFooter(false);
   if (!empty($File_font_ttf))
   {
       $this->Pdf->addTTFfont($File_font_ttf, "", "", 32, $_SESSION['scriptcase']['dir_temp'] . "/");
   }
   $this->Pdf->SetDisplayMode('real');
   $this->aba_iframe = false;
   if (isset($_SESSION['scriptcase']['sc_aba_iframe']))
   {
       foreach ($_SESSION['scriptcase']['sc_aba_iframe'] as $aba => $apls_aba)
       {
           if (in_array("pdfreport_persona", $apls_aba))
           {
               $this->aba_iframe = true;
               break;
           }
       }
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['iframe_menu'] && (!isset($_SESSION['scriptcase']['menu_mobile']) || empty($_SESSION['scriptcase']['menu_mobile'])))
   {
       $this->aba_iframe = true;
   }
   $this->nmgp_botoes['exit'] = "on";
   $this->sc_proc_grid = false; 
   $this->NM_raiz_img = $this->Ini->root;
   $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
   $this->nm_where_dinamico = "";
   $this->nm_grid_colunas = 0;
   if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['campos_busca']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['campos_busca']))
   { 
       $Busca_temp = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['campos_busca'];
       if ($_SESSION['scriptcase']['charset'] != "UTF-8")
       {
           $Busca_temp = NM_conv_charset($Busca_temp, $_SESSION['scriptcase']['charset'], "UTF-8");
       }
       $this->p_idpersona[0] = $Busca_temp['p_idpersona']; 
       $tmp_pos = strpos($this->p_idpersona[0], "##@@");
       if ($tmp_pos !== false && !is_array($this->p_idpersona[0]))
       {
           $this->p_idpersona[0] = substr($this->p_idpersona[0], 0, $tmp_pos);
       }
       $this->p_foto[0] = $Busca_temp['p_foto']; 
       $tmp_pos = strpos($this->p_foto[0], "##@@");
       if ($tmp_pos !== false && !is_array($this->p_foto[0]))
       {
           $this->p_foto[0] = substr($this->p_foto[0], 0, $tmp_pos);
       }
       $this->p_nombre[0] = $Busca_temp['p_nombre']; 
       $tmp_pos = strpos($this->p_nombre[0], "##@@");
       if ($tmp_pos !== false && !is_array($this->p_nombre[0]))
       {
           $this->p_nombre[0] = substr($this->p_nombre[0], 0, $tmp_pos);
       }
       $this->p_noidentificacion[0] = $Busca_temp['p_noidentificacion']; 
       $tmp_pos = strpos($this->p_noidentificacion[0], "##@@");
       if ($tmp_pos !== false && !is_array($this->p_noidentificacion[0]))
       {
           $this->p_noidentificacion[0] = substr($this->p_noidentificacion[0], 0, $tmp_pos);
       }
   } 
   $this->nm_field_dinamico = array();
   $this->nm_order_dinamico = array();
   $this->sc_where_orig   = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['where_orig'];
   $this->sc_where_atual  = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['where_pesq'];
   $this->sc_where_filtro = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['where_pesq_filtro'];
   $dir_raiz          = strrpos($_SERVER['PHP_SELF'],"/") ;  
   $dir_raiz          = substr($_SERVER['PHP_SELF'], 0, $dir_raiz + 1) ;  
   $this->nm_location = $this->Ini->sc_protocolo . $this->Ini->server . $dir_raiz; 
   $_SESSION['scriptcase']['contr_link_emb'] = $this->nm_location;
   $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['qt_col_grid'] = 1 ;  
   if (isset($_SESSION['scriptcase']['sc_apl_conf']['pdfreport_persona']['cols']) && !empty($_SESSION['scriptcase']['sc_apl_conf']['pdfreport_persona']['cols']))
   {
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['qt_col_grid'] = $_SESSION['scriptcase']['sc_apl_conf']['pdfreport_persona']['cols'];  
       unset($_SESSION['scriptcase']['sc_apl_conf']['pdfreport_persona']['cols']);
   }
   if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['ordem_select']))  
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['ordem_select'] = array(); 
   } 
   if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['ordem_quebra']))  
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['ordem_grid'] = "" ; 
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['ordem_ant']  = ""; 
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['ordem_desc'] = "" ; 
   }   
   if (!empty($nmgp_parms) && $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['opcao'] != "pdf")   
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['opcao'] = "igual";
       $rec = "ini";
   }
   if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['where_orig']) || $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['prim_cons'] || !empty($nmgp_parms))  
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['prim_cons'] = false;  
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['where_orig'] = " where p.idComunidad=c.idComunidad AND p.idEstadoCivil=eC.idEstadoCivil AND co.idComunidad=p.idComunidad AND p.idPersona=" . $_SESSION['gloPersona'] . "";  
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['where_pesq']        = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['where_orig'];  
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['where_pesq_ant']    = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['where_orig'];  
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['cond_pesq']         = ""; 
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['where_pesq_filtro'] = "";
   }   
   if  (!empty($this->nm_where_dinamico)) 
   {   
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['where_pesq'] .= $this->nm_where_dinamico;
   }   
   $this->sc_where_orig   = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['where_orig'];
   $this->sc_where_atual  = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['where_pesq'];
   $this->sc_where_filtro = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['where_pesq_filtro'];
//
   if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['tot_geral'][1])) 
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['sc_total'] = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['tot_geral'][1] ;  
   }
   $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['where_pesq_ant'] = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['where_pesq'];  
//----- 
   if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mysql))
   { 
       $nmgp_select = "SELECT p.idPersona as p_idpersona, p.foto as p_foto, p.nombre as p_nombre, p.noIdentificacion as p_noidentificacion, p.fechaDeNacimiento as p_fechadenacimiento, YEAR( CURDATE( ) ) - YEAR( fechaDeNacimiento ) - IF( MONTH( CURDATE( ) ) < MONTH( fechaDeNacimiento),1,IF ( MONTH(CURDATE( )) = MONTH(fechaDeNacimiento),IF (DAY( CURDATE( ) ) < DAY( fechaDeNacimiento ),1,0 ),0)) as anios, eC.nombre as ec_nombre, co.nombre as co_nombre, p.email as p_email, p.telefono as p_telefono, p.cargo as p_cargo, p.institucion as p_institucion from " . $this->Ini->nm_tabela; 
   } 
   else 
   { 
       $nmgp_select = "SELECT p.idPersona as p_idpersona, p.foto as p_foto, p.nombre as p_nombre, p.noIdentificacion as p_noidentificacion, p.fechaDeNacimiento as p_fechadenacimiento, YEAR( CURDATE( ) ) - YEAR( fechaDeNacimiento ) - IF( MONTH( CURDATE( ) ) < MONTH( fechaDeNacimiento),1,IF ( MONTH(CURDATE( )) = MONTH(fechaDeNacimiento),IF (DAY( CURDATE( ) ) < DAY( fechaDeNacimiento ),1,0 ),0)) as anios, eC.nombre as ec_nombre, co.nombre as co_nombre, p.email as p_email, p.telefono as p_telefono, p.cargo as p_cargo, p.institucion as p_institucion from " . $this->Ini->nm_tabela; 
   } 
   $nmgp_select .= " " . $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['where_pesq']; 
   $nmgp_order_by = ""; 
   $campos_order_select = "";
   foreach($_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['ordem_select'] as $campo => $ordem) 
   {
        if ($campo != $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['ordem_grid']) 
        {
           if (!empty($campos_order_select)) 
           {
               $campos_order_select .= ", ";
           }
           $campos_order_select .= $campo . " " . $ordem;
        }
   }
   if (!empty($_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['ordem_grid'])) 
   { 
       $nmgp_order_by = " order by " . $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['ordem_grid'] . $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['ordem_desc']; 
   } 
   if (!empty($campos_order_select)) 
   { 
       if (!empty($nmgp_order_by)) 
       { 
          $nmgp_order_by .= ", " . $campos_order_select; 
       } 
       else 
       { 
          $nmgp_order_by = " order by $campos_order_select"; 
       } 
   } 
   $nmgp_select .= $nmgp_order_by; 
   $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['order_grid'] = $nmgp_order_by;
   $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nmgp_select; 
   $this->rs_grid = $this->Db->Execute($nmgp_select) ; 
   if ($this->rs_grid === false && !$this->rs_grid->EOF && $GLOBALS["NM_ERRO_IBASE"] != 1) 
   { 
       $this->Erro->mensagem(__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg()); 
       exit ; 
   }  
   if ($this->rs_grid->EOF || ($this->rs_grid === false && $GLOBALS["NM_ERRO_IBASE"] == 1)) 
   { 
       $this->nm_grid_sem_reg = $this->SC_conv_utf8($this->Ini->Nm_lang['lang_errm_empt']); 
   }  
// 
 }  
// 
 function Pdf_init()
 {
     if ($_SESSION['scriptcase']['reg_conf']['css_dir'] == "RTL")
     {
         $this->Pdf->setRTL(true);
     }
     $this->Pdf->setHeaderMargin(0);
     $this->Pdf->setFooterMargin(0);
     if ($this->Font_ttf)
     {
         $this->Pdf->SetFont($this->default_font, $this->default_style, 12, $this->def_TTF);
     }
     else
     {
         $this->Pdf->SetFont($this->default_font, $this->default_style, 12);
     }
     $this->Pdf->SetTextColor(0, 0, 0);
 }
// 
 function Pdf_image()
 {
   if ($_SESSION['scriptcase']['reg_conf']['css_dir'] == "RTL")
   {
       $this->Pdf->setRTL(false);
   }
   $SV_margin = $this->Pdf->getBreakMargin();
   $SV_auto_page_break = $this->Pdf->getAutoPageBreak();
   $this->Pdf->SetAutoPageBreak(false, 0);
   $this->Pdf->Image($this->NM_raiz_img . $this->Ini->path_img_global . "/usr__NM__bg__NM__carneFondo.jpg", "0.000000", "0.000000", "110", "170", '', '', '', false, 300, '', false, false, 0);
   $this->Pdf->SetAutoPageBreak($SV_auto_page_break, $SV_margin);
   $this->Pdf->setPageMark();
   if ($_SESSION['scriptcase']['reg_conf']['css_dir'] == "RTL")
   {
       $this->Pdf->setRTL(true);
   }
 }
// 
//----- 
 function grid($linhas = 0)
 {
    global 
           $nm_saida, $nm_url_saida;
   $HTTP_REFERER = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : ""; 
   $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['seq_dir'] = 0; 
   $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['sub_dir'] = array(); 
   $this->sc_where_orig   = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['where_orig'];
   $this->sc_where_atual  = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['where_pesq'];
   $this->sc_where_filtro = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['where_pesq_filtro'];
   if (isset($_SESSION['scriptcase']['sc_apl_conf']['pdfreport_persona']['lig_edit']) && $_SESSION['scriptcase']['sc_apl_conf']['pdfreport_persona']['lig_edit'] != '')
   {
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['mostra_edit'] = $_SESSION['scriptcase']['sc_apl_conf']['pdfreport_persona']['lig_edit'];
   }
   if (!empty($this->nm_grid_sem_reg))
   {
       $this->Pdf_init();
       $this->Pdf->AddPage();
       if ($this->Font_ttf_sr)
       {
           $this->Pdf->SetFont($this->default_font_sr, 'B', 12, $this->def_TTF);
       }
       else
       {
           $this->Pdf->SetFont($this->default_font_sr, 'B', 12);
       }
       $this->Pdf->Text(30.000000, 0.000000, html_entity_decode($this->nm_grid_sem_reg, ENT_COMPAT, $_SESSION['scriptcase']['charset']));
       $this->Pdf->Output($this->Ini->root . $this->Ini->nm_path_pdf, 'F');
       return;
   }
// 
   $Init_Pdf = true;
   $this->SC_seq_register = 0; 
   while (!$this->rs_grid->EOF) 
   {  
      $this->nm_grid_colunas = 0; 
      $nm_quant_linhas = 0;
      $this->Pdf->setImageScale(1.33);
      $this->Pdf->AddPage();
      $this->Pdf_init();
      $this->Pdf_image();
      while (!$this->rs_grid->EOF && $nm_quant_linhas < $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_persona']['qt_col_grid']) 
      {  
          $this->sc_proc_grid = true;
          $this->SC_seq_register++; 
          $this->p_idpersona[$this->nm_grid_colunas] = $this->rs_grid->fields[0] ;  
          $this->p_idpersona[$this->nm_grid_colunas] = (string)$this->p_idpersona[$this->nm_grid_colunas];
       $this->p_foto[$this->nm_grid_colunas] = $this->rs_grid->fields[1] ;  
          $this->p_nombre[$this->nm_grid_colunas] = $this->rs_grid->fields[2] ;  
          $this->p_noidentificacion[$this->nm_grid_colunas] = $this->rs_grid->fields[3] ;  
          $this->p_fechadenacimiento[$this->nm_grid_colunas] = $this->rs_grid->fields[4] ;  
          $this->anios[$this->nm_grid_colunas] = $this->rs_grid->fields[5] ;  
          $this->anios[$this->nm_grid_colunas] = (string)$this->anios[$this->nm_grid_colunas];
          $this->ec_nombre[$this->nm_grid_colunas] = $this->rs_grid->fields[6] ;  
          $this->co_nombre[$this->nm_grid_colunas] = $this->rs_grid->fields[7] ;  
          $this->p_email[$this->nm_grid_colunas] = $this->rs_grid->fields[8] ;  
          $this->p_telefono[$this->nm_grid_colunas] = $this->rs_grid->fields[9] ;  
          $this->p_cargo[$this->nm_grid_colunas] = $this->rs_grid->fields[10] ;  
          $this->p_institucion[$this->nm_grid_colunas] = $this->rs_grid->fields[11] ;  
          $this->logo[$this->nm_grid_colunas] = "";
          $this->qr[$this->nm_grid_colunas] = "";
          $this->codbar[$this->nm_grid_colunas] = "";
          $_SESSION['scriptcase']['pdfreport_persona']['contr_erro'] = 'on';
 $this->qr[$this->nm_grid_colunas]  = "No. de Identificación: ".$this->p_noidentificacion[$this->nm_grid_colunas] .
	" Nombre: ".$this->p_nombre[$this->nm_grid_colunas] .
	" Años: ".$this->anios[$this->nm_grid_colunas] .
" Estado Civil: ".$this->ec_nombre[$this->nm_grid_colunas] .
" Comunidad: ".$this->co_nombre[$this->nm_grid_colunas] ;
$this->codbar[$this->nm_grid_colunas]  = $this->p_idpersona[$this->nm_grid_colunas] ;
$_SESSION['scriptcase']['pdfreport_persona']['contr_erro'] = 'off';
          $this->p_idpersona[$this->nm_grid_colunas] = sc_strip_script($this->p_idpersona[$this->nm_grid_colunas]);
          if ($this->p_idpersona[$this->nm_grid_colunas] === "") 
          { 
              $this->p_idpersona[$this->nm_grid_colunas] = "" ;  
          } 
          else    
          { 
              nmgp_Form_Num_Val($this->p_idpersona[$this->nm_grid_colunas], $_SESSION['scriptcase']['reg_conf']['grup_num'], $_SESSION['scriptcase']['reg_conf']['dec_num'], "0", "S", "2", "", "N:" . $_SESSION['scriptcase']['reg_conf']['neg_num'] , $_SESSION['scriptcase']['reg_conf']['simb_neg'], $_SESSION['scriptcase']['reg_conf']['num_group_digit']) ; 
          } 
          $this->p_idpersona[$this->nm_grid_colunas] = $this->SC_conv_utf8($this->p_idpersona[$this->nm_grid_colunas]);
          $this->p_foto[$this->nm_grid_colunas] = $this->p_foto[$this->nm_grid_colunas]; 
          if (empty($this->p_foto[$this->nm_grid_colunas]) || $this->p_foto[$this->nm_grid_colunas] == "none" || $this->p_foto[$this->nm_grid_colunas] == "*nm*") 
          { 
              $this->p_foto[$this->nm_grid_colunas] = "" ;  
              $out_p_foto = "" ; 
          } 
          elseif ($this->Ini->Gd_missing)
          { 
              $this->p_foto[$this->nm_grid_colunas] = "<span class=\"scErrorLine\">" . $this->Ini->Nm_lang['lang_errm_gd'] . "</span>";
          } 
          else 
          { 
              $this->p_foto[$this->nm_grid_colunas] = $this->Ini->root . $this->Ini->path_imagens . "fotosBeneficiarios" . "/" .  $this->p_foto[$this->nm_grid_colunas];
              $out_p_foto = $this->Ini->path_imag_temp . "/sc_p_foto_170170" . $_SESSION['scriptcase']['sc_num_img'] . ".jpg" ;  
              if (is_file($this->p_foto[$this->nm_grid_colunas])) 
              { 
                  $sc_obj_img = new nm_trata_img($this->p_foto[$this->nm_grid_colunas]);
                  $sc_obj_img->setWidth(170);
                  $sc_obj_img->setHeight(170);
                  $sc_obj_img->setManterAspecto(true);
                  $sc_obj_img->createImg($this->Ini->root . $out_p_foto);
              } 
              $this->p_foto[$this->nm_grid_colunas] = $this->NM_raiz_img . $out_p_foto;
              $_SESSION['scriptcase']['sc_num_img']++;
          } 
          $this->p_nombre[$this->nm_grid_colunas] = sc_strip_script($this->p_nombre[$this->nm_grid_colunas]);
          if ($this->p_nombre[$this->nm_grid_colunas] === "") 
          { 
              $this->p_nombre[$this->nm_grid_colunas] = "" ;  
          } 
          $this->p_nombre[$this->nm_grid_colunas] = $this->SC_conv_utf8($this->p_nombre[$this->nm_grid_colunas]);
          $this->p_noidentificacion[$this->nm_grid_colunas] = sc_strip_script($this->p_noidentificacion[$this->nm_grid_colunas]);
          if ($this->p_noidentificacion[$this->nm_grid_colunas] === "") 
          { 
              $this->p_noidentificacion[$this->nm_grid_colunas] = "" ;  
          } 
          $this->p_noidentificacion[$this->nm_grid_colunas] = $this->SC_conv_utf8($this->p_noidentificacion[$this->nm_grid_colunas]);
          $this->p_fechadenacimiento[$this->nm_grid_colunas] = sc_strip_script($this->p_fechadenacimiento[$this->nm_grid_colunas]);
          if ($this->p_fechadenacimiento[$this->nm_grid_colunas] === "") 
          { 
              $this->p_fechadenacimiento[$this->nm_grid_colunas] = "" ;  
          } 
          else    
          { 
               $p_fechadenacimiento_x =  $this->p_fechadenacimiento[$this->nm_grid_colunas];
               nm_conv_limpa_dado($p_fechadenacimiento_x, "YYYY-MM-DD");
               if (is_numeric($p_fechadenacimiento_x) && strlen($p_fechadenacimiento_x) > 0) 
               { 
                   $this->nm_data->SetaData($this->p_fechadenacimiento[$this->nm_grid_colunas], "YYYY-MM-DD");
                   $this->p_fechadenacimiento[$this->nm_grid_colunas] = html_entity_decode($this->nm_data->FormataSaida($this->nm_data->FormatRegion("DT", "ddmmaaaa")), ENT_COMPAT, $_SESSION['scriptcase']['charset']);
               } 
          } 
          $this->p_fechadenacimiento[$this->nm_grid_colunas] = $this->SC_conv_utf8($this->p_fechadenacimiento[$this->nm_grid_colunas]);
          $this->anios[$this->nm_grid_colunas] = sc_strip_script($this->anios[$this->nm_grid_colunas]);
          if ($this->anios[$this->nm_grid_colunas] === "") 
          { 
              $this->anios[$this->nm_grid_colunas] = "" ;  
          } 
          else    
          { 
              nmgp_Form_Num_Val($this->anios[$this->nm_grid_colunas], $_SESSION['scriptcase']['reg_conf']['grup_num'], $_SESSION['scriptcase']['reg_conf']['dec_num'], "0", "S", "2", "", "N:" . $_SESSION['scriptcase']['reg_conf']['neg_num'] , $_SESSION['scriptcase']['reg_conf']['simb_neg'], $_SESSION['scriptcase']['reg_conf']['num_group_digit']) ; 
          } 
          $this->anios[$this->nm_grid_colunas] = $this->SC_conv_utf8($this->anios[$this->nm_grid_colunas]);
          $this->ec_nombre[$this->nm_grid_colunas] = sc_strip_script($this->ec_nombre[$this->nm_grid_colunas]);
          if ($this->ec_nombre[$this->nm_grid_colunas] === "") 
          { 
              $this->ec_nombre[$this->nm_grid_colunas] = "" ;  
          } 
          $this->ec_nombre[$this->nm_grid_colunas] = $this->SC_conv_utf8($this->ec_nombre[$this->nm_grid_colunas]);
          $this->co_nombre[$this->nm_grid_colunas] = sc_strip_script($this->co_nombre[$this->nm_grid_colunas]);
          if ($this->co_nombre[$this->nm_grid_colunas] === "") 
          { 
              $this->co_nombre[$this->nm_grid_colunas] = "" ;  
          } 
          $this->co_nombre[$this->nm_grid_colunas] = $this->SC_conv_utf8($this->co_nombre[$this->nm_grid_colunas]);
          $this->p_email[$this->nm_grid_colunas] = sc_strip_script($this->p_email[$this->nm_grid_colunas]);
          if ($this->p_email[$this->nm_grid_colunas] === "") 
          { 
              $this->p_email[$this->nm_grid_colunas] = "" ;  
          } 
          $this->p_email[$this->nm_grid_colunas] = $this->SC_conv_utf8($this->p_email[$this->nm_grid_colunas]);
          $this->p_telefono[$this->nm_grid_colunas] = sc_strip_script($this->p_telefono[$this->nm_grid_colunas]);
          if ($this->p_telefono[$this->nm_grid_colunas] === "") 
          { 
              $this->p_telefono[$this->nm_grid_colunas] = "" ;  
          } 
          $this->p_telefono[$this->nm_grid_colunas] = $this->SC_conv_utf8($this->p_telefono[$this->nm_grid_colunas]);
          $this->p_cargo[$this->nm_grid_colunas] = sc_strip_script($this->p_cargo[$this->nm_grid_colunas]);
          if ($this->p_cargo[$this->nm_grid_colunas] === "") 
          { 
              $this->p_cargo[$this->nm_grid_colunas] = "" ;  
          } 
          $this->p_cargo[$this->nm_grid_colunas] = $this->SC_conv_utf8($this->p_cargo[$this->nm_grid_colunas]);
          $this->p_institucion[$this->nm_grid_colunas] = sc_strip_script($this->p_institucion[$this->nm_grid_colunas]);
          if ($this->p_institucion[$this->nm_grid_colunas] === "") 
          { 
              $this->p_institucion[$this->nm_grid_colunas] = "" ;  
          } 
          $this->p_institucion[$this->nm_grid_colunas] = $this->SC_conv_utf8($this->p_institucion[$this->nm_grid_colunas]);
          if ($this->logo[$this->nm_grid_colunas] === "") 
          { 
              $this->logo[$this->nm_grid_colunas] = "" ;  
          } 
          elseif ($this->Ini->Gd_missing)
          { 
              $this->logo[$this->nm_grid_colunas] = "<span class=\"scErrorLine\">" . $this->Ini->Nm_lang['lang_errm_gd'] . "</span>";
          } 
          else 
          { 
              $this->logo[$this->nm_grid_colunas] = $this->Ini->root . $this->Ini->path_imagens . "logo" . "/" .  $this->logo[$this->nm_grid_colunas];
              $out_logo = $this->Ini->path_imag_temp . "/sc_logo_100100" . $_SESSION['scriptcase']['sc_num_img'] . ".jpg" ;  
              if (is_file($this->logo[$this->nm_grid_colunas])) 
              { 
                  $sc_obj_img = new nm_trata_img($this->logo[$this->nm_grid_colunas]);
                  $sc_obj_img->setWidth(100);
                  $sc_obj_img->setHeight(100);
                  $sc_obj_img->setManterAspecto(true);
                  $sc_obj_img->createImg($this->Ini->root . $out_logo);
              } 
              $this->logo[$this->nm_grid_colunas] = $this->NM_raiz_img . $out_logo;
              $_SESSION['scriptcase']['sc_num_img']++;
          } 
          if ($this->qr[$this->nm_grid_colunas] === "") 
          { 
              $this->qr[$this->nm_grid_colunas] = "" ;  
          } 
          elseif ($this->Ini->Gd_missing)
          { 
              $this->qr[$this->nm_grid_colunas] = "<span class=\"scErrorLine\">" . $this->Ini->Nm_lang['lang_errm_gd'] . "</span>";
              $out_qr = "" ; 
          } 
          else   
          { 
              $out_qr = $this->Ini->path_imag_temp . "/sc_qr_" . $_SESSION['scriptcase']['sc_num_img'] . session_id() . ".png";   
              QRcode::png($this->qr[$this->nm_grid_colunas], $this->Ini->root . $out_qr, 3,3,0);
              $_SESSION['scriptcase']['sc_num_img']++;
          } 
              $this->qr[$this->nm_grid_colunas] = $this->NM_raiz_img . $out_qr;
          $this->qr[$this->nm_grid_colunas] = $this->SC_conv_utf8($this->qr[$this->nm_grid_colunas]);
          if ($this->codbar[$this->nm_grid_colunas] === "") 
          { 
              $this->codbar[$this->nm_grid_colunas] = "" ;  
          } 
          elseif ($this->Ini->Gd_missing)
          { 
              $this->codbar[$this->nm_grid_colunas] = "<span class=\"scErrorLine\">" . $this->Ini->Nm_lang['lang_errm_gd'] . "</span>";
          } 
          else   
          { 
              $Font_bar = new BCGFont($this->Ini->path_third . '/barcodegen/class/font/Arial.ttf', 8);
              $Color_black = new BCGColor(0, 0, 0);
              $Color_white = new BCGColor(255, 255, 255);
              $out_codbar = $this->Ini->path_imag_temp . "/sc_code128_" . $_SESSION['scriptcase']['sc_num_img'] . session_id() . ".png";
              $_SESSION['scriptcase']['sc_num_img']++ ;
              $this->codbar[$this->nm_grid_colunas] = (string) $this->codbar[$this->nm_grid_colunas];
              $Code_bar = new BCGcode128();
              $Code_bar->setScale(3);
              $Code_bar->setThickness(30);
              $Code_bar->setForegroundColor($Color_black);
              $Code_bar->setBackgroundColor($Color_white);
              $Code_bar->setFont($Font_bar);
              $Code_bar->setTilde(true);
              $Code_bar->parse($this->codbar[$this->nm_grid_colunas]);
              $Drawing_bar = new BCGDrawing($this->Ini->root . $out_codbar, $Color_white);
              $Drawing_bar->setBarcode($Code_bar);
              $Drawing_bar->setDPI(72);
              $Drawing_bar->draw();
              $Drawing_bar->finish(BCGDrawing::IMG_FORMAT_PNG);
          } 
              $this->codbar[$this->nm_grid_colunas] = $this->NM_raiz_img . $out_codbar;
          $this->codbar[$this->nm_grid_colunas] = $this->SC_conv_utf8($this->codbar[$this->nm_grid_colunas]);
            $cell_p_foto = array('posx' => '4.7046356249994075', 'posy' => '34.28021041666234', 'data' => $this->p_foto[$this->nm_grid_colunas], 'width'      => '0', 'align'      => 'L', 'font_type'  => $this->default_font, 'font_size'  => '12', 'color_r'    => '0', 'color_g'    => '0', 'color_b'    => '0', 'font_style' => $this->default_style);
            $cell_QR = array('posx' => '54.487762499993124', 'posy' => '33.751043749995745', 'data' => $this->qr[$this->nm_grid_colunas], 'width'      => '0', 'align'      => 'L', 'font_type'  => $this->default_font, 'font_size'  => '12', 'color_r'    => '0', 'color_g'    => '0', 'color_b'    => '0', 'font_style' => $this->default_style);
            $cell_p_nombre = array('posx' => '5.490104166665975', 'posy' => '102.74934999998705', 'data' => $this->p_nombre[$this->nm_grid_colunas], 'width'      => '2', 'align'      => 'L', 'font_type'  => 'Helvetica', 'font_size'  => '15', 'color_r'    => '255', 'color_g'    => '255', 'color_b'    => '255', 'font_style' => B);
            $cell_codbar = array('posx' => '61.88366041665887', 'posy' => '121.59271041665133', 'data' => $this->codbar[$this->nm_grid_colunas], 'width'      => '2', 'align'      => 'L', 'font_type'  => $this->default_font, 'font_size'  => '5', 'color_r'    => '0', 'color_g'    => '0', 'color_b'    => '0', 'font_style' => $this->default_style);

            if (isset($cell_p_foto['data']) && !empty($cell_p_foto['data']) && is_file($cell_p_foto['data']))
            {
                $Finfo_img = finfo_open(FILEINFO_MIME_TYPE);
                $Tipo_img  = finfo_file($Finfo_img, $cell_p_foto['data']);
                finfo_close($Finfo_img);
                if (substr($Tipo_img, 0, 5) == "image")
                {
                    $this->Pdf->Image($cell_p_foto['data'], $cell_p_foto['posx'], $cell_p_foto['posy'], 0, 0);
                }
            }
            if (isset($cell_QR['data']) && !empty($cell_QR['data']) && is_file($cell_QR['data']))
            {
                $Finfo_img = finfo_open(FILEINFO_MIME_TYPE);
                $Tipo_img  = finfo_file($Finfo_img, $cell_QR['data']);
                finfo_close($Finfo_img);
                if (substr($Tipo_img, 0, 5) == "image")
                {
                    $this->Pdf->Image($cell_QR['data'], $cell_QR['posx'], $cell_QR['posy'], 0, 0);
                }
            }

            $this->Pdf->SetFont($cell_p_nombre['font_type'], $cell_p_nombre['font_style'], $cell_p_nombre['font_size']);
            $this->pdf_text_color($cell_p_nombre['data'], $cell_p_nombre['color_r'], $cell_p_nombre['color_g'], $cell_p_nombre['color_b']);
            if (!empty($cell_p_nombre['posx']) && !empty($cell_p_nombre['posy']))
            {
                $this->Pdf->SetXY($cell_p_nombre['posx'], $cell_p_nombre['posy']);
            }
            elseif (!empty($cell_p_nombre['posx']))
            {
                $this->Pdf->SetX($cell_p_nombre['posx']);
            }
            elseif (!empty($cell_p_nombre['posy']))
            {
                $this->Pdf->SetY($cell_p_nombre['posy']);
            }
            $this->Pdf->Cell($cell_p_nombre['width'], 0, $cell_p_nombre['data'], 0, 0, $cell_p_nombre['align']);

            if (isset($cell_codbar['data']) && !empty($cell_codbar['data']) && is_file($cell_codbar['data']))
            {
                $Finfo_img = finfo_open(FILEINFO_MIME_TYPE);
                $Tipo_img  = finfo_file($Finfo_img, $cell_codbar['data']);
                finfo_close($Finfo_img);
                if (substr($Tipo_img, 0, 5) == "image")
                {
                    $this->Pdf->Image($cell_codbar['data'], $cell_codbar['posx'], $cell_codbar['posy'], 0, 0);
                }
            }
          $max_Y = 0;
          $this->rs_grid->MoveNext();
          $this->sc_proc_grid = false;
          $nm_quant_linhas++ ;
      }  
   }  
   $this->rs_grid->Close();
   $this->Pdf->Output($this->Ini->root . $this->Ini->nm_path_pdf, 'F');
 }
 function pdf_text_color(&$val, $r, $g, $b)
 {
     $pos = strpos($val, "@SCNEG#");
     if ($pos !== false)
     {
         $cor = trim(substr($val, $pos + 7));
         $val = substr($val, 0, $pos);
         $cor = (substr($cor, 0, 1) == "#") ? substr($cor, 1) : $cor;
         if (strlen($cor) == 6)
         {
             $r = hexdec(substr($cor, 0, 2));
             $g = hexdec(substr($cor, 2, 2));
             $b = hexdec(substr($cor, 4, 2));
         }
     }
     $this->Pdf->SetTextColor($r, $g, $b);
 }
 function SC_conv_utf8($input)
 {
     if ($_SESSION['scriptcase']['charset'] != "UTF-8" && !NM_is_utf8($input))
     {
         $input = sc_convert_encoding($input, "UTF-8", $_SESSION['scriptcase']['charset']);
     }
     return $input;
 }
   function nm_conv_data_db($dt_in, $form_in, $form_out)
   {
       $dt_out = $dt_in;
       if (strtoupper($form_in) == "DB_FORMAT") {
           if ($dt_out == "null" || $dt_out == "")
           {
               $dt_out = "";
               return $dt_out;
           }
           $form_in = "AAAA-MM-DD";
       }
       if (strtoupper($form_out) == "DB_FORMAT") {
           if (empty($dt_out))
           {
               $dt_out = "null";
               return $dt_out;
           }
           $form_out = "AAAA-MM-DD";
       }
       if (strtoupper($form_out) == "SC_FORMAT_REGION") {
           $this->nm_data->SetaData($dt_in, strtoupper($form_in));
           $prep_out  = (strpos(strtolower($form_in), "dd") !== false) ? "dd" : "";
           $prep_out .= (strpos(strtolower($form_in), "mm") !== false) ? "mm" : "";
           $prep_out .= (strpos(strtolower($form_in), "aa") !== false) ? "aaaa" : "";
           $prep_out .= (strpos(strtolower($form_in), "yy") !== false) ? "aaaa" : "";
           return $this->nm_data->FormataSaida($this->nm_data->FormatRegion("DT", $prep_out));
       }
       else {
           nm_conv_form_data($dt_out, $form_in, $form_out);
           return $dt_out;
       }
   }
   function nm_gera_mask(&$nm_campo, $nm_mask)
   { 
      $trab_campo = $nm_campo;
      $trab_mask  = $nm_mask;
      $tam_campo  = strlen($nm_campo);
      $trab_saida = "";
      $str_highlight_ini = "";
      $str_highlight_fim = "";
      if(substr($nm_campo, 0, 23) == '<div class="highlight">' && substr($nm_campo, -6) == '</div>')
      {
           $str_highlight_ini = substr($nm_campo, 0, 23);
           $str_highlight_fim = substr($nm_campo, -6);

           $trab_campo = substr($nm_campo, 23, -6);
           $tam_campo  = strlen($trab_campo);
      }      $mask_num = false;
      for ($x=0; $x < strlen($trab_mask); $x++)
      {
          if (substr($trab_mask, $x, 1) == "#")
          {
              $mask_num = true;
              break;
          }
      }
      if ($mask_num )
      {
          $ver_duas = explode(";", $trab_mask);
          if (isset($ver_duas[1]) && !empty($ver_duas[1]))
          {
              $cont1 = count(explode("#", $ver_duas[0])) - 1;
              $cont2 = count(explode("#", $ver_duas[1])) - 1;
              if ($tam_campo >= $cont2)
              {
                  $trab_mask = $ver_duas[1];
              }
              else
              {
                  $trab_mask = $ver_duas[0];
              }
          }
          $tam_mask = strlen($trab_mask);
          $xdados = 0;
          for ($x=0; $x < $tam_mask; $x++)
          {
              if (substr($trab_mask, $x, 1) == "#" && $xdados < $tam_campo)
              {
                  $trab_saida .= substr($trab_campo, $xdados, 1);
                  $xdados++;
              }
              elseif ($xdados < $tam_campo)
              {
                  $trab_saida .= substr($trab_mask, $x, 1);
              }
          }
          if ($xdados < $tam_campo)
          {
              $trab_saida .= substr($trab_campo, $xdados);
          }
          $nm_campo = $str_highlight_ini . $trab_saida . $str_highlight_ini;
          return;
      }
      for ($ix = strlen($trab_mask); $ix > 0; $ix--)
      {
           $char_mask = substr($trab_mask, $ix - 1, 1);
           if ($char_mask != "x" && $char_mask != "z")
           {
               $trab_saida = $char_mask . $trab_saida;
           }
           else
           {
               if ($tam_campo != 0)
               {
                   $trab_saida = substr($trab_campo, $tam_campo - 1, 1) . $trab_saida;
                   $tam_campo--;
               }
               else
               {
                   $trab_saida = "0" . $trab_saida;
               }
           }
      }
      if ($tam_campo != 0)
      {
          $trab_saida = substr($trab_campo, 0, $tam_campo) . $trab_saida;
          $trab_mask  = str_repeat("z", $tam_campo) . $trab_mask;
      }
   
      $iz = 0; 
      for ($ix = 0; $ix < strlen($trab_mask); $ix++)
      {
           $char_mask = substr($trab_mask, $ix, 1);
           if ($char_mask != "x" && $char_mask != "z")
           {
               if ($char_mask == "." || $char_mask == ",")
               {
                   $trab_saida = substr($trab_saida, 0, $iz) . substr($trab_saida, $iz + 1);
               }
               else
               {
                   $iz++;
               }
           }
           elseif ($char_mask == "x" || substr($trab_saida, $iz, 1) != "0")
           {
               $ix = strlen($trab_mask) + 1;
           }
           else
           {
               $trab_saida = substr($trab_saida, 0, $iz) . substr($trab_saida, $iz + 1);
           }
      }
      $nm_campo = $str_highlight_ini . $trab_saida . $str_highlight_ini;
   } 
}
?>
