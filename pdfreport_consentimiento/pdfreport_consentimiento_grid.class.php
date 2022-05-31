<?php
class pdfreport_consentimiento_grid
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
   var $idproyecto = array();
   var $idproyecto_1 = array();
   var $idproyecto_2 = array();
   var $codsocio = array();
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
   $this->nm_data = new nm_data("es");
   include_once("../_lib/lib/php/nm_font_tcpdf.php");
   $this->default_font = '';
   $this->default_font_sr  = '';
   $this->default_style    = '';
   $this->default_style_sr = 'B';
   $Tp_papel = "LETTER";
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
   $_SESSION['scriptcase']['pdfreport_consentimiento']['default_font'] = $this->default_font;
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
           if (in_array("pdfreport_consentimiento", $apls_aba))
           {
               $this->aba_iframe = true;
               break;
           }
       }
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['iframe_menu'] && (!isset($_SESSION['scriptcase']['menu_mobile']) || empty($_SESSION['scriptcase']['menu_mobile'])))
   {
       $this->aba_iframe = true;
   }
   $this->nmgp_botoes['exit'] = "on";
   $this->sc_proc_grid = false; 
   $this->NM_raiz_img = $this->Ini->root;
   $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
   $this->nm_where_dinamico = "";
   $this->nm_grid_colunas = 0;
   if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['campos_busca']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['campos_busca']))
   { 
       $Busca_temp = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['campos_busca'];
       if ($_SESSION['scriptcase']['charset'] != "UTF-8")
       {
           $Busca_temp = NM_conv_charset($Busca_temp, $_SESSION['scriptcase']['charset'], "UTF-8");
       }
       $this->idproyecto[0] = $Busca_temp['idproyecto']; 
       $tmp_pos = strpos($this->idproyecto[0], "##@@");
       if ($tmp_pos !== false && !is_array($this->idproyecto[0]))
       {
           $this->idproyecto[0] = substr($this->idproyecto[0], 0, $tmp_pos);
       }
       $this->idproyecto_1[0] = $Busca_temp['idproyecto_1']; 
       $tmp_pos = strpos($this->idproyecto_1[0], "##@@");
       if ($tmp_pos !== false && !is_array($this->idproyecto_1[0]))
       {
           $this->idproyecto_1[0] = substr($this->idproyecto_1[0], 0, $tmp_pos);
       }
   } 
   $this->nm_field_dinamico = array();
   $this->nm_order_dinamico = array();
   $this->sc_where_orig   = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['where_orig'];
   $this->sc_where_atual  = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['where_pesq'];
   $this->sc_where_filtro = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['where_pesq_filtro'];
   $dir_raiz          = strrpos($_SERVER['PHP_SELF'],"/") ;  
   $dir_raiz          = substr($_SERVER['PHP_SELF'], 0, $dir_raiz + 1) ;  
   $this->nm_location = $this->Ini->sc_protocolo . $this->Ini->server . $dir_raiz; 
   $_SESSION['scriptcase']['contr_link_emb'] = $this->nm_location;
   $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['qt_col_grid'] = 1 ;  
   if (isset($_SESSION['scriptcase']['sc_apl_conf']['pdfreport_consentimiento']['cols']) && !empty($_SESSION['scriptcase']['sc_apl_conf']['pdfreport_consentimiento']['cols']))
   {
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['qt_col_grid'] = $_SESSION['scriptcase']['sc_apl_conf']['pdfreport_consentimiento']['cols'];  
       unset($_SESSION['scriptcase']['sc_apl_conf']['pdfreport_consentimiento']['cols']);
   }
   if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['ordem_select']))  
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['ordem_select'] = array(); 
   } 
   if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['ordem_quebra']))  
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['ordem_grid'] = "" ; 
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['ordem_ant']  = ""; 
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['ordem_desc'] = "" ; 
   }   
   if (!empty($nmgp_parms) && $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['opcao'] != "pdf")   
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['opcao'] = "igual";
       $rec = "ini";
   }
   if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['where_orig']) || $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['prim_cons'] || !empty($nmgp_parms))  
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['prim_cons'] = false;  
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['where_orig'] = " where idProyecto=" . $_SESSION['gloProyecto'] . " AND codSocio=\"" . $_SESSION['gloSocio'] . "\"";  
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['where_pesq']        = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['where_orig'];  
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['where_pesq_ant']    = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['where_orig'];  
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['cond_pesq']         = ""; 
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['where_pesq_filtro'] = "";
   }   
   if  (!empty($this->nm_where_dinamico)) 
   {   
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['where_pesq'] .= $this->nm_where_dinamico;
   }   
   $this->sc_where_orig   = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['where_orig'];
   $this->sc_where_atual  = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['where_pesq'];
   $this->sc_where_filtro = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['where_pesq_filtro'];
//
   if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['tot_geral'][1])) 
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['sc_total'] = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['tot_geral'][1] ;  
   }
   $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['where_pesq_ant'] = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['where_pesq'];  
//----- 
   if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mysql))
   { 
       $nmgp_select = "SELECT idProyecto, idProyecto as idproyecto_1, idProyecto as idproyecto_2, codSocio from " . $this->Ini->nm_tabela; 
   } 
   else 
   { 
       $nmgp_select = "SELECT idProyecto, idProyecto as idproyecto_1, idProyecto as idproyecto_2, codSocio from " . $this->Ini->nm_tabela; 
   } 
   $nmgp_select .= " " . $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['where_pesq']; 
   $nmgp_select .= " group by idProyecto"; 
   $nmgp_order_by = ""; 
   $campos_order_select = "";
   foreach($_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['ordem_select'] as $campo => $ordem) 
   {
        if ($campo != $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['ordem_grid']) 
        {
           if (!empty($campos_order_select)) 
           {
               $campos_order_select .= ", ";
           }
           $campos_order_select .= $campo . " " . $ordem;
        }
   }
   if (!empty($_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['ordem_grid'])) 
   { 
       $nmgp_order_by = " order by " . $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['ordem_grid'] . $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['ordem_desc']; 
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
   $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['order_grid'] = $nmgp_order_by;
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
   $this->Pdf->Image($this->NM_raiz_img . $this->Ini->path_img_global . "/usr__NM__bg__NM__consentimiento.jpg", "15", "7", "180", "270", '', '', '', false, 300, '', false, false, 0);
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
   $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['seq_dir'] = 0; 
   $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['sub_dir'] = array(); 
   $this->sc_where_orig   = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['where_orig'];
   $this->sc_where_atual  = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['where_pesq'];
   $this->sc_where_filtro = $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['where_pesq_filtro'];
   if (isset($_SESSION['scriptcase']['sc_apl_conf']['pdfreport_consentimiento']['lig_edit']) && $_SESSION['scriptcase']['sc_apl_conf']['pdfreport_consentimiento']['lig_edit'] != '')
   {
       $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['mostra_edit'] = $_SESSION['scriptcase']['sc_apl_conf']['pdfreport_consentimiento']['lig_edit'];
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
       $this->Pdf->Text(0.000000, 0.000000, html_entity_decode($this->nm_grid_sem_reg, ENT_COMPAT, $_SESSION['scriptcase']['charset']));
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
      while (!$this->rs_grid->EOF && $nm_quant_linhas < $_SESSION['sc_session'][$this->Ini->sc_page]['pdfreport_consentimiento']['qt_col_grid']) 
      {  
          $this->sc_proc_grid = true;
          $this->SC_seq_register++; 
          $this->idproyecto[$this->nm_grid_colunas] = $this->rs_grid->fields[0] ;  
          $this->idproyecto[$this->nm_grid_colunas] = (string)$this->idproyecto[$this->nm_grid_colunas];
          $this->idproyecto_1[$this->nm_grid_colunas] = $this->rs_grid->fields[1] ;  
          $this->idproyecto_1[$this->nm_grid_colunas] = (string)$this->idproyecto_1[$this->nm_grid_colunas];
          $this->idproyecto_2[$this->nm_grid_colunas] = $this->rs_grid->fields[2] ;  
          $this->idproyecto_2[$this->nm_grid_colunas] = (string)$this->idproyecto_2[$this->nm_grid_colunas];
          $this->codsocio[$this->nm_grid_colunas] = $this->rs_grid->fields[3] ;  
          $this->Lookup->lookup_idproyecto($this->idproyecto[$this->nm_grid_colunas] , $this->idproyecto[$this->nm_grid_colunas]) ; 
          $this->idproyecto[$this->nm_grid_colunas] = $this->SC_conv_utf8($this->idproyecto[$this->nm_grid_colunas]);
          $this->Lookup->lookup_idproyecto_1($this->idproyecto_1[$this->nm_grid_colunas] , $this->idproyecto_1[$this->nm_grid_colunas]) ; 
          $this->idproyecto_1[$this->nm_grid_colunas] = $this->SC_conv_utf8($this->idproyecto_1[$this->nm_grid_colunas]);
          $this->Lookup->lookup_idproyecto_2($this->idproyecto_2[$this->nm_grid_colunas] , $this->idproyecto_2[$this->nm_grid_colunas]) ; 
          $this->idproyecto_2[$this->nm_grid_colunas] = $this->SC_conv_utf8($this->idproyecto_2[$this->nm_grid_colunas]);
          $this->codsocio[$this->nm_grid_colunas] = sc_strip_script($this->codsocio[$this->nm_grid_colunas]);
          if ($this->codsocio[$this->nm_grid_colunas] === "") 
          { 
              $this->codsocio[$this->nm_grid_colunas] = "" ;  
          } 
          $this->codsocio[$this->nm_grid_colunas] = $this->SC_conv_utf8($this->codsocio[$this->nm_grid_colunas]);
            $cell_codSocio = array('posx' => '19.521222916664208', 'posy' => '14.705038958331482', 'data' => $this->codsocio[$this->nm_grid_colunas], 'width'      => '0', 'align'      => 'L', 'font_type'  => $this->default_font, 'font_size'  => '12', 'color_r'    => '0', 'color_g'    => '0', 'color_b'    => '0', 'font_style' => $this->default_style);
            $cell_idProyecto = array('posx' => '18', 'posy' => '26', 'data' => $this->idproyecto[$this->nm_grid_colunas], 'width'      => '0', 'align'      => 'L', 'font_type'  => $this->default_font, 'font_size'  => '12', 'color_r'    => '0', 'color_g'    => '0', 'color_b'    => '0', 'font_style' => B);
            $cell_3 = array('posx' => '18', 'posy' => '33', 'data' => $this->idproyecto_1[$this->nm_grid_colunas], 'width'      => '0', 'align'      => 'L', 'font_type'  => $this->default_font, 'font_size'  => '12', 'color_r'    => '0', 'color_g'    => '0', 'color_b'    => '0', 'font_style' => B);
            $cell_4 = array('posx' => '18', 'posy' => '40.216666666661595', 'data' => $this->idproyecto_2[$this->nm_grid_colunas], 'width'      => '0', 'align'      => 'L', 'font_type'  => $this->default_font, 'font_size'  => '12', 'color_r'    => '0', 'color_g'    => '0', 'color_b'    => '0', 'font_style' => B);


            $this->Pdf->SetFont($cell_codSocio['font_type'], $cell_codSocio['font_style'], $cell_codSocio['font_size']);
            $this->pdf_text_color($cell_codSocio['data'], $cell_codSocio['color_r'], $cell_codSocio['color_g'], $cell_codSocio['color_b']);
            if (!empty($cell_codSocio['posx']) && !empty($cell_codSocio['posy']))
            {
                $this->Pdf->SetXY($cell_codSocio['posx'], $cell_codSocio['posy']);
            }
            elseif (!empty($cell_codSocio['posx']))
            {
                $this->Pdf->SetX($cell_codSocio['posx']);
            }
            elseif (!empty($cell_codSocio['posy']))
            {
                $this->Pdf->SetY($cell_codSocio['posy']);
            }
            $this->Pdf->Cell($cell_codSocio['width'], 0, $cell_codSocio['data'], 0, 0, $cell_codSocio['align']);

            $this->Pdf->SetFont($cell_idProyecto['font_type'], $cell_idProyecto['font_style'], $cell_idProyecto['font_size']);
            $this->pdf_text_color($cell_idProyecto['data'], $cell_idProyecto['color_r'], $cell_idProyecto['color_g'], $cell_idProyecto['color_b']);
            if (!empty($cell_idProyecto['posx']) && !empty($cell_idProyecto['posy']))
            {
                $this->Pdf->SetXY($cell_idProyecto['posx'], $cell_idProyecto['posy']);
            }
            elseif (!empty($cell_idProyecto['posx']))
            {
                $this->Pdf->SetX($cell_idProyecto['posx']);
            }
            elseif (!empty($cell_idProyecto['posy']))
            {
                $this->Pdf->SetY($cell_idProyecto['posy']);
            }
            $this->Pdf->Cell($cell_idProyecto['width'], 0, $cell_idProyecto['data'], 0, 0, $cell_idProyecto['align']);

            $this->Pdf->SetFont($cell_3['font_type'], $cell_3['font_style'], $cell_3['font_size']);
            $this->pdf_text_color($cell_3['data'], $cell_3['color_r'], $cell_3['color_g'], $cell_3['color_b']);
            if (!empty($cell_3['posx']) && !empty($cell_3['posy']))
            {
                $this->Pdf->SetXY($cell_3['posx'], $cell_3['posy']);
            }
            elseif (!empty($cell_3['posx']))
            {
                $this->Pdf->SetX($cell_3['posx']);
            }
            elseif (!empty($cell_3['posy']))
            {
                $this->Pdf->SetY($cell_3['posy']);
            }
            $this->Pdf->Cell($cell_3['width'], 0, $cell_3['data'], 0, 0, $cell_3['align']);

            $this->Pdf->SetFont($cell_4['font_type'], $cell_4['font_style'], $cell_4['font_size']);
            $this->pdf_text_color($cell_4['data'], $cell_4['color_r'], $cell_4['color_g'], $cell_4['color_b']);
            if (!empty($cell_4['posx']) && !empty($cell_4['posy']))
            {
                $this->Pdf->SetXY($cell_4['posx'], $cell_4['posy']);
            }
            elseif (!empty($cell_4['posx']))
            {
                $this->Pdf->SetX($cell_4['posx']);
            }
            elseif (!empty($cell_4['posy']))
            {
                $this->Pdf->SetY($cell_4['posy']);
            }
            $this->Pdf->Cell($cell_4['width'], 0, $cell_4['data'], 0, 0, $cell_4['align']);

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
