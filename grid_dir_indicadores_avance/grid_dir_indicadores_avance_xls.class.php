<?php

class grid_dir_indicadores_avance_xls
{
   var $Db;
   var $Erro;
   var $Ini;
   var $Lookup;
   var $nm_data;
   var $Xls_dados;
   var $Xls_workbook;
   var $Xls_col;
   var $Xls_row;
   var $sc_proc_grid; 
   var $NM_cmp_hidden = array();
   var $NM_ctrl_style = array();
   var $Arquivo;
   var $Tit_doc;
   var $proyecto_idproyecto_Old;
   var $arg_sum_proyecto_idproyecto;
   var $Label_proyecto_idproyecto;
   var $sc_proc_quebra_proyecto_idproyecto;
   var $count_proyecto_idproyecto;
   //---- 
   function __construct()
   {
   }

   //---- 
   function monta_xls()
   {
      $this->inicializa_vars();
      $this->grava_arquivo();
      if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['embutida']) {
          if ($this->Ini->sc_export_ajax)
          {
              $this->Arr_result['file_export']  = NM_charset_to_utf8($this->Xls_f);
              $this->Arr_result['title_export'] = NM_charset_to_utf8($this->Tit_doc);
              $Temp = ob_get_clean();
              if ($Temp !== false && trim($Temp) != "")
              {
                  $this->Arr_result['htmOutput'] = NM_charset_to_utf8($Temp);
              }
              $oJson = new Services_JSON();
              echo $oJson->encode($this->Arr_result);
              exit;
          }
          else
          {
              $this->progress_bar_end();
          }
      }
      else { 
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['opcao'] = "";
      }
   }

   //----- 
   function inicializa_vars()
   {
      global $nm_lang;
      if (isset($GLOBALS['nmgp_parms']) && !empty($GLOBALS['nmgp_parms'])) 
      { 
          $GLOBALS['nmgp_parms'] = str_replace("@aspass@", "'", $GLOBALS['nmgp_parms']);
          $todox = str_replace("?#?@?@?", "?#?@ ?@?", $GLOBALS["nmgp_parms"]);
          $todo  = explode("?@?", $todox);
          foreach ($todo as $param)
          {
               $cadapar = explode("?#?", $param);
               if (1 < sizeof($cadapar))
               {
                   if (substr($cadapar[0], 0, 11) == "SC_glo_par_")
                   {
                       $cadapar[0] = substr($cadapar[0], 11);
                       $cadapar[1] = $_SESSION[$cadapar[1]];
                   }
                   if (isset($GLOBALS['sc_conv_var'][$cadapar[0]]))
                   {
                       $cadapar[0] = $GLOBALS['sc_conv_var'][$cadapar[0]];
                   }
                   elseif (isset($GLOBALS['sc_conv_var'][strtolower($cadapar[0])]))
                   {
                       $cadapar[0] = $GLOBALS['sc_conv_var'][strtolower($cadapar[0])];
                   }
                   nm_limpa_str_grid_dir_indicadores_avance($cadapar[1]);
                   nm_protect_num_grid_dir_indicadores_avance($cadapar[0], $cadapar[1]);
                   if ($cadapar[1] == "@ ") {$cadapar[1] = trim($cadapar[1]); }
                   $Tmp_par   = $cadapar[0];
                   $$Tmp_par = $cadapar[1];
                   if ($Tmp_par == "nmgp_opcao")
                   {
                       $_SESSION['sc_session'][$script_case_init]['grid_dir_indicadores_avance']['opcao'] = $cadapar[1];
                   }
               }
          }
      }
      $this->Use_phpspreadsheet = (phpversion() >=  "7.3.9" && is_dir($this->Ini->path_third . '/phpspreadsheet')) ? true : false;
      $this->SC_top = array();
      $this->SC_bot = array();
      $this->SC_top[] = "proyecto_idproyecto";
      $this->Xls_tot_col = 0;
      $this->Xls_row     = 0;
      $this->New_Xls_row = 1;
      $dir_raiz          = strrpos($_SERVER['PHP_SELF'],"/") ;  
      $dir_raiz          = substr($_SERVER['PHP_SELF'], 0, $dir_raiz + 1) ;  
      $this->nm_location = $this->Ini->sc_protocolo . $this->Ini->server . $dir_raiz; 
      if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['embutida'])
      { 
          if ($this->Use_phpspreadsheet) {
              require_once $this->Ini->path_third . '/phpspreadsheet/vendor/autoload.php';
          } 
          else { 
              set_include_path(get_include_path() . PATH_SEPARATOR . $this->Ini->path_third . '/phpexcel/');
              require_once $this->Ini->path_third . '/phpexcel/PHPExcel.php';
              require_once $this->Ini->path_third . '/phpexcel/PHPExcel/IOFactory.php';
              require_once $this->Ini->path_third . '/phpexcel/PHPExcel/Cell/AdvancedValueBinder.php';
          } 
      } 
      $orig_form_dt = strtoupper($_SESSION['scriptcase']['reg_conf']['date_format']);
      $this->SC_date_conf_region = "";
      for ($i = 0; $i < 8; $i++)
      {
          if ($i > 0 && substr($orig_form_dt, $i, 1) != substr($this->SC_date_conf_region, -1, 1)) {
              $this->SC_date_conf_region .= $_SESSION['scriptcase']['reg_conf']['date_sep'];
          }
          $this->SC_date_conf_region .= substr($orig_form_dt, $i, 1);
      }
      $this->Xls_tp = ".xlsx";
      if (isset($_REQUEST['nmgp_tp_xls']) && !empty($_REQUEST['nmgp_tp_xls']))
      {
          $this->Xls_tp = "." . $_REQUEST['nmgp_tp_xls'];
      }
      $this->groupby_show = "S";
      if (isset($_REQUEST['nmgp_tot_xls']) && !empty($_REQUEST['nmgp_tot_xls']))
      {
          $this->groupby_show = $_REQUEST['nmgp_tot_xls'];
      }
      $this->Xls_col      = 0;
      $this->Tem_xls_res  = false;
      $this->Xls_password = "";
      $this->nm_data      = new nm_data("es");
      if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['embutida'])
      { 
          $this->Tem_xls_res  = true;
          if (isset($_REQUEST['SC_module_export']) && $_REQUEST['SC_module_export'] != "")
          { 
              $this->Tem_xls_res = (strpos(" " . $_REQUEST['SC_module_export'], "resume") !== false || strpos(" " . $_REQUEST['SC_module_export'], "chart") !== false) ? true : false;
          } 
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['SC_Ind_Groupby'] == "sc_free_group_by" && empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['SC_Gb_Free_cmp']))
          {
              $this->Tem_xls_res  = false;
          }
          if (!is_file($this->Ini->root . $this->Ini->path_link . "grid_dir_indicadores_avance/grid_dir_indicadores_avance_res_xls.class.php"))
          {
              $this->Tem_xls_res  = false;
          }
          if ($this->Tem_xls_res)
          { 
              require_once($this->Ini->path_aplicacao . "grid_dir_indicadores_avance_res_xls.class.php");
              $this->Res_xls = new grid_dir_indicadores_avance_res_xls();
              $this->prep_modulos("Res_xls");
          } 
          $this->Arquivo    = "sc_xls";
          $this->Arquivo   .= "_" . date("YmdHis") . "_" . rand(0, 1000);
          $this->Arq_zip    = $this->Arquivo . "_grid_dir_indicadores_avance.zip";
          $this->Arquivo   .= "_grid_dir_indicadores_avance" . $this->Xls_tp;
          $this->Tit_doc    = "grid_dir_indicadores_avance" . $this->Xls_tp;
          $this->Tit_zip    = "grid_dir_indicadores_avance.zip";
          $this->Xls_f = $this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->Arquivo;
          $this->Zip_f = $this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->Arq_zip;
          if ($this->Use_phpspreadsheet) {
              $this->Xls_dados = new PhpOffice\PhpSpreadsheet\Spreadsheet();
              \PhpOffice\PhpSpreadsheet\Cell\Cell::setValueBinder( new \PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder() );
          }
          else {
              PHPExcel_Cell::setValueBinder( new PHPExcel_Cell_AdvancedValueBinder() );
              $this->Xls_dados = new PHPExcel();
          }
          $this->Xls_dados->setActiveSheetIndex(0);
          $this->Nm_ActiveSheet = $this->Xls_dados->getActiveSheet();
          $this->Nm_ActiveSheet->setTitle($this->Ini->Nm_lang['lang_othr_grid_titl']);
          if ($_SESSION['scriptcase']['reg_conf']['css_dir'] == "RTL")
          {
              $this->Nm_ActiveSheet->setRightToLeft(true);
          }
      }
      require_once($this->Ini->path_aplicacao . "grid_dir_indicadores_avance_total.class.php"); 
      $this->Tot = new grid_dir_indicadores_avance_total($this->Ini->sc_page);
      $this->prep_modulos("Tot");
      $Gb_geral = "quebra_geral_" . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['SC_Ind_Groupby'];
      $this->Tot->$Gb_geral();
      $this->count_ger = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['tot_geral'][1];
      if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['embutida'] && !$this->Ini->sc_export_ajax) {
          require_once($this->Ini->path_lib_php . "/sc_progress_bar.php");
          $this->pb = new scProgressBar();
          $this->pb->setRoot($this->Ini->root);
          $this->pb->setDir($_SESSION['scriptcase']['grid_dir_indicadores_avance']['glo_nm_path_imag_temp'] . "/");
          $this->pb->setProgressbarMd5($_GET['pbmd5']);
          $this->pb->initialize();
          $this->pb->setReturnUrl("./");
          $this->pb->setReturnOption($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['xls_return']);
          if ($this->Tem_xls_res) {
              $PB_plus = intval ($this->count_ger * 0.04);
              $PB_plus = ($PB_plus < 2) ? 2 : $PB_plus;
          }
          else {
              $PB_plus = intval ($this->count_ger * 0.02);
              $PB_plus = ($PB_plus < 1) ? 1 : $PB_plus;
          }
          $PB_tot = $this->count_ger + $PB_plus;
          $this->PB_dif = $PB_tot - $this->count_ger;
          $this->pb->setTotalSteps($PB_tot );
      }
   }
   //---- 
   function prep_modulos($modulo)
   {
      $this->$modulo->Ini    = $this->Ini;
      $this->$modulo->Db     = $this->Db;
      $this->$modulo->Erro   = $this->Erro;
      $this->$modulo->Lookup = $this->Lookup;
   }


   //----- 
   function grava_arquivo()
   {
      global $nm_nada, $nm_lang;

      $GLOBALS["script_case_init"] = $this->Ini->sc_page;
      $pos      = strrpos($this->Ini->link_grid_dir_indicador_progreso_cons_emb, '/');
      $link_xls = substr($this->Ini->link_grid_dir_indicador_progreso_cons_emb, 0, $pos) . "/grid_dir_indicador_progreso_xls.class.php";
      if (!is_file($this->Ini->link_grid_dir_indicador_progreso_cons_emb) || !is_file($link_xls))
      {
          $this->NM_cmp_hidden['avance'] = "off";
      }
      else
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicador_progreso']['embutida'] = true;
          $_SESSION['scriptcase']['grid_dir_indicador_progreso']['protect_modal'] = $this->Ini->sc_page;
          include_once ($this->Ini->link_grid_dir_indicador_progreso_cons_emb);
          $this->grid_dir_indicador_progreso = new grid_dir_indicador_progreso_apl ;
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicador_progreso']['embutida'] = false;
          unset($_SESSION['scriptcase']['grid_dir_indicador_progreso']['protect_modal']);
      }
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
      $this->sc_proc_grid = false; 
      $nm_raiz_img  = ""; 
      if (isset($_SESSION['scriptcase']['sc_apl_conf']['grid_dir_indicadores_avance']['field_display']) && !empty($_SESSION['scriptcase']['sc_apl_conf']['grid_dir_indicadores_avance']['field_display']))
      {
          foreach ($_SESSION['scriptcase']['sc_apl_conf']['grid_dir_indicadores_avance']['field_display'] as $NM_cada_field => $NM_cada_opc)
          {
              $this->NM_cmp_hidden[$NM_cada_field] = $NM_cada_opc;
          }
      }
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['usr_cmp_sel']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['usr_cmp_sel']))
      {
          foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['usr_cmp_sel'] as $NM_cada_field => $NM_cada_opc)
          {
              $this->NM_cmp_hidden[$NM_cada_field] = $NM_cada_opc;
          }
      }
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['php_cmp_sel']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['php_cmp_sel']))
      {
          foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['php_cmp_sel'] as $NM_cada_field => $NM_cada_opc)
          {
              $this->NM_cmp_hidden[$NM_cada_field] = $NM_cada_opc;
          }
      }
      foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['field_order'] as $Cada_cmp)
      {
          if (!isset($this->NM_cmp_hidden[$Cada_cmp]) || $this->NM_cmp_hidden[$Cada_cmp] != "off")
          {
              $this->Xls_tot_col++;
          }
      }
      $this->sc_where_orig   = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['where_orig'];
      $this->sc_where_atual  = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['where_pesq'];
      $this->sc_where_filtro = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['where_pesq_filtro'];
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['campos_busca']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['campos_busca']))
      { 
          $Busca_temp = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['campos_busca'];
          if ($_SESSION['scriptcase']['charset'] != "UTF-8")
          {
              $Busca_temp = NM_conv_charset($Busca_temp, $_SESSION['scriptcase']['charset'], "UTF-8");
          }
          $this->planmeal_idobjetivo_resultado = $Busca_temp['planmeal_idobjetivo_resultado']; 
          $tmp_pos = strpos($this->planmeal_idobjetivo_resultado, "##@@");
          if ($tmp_pos !== false && !is_array($this->planmeal_idobjetivo_resultado))
          {
              $this->planmeal_idobjetivo_resultado = substr($this->planmeal_idobjetivo_resultado, 0, $tmp_pos);
          }
          $this->planmeal_codigo = $Busca_temp['planmeal_codigo']; 
          $tmp_pos = strpos($this->planmeal_codigo, "##@@");
          if ($tmp_pos !== false && !is_array($this->planmeal_codigo))
          {
              $this->planmeal_codigo = substr($this->planmeal_codigo, 0, $tmp_pos);
          }
          $this->planmeal_indicador = $Busca_temp['planmeal_indicador']; 
          $tmp_pos = strpos($this->planmeal_indicador, "##@@");
          if ($tmp_pos !== false && !is_array($this->planmeal_indicador))
          {
              $this->planmeal_indicador = substr($this->planmeal_indicador, 0, $tmp_pos);
          }
      } 
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['xls_name']))
      {
          $Pos = strrpos($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['xls_name'], ".");
          if ($Pos === false) {
              $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['xls_name'] .= $this->Xls_tp;
          }
          $this->Arquivo = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['xls_name'];
          $this->Arq_zip = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['xls_name'];
          $this->Tit_doc = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['xls_name'];
          $Pos = strrpos($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['xls_name'], ".");
          if ($Pos !== false) {
              $this->Arq_zip = substr($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['xls_name'], 0, $Pos);
          }
          $this->Arq_zip .= ".zip";
          $this->Tit_zip  = $this->Arq_zip;
          unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['xls_name']);
          $this->Xls_f = $this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->Arquivo;
          $this->Zip_f = $this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->Arq_zip;
      }
      $this->arr_export = array('label' => array(), 'lines' => array());
      $this->arr_span   = array();

      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['embutida_label']) && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['embutida_label'])
      { 
          $this->count_span = 0;
          $this->Xls_row++;
          $this->proc_label();
          $_SESSION['scriptcase']['export_return'] = $this->arr_export;
          return;
      } 
      $this->nm_field_dinamico = array();
      $this->nm_order_dinamico = array();
      $nmgp_select_count = "SELECT count(*) AS countTest from " . $this->Ini->nm_tabela; 
      if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mysql))
      { 
          $nmgp_select = "SELECT planmeal.idObjetivo_resultado as planmeal_idobjetivo_resultado, planmeal.codigo as planmeal_codigo, planmeal.indicador as planmeal_indicador, planmeal.definicion_metodologia as cmp_maior_30_1, planmeal.idUnidadDeMedida as planmeal_idunidaddemedida, planmeal.descripcionAlcance as planmeal_descripcionalcance, proyecto.idProyecto as proyecto_idproyecto, planmeal.idPlanMeal as planmeal_idplanmeal from " . $this->Ini->nm_tabela; 
      } 
      else 
      { 
          $nmgp_select = "SELECT planmeal.idObjetivo_resultado as planmeal_idobjetivo_resultado, planmeal.codigo as planmeal_codigo, planmeal.indicador as planmeal_indicador, planmeal.definicion_metodologia as cmp_maior_30_1, planmeal.idUnidadDeMedida as planmeal_idunidaddemedida, planmeal.descripcionAlcance as planmeal_descripcionalcance, proyecto.idProyecto as proyecto_idproyecto, planmeal.idPlanMeal as planmeal_idplanmeal from " . $this->Ini->nm_tabela; 
      } 
      $nmgp_select .= " " . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['where_pesq'];
      $nmgp_select_count .= " " . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['where_pesq'];
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['where_resumo']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['where_resumo'])) 
      { 
          if (empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['where_pesq'])) 
          { 
              $nmgp_select .= " where " . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['where_resumo']; 
              $nmgp_select_count .= " where " . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['where_resumo']; 
          } 
          else
          { 
              $nmgp_select .= " and (" . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['where_resumo'] . ")"; 
              $nmgp_select_count .= " and (" . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['where_resumo'] . ")"; 
          } 
      } 
      $nmgp_order_by = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['order_grid'];
      $nmgp_select .= $nmgp_order_by; 
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nmgp_select;
      $rs = $this->Db->Execute($nmgp_select);
      if ($rs === false && !$rs->EOF && $GLOBALS["NM_ERRO_IBASE"] != 1)
      {
         $this->Erro->mensagem(__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg());
         exit;
      }
      $this->SC_seq_register = 0;
      $prim_reg = true;
      $prim_gb  = true;
      $nm_houve_quebra = "N";
      $this->New_Xls_row = $this->Xls_row;
      $PB_tot = (isset($this->count_ger) && $this->count_ger > 0) ? "/" . $this->count_ger : "";
      while (!$rs->EOF)
      {
         $this->SC_seq_register++;
         $prim_reg = false;
         if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['embutida'] && !$this->Ini->sc_export_ajax) {
             $Mens_bar = NM_charset_to_utf8($this->Ini->Nm_lang['lang_othr_prcs']);
             $this->pb->setProgressbarMessage($Mens_bar . ": " . $this->SC_seq_register . $PB_tot);
             $this->pb->addSteps(1);
         }
         $this->Xls_col = 0;
         if ($this->New_Xls_row > $this->Xls_row) {
             $this->Xls_row = $this->New_Xls_row;
         }
         $this->Xls_row++;
         $this->planmeal_idobjetivo_resultado = $rs->fields[0] ;  
         $this->planmeal_idobjetivo_resultado = (string)$this->planmeal_idobjetivo_resultado;
         $this->planmeal_codigo = $rs->fields[1] ;  
         $this->planmeal_indicador = $rs->fields[2] ;  
         $this->planmeal_definicion_metodologia = $rs->fields[3] ;  
         $this->planmeal_idunidaddemedida = $rs->fields[4] ;  
         $this->planmeal_idunidaddemedida = (string)$this->planmeal_idunidaddemedida;
         $this->planmeal_descripcionalcance = $rs->fields[5] ;  
         $this->proyecto_idproyecto = $rs->fields[6] ;  
         $this->proyecto_idproyecto = (string)$this->proyecto_idproyecto;
         $this->planmeal_idplanmeal = $rs->fields[7] ;  
         $this->planmeal_idplanmeal = (string)$this->planmeal_idplanmeal;
         $this->Orig_planmeal_idobjetivo_resultado = $this->planmeal_idobjetivo_resultado;
         $this->Orig_planmeal_codigo = $this->planmeal_codigo;
         $this->Orig_planmeal_indicador = $this->planmeal_indicador;
         $this->Orig_planmeal_definicion_metodologia = $this->planmeal_definicion_metodologia;
         $this->Orig_planmeal_idunidaddemedida = $this->planmeal_idunidaddemedida;
         $this->Orig_planmeal_descripcionalcance = $this->planmeal_descripcionalcance;
         $this->Orig_proyecto_idproyecto = $this->proyecto_idproyecto;
         $this->Orig_planmeal_idplanmeal = $this->planmeal_idplanmeal;
         $this->arg_sum_proyecto_idproyecto = ($this->proyecto_idproyecto == "") ? " is null " : " = " . $this->proyecto_idproyecto;
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['SC_Ind_Groupby'] == "sc_free_group_by") 
          {  
              $SC_arg_Gby = array();
              $SC_arg_Sql = array();
              foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['SC_Gb_Free_cmp'] as $cmp => $sql)
              {
                  $Cmp_orig   = (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['SC_Gb_Free_orig'][$cmp])) ? $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['SC_Gb_Free_orig'][$cmp] : $cmp;
                  $Format_tst = $this->Ini->Get_Gb_date_format('sc_free_group_by', $cmp);
                  $TP_Time = (in_array($Cmp_orig, $this->Ini->Cmp_Sql_Time)) ? "0000-00-00 " : "";
                  $SC_arg_Gby[$cmp] = $this->Ini->Get_arg_groupby($TP_Time . $this->$Cmp_orig, $Format_tst); 
              }
              $SC_lst_Gby = array();
              $gb_ok      = false;
              foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['SC_Gb_Free_cmp'] as $cmp => $sql)
              {
                  $Format_tst = $this->Ini->Get_Gb_date_format('sc_free_group_by', $cmp);
                  $SC_arg_Sql[$cmp] = $sql;
                  $Fun_GB  = (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['SC_Gb_Free_orig'][$cmp])) ? $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['SC_Gb_Free_orig'][$cmp] : $cmp;
                  if (!empty($Format_tst))
                  {
                      $temp = $this->$cmp;
                      if (!empty($temp))
                      {
                          $SC_arg_Sql[$cmp] = $this->Ini->Get_sql_date_groupby($sql, $Format_tst);
                      }
                  }
                  $temp = $cmp . "_Old";
                  if ($SC_arg_Gby[$cmp] != $this->$temp || $gb_ok)
                  {
                      $SC_lst_Gby[] = $cmp;
                      $gb_ok = true;
                  }
              }
              $this->Nivel_gbBot = count($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['SC_Gb_Free_cmp']);
              krsort ($SC_lst_Gby);
              $Qb_page = true;
              foreach ($SC_lst_Gby as $Ind => $cmp)
              {
                  if (in_array($cmp, $this->SC_bot) && !$prim_gb)
                  {
                      $tmp = "quebra_" . $cmp . "_sc_free_group_by_bot";
                      $this->$tmp($cmp);
                      $this->Nivel_gbBot--;
                      if ($this->groupby_show == "S") {
                          $this->Xls_col = 0;
                          $this->Xls_row++;
                      }
                  }
                  $sql_where = "";
                  $cmp_qb     = $this->$cmp;
                  foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['SC_Gb_Free_cmp'] as $Col_Gb => $Sql)
                  {
                      $tmp        = "arg_sum_" . $Col_Gb;
                      $sql_where .= (!empty($sql_where)) ? " and " : "";
                      $sql_where .= $SC_arg_Sql[$Col_Gb] . $this->$tmp;
                      if ($Col_Gb == $cmp)
                      {
                          break;
                      }
                  }
                  $tmp  = "quebra_" . $cmp . "_sc_free_group_by";
                  $this->$tmp($cmp_qb, $sql_where, $cmp);
              }
              if (!empty($SC_lst_Gby) && !$prim_gb && $this->groupby_show == "S" && $this->groupby_show == "S")
              {
                  $this->Xls_col = 0;
                  $this->Xls_row++;
                  if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['embutida']) {
                      $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['data']   = "";
                      $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['align']  = "left";
                      $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['type']   = "char";
                      $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['format'] = "";
                  }
              }
              $this->Nivel_gbBot = count($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['SC_Gb_Free_cmp']);
              ksort ($SC_lst_Gby);
              foreach ($SC_lst_Gby as $Ind => $cmp)
              {
                  if (in_array($cmp, $this->SC_top))
                  {
                      $tmp = "quebra_" . $cmp . "_sc_free_group_by_top";
                      $this->$tmp($cmp);
                      if ($this->groupby_show == "S") {
                          $this->Xls_col = 0;
                          $this->Xls_row++;
                      }
                  }
              }
              if (!empty($SC_lst_Gby))
              {
                  $nm_houve_quebra = "S";
                  foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['SC_Gb_Free_cmp'] as $cmp => $sql)
                  {
                      $Cmp_orig   = (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['SC_Gb_Free_orig'][$cmp])) ? $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['SC_Gb_Free_orig'][$cmp] : $cmp;
                      $Format_tst = $this->Ini->Get_Gb_date_format('sc_free_group_by', $cmp);
                      $Cmp_Old   = $cmp . '_Old';
                      $TP_Time = (in_array($Cmp_orig, $this->Ini->Cmp_Sql_Time)) ? "0000-00-00 " : "";
                      $this->$Cmp_Old = $this->Ini->Get_arg_groupby($TP_Time . $this->$Cmp_orig, $Format_tst); 
                  }
              }
          }  
     if ($this->groupby_show == "S") {
         if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['embutida'])
         { 
             if ($prim_gb) {
                 $this->count_span = 0;
                 $this->proc_label();
             }
             if ($prim_gb || $nm_houve_quebra == "S") {
                 $this->xls_sub_cons_copy_label($this->Xls_row);
                 $this->Xls_row++;
             }
         }
         elseif ($prim_gb || $nm_houve_quebra == "S")
         {
             $this->count_span = 0;
             $this->proc_label();
         }
     }
     else {
         if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['embutida'])
         { 
             if ($prim_gb)
             {
                 $this->count_span = 0;
                 $this->proc_label();
                 $this->xls_sub_cons_copy_label($this->Xls_row);
                 $this->Xls_row++;
             }
         }
         elseif ($prim_gb)
         {
             $this->count_span = 0;
             $this->proc_label();
         }
     }
     $prim_gb = false;
     $nm_houve_quebra = "N";
         //----- lookup - planmeal_idobjetivo_resultado
         $this->look_planmeal_idobjetivo_resultado = $this->planmeal_idobjetivo_resultado; 
         $this->Lookup->lookup_planmeal_idobjetivo_resultado($this->look_planmeal_idobjetivo_resultado, $this->planmeal_idobjetivo_resultado) ; 
         $this->look_planmeal_idobjetivo_resultado = ($this->look_planmeal_idobjetivo_resultado == "&nbsp;") ? "" : $this->look_planmeal_idobjetivo_resultado; 
         //----- lookup - planmeal_idunidaddemedida
         $this->look_planmeal_idunidaddemedida = $this->planmeal_idunidaddemedida; 
         $this->Lookup->lookup_planmeal_idunidaddemedida($this->look_planmeal_idunidaddemedida, $this->planmeal_idunidaddemedida) ; 
         $this->look_planmeal_idunidaddemedida = ($this->look_planmeal_idunidaddemedida == "&nbsp;") ? "" : $this->look_planmeal_idunidaddemedida; 
         $this->sc_proc_grid = true; 
         foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['field_order'] as $Cada_col)
         { 
            if (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off")
            { 
                if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['embutida'])
                { 
                    $NM_func_exp = "NM_sub_cons_" . $Cada_col;
                    $this->$NM_func_exp();
                } 
                else 
                { 
                    $NM_func_exp = "NM_export_" . $Cada_col;
                    $this->$NM_func_exp();
                } 
            } 
         } 
         foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['field_order'] as $Cada_col)
         { 
            if ($Cada_col == "avance" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
            { 
                $xls_row_base = $this->Xls_row;
                if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['embutida'])
                { 
                    foreach ($this->Rows_sub_avance as $line => $cols)
                    {
                        $this->Xls_row++;
                        $this->arr_export['lines'][$this->Xls_row] = $cols;
                    }
                    if (!empty($this->Rows_sub_avance['lines']))
                    {
                        foreach ($cols as $col => $dados)
                        {
                            $cols[$col]['row_span_f'] = $xls_row_base - $this->Xls_row;
                             break;
                        }
                        $this->arr_export['lines'][$this->Xls_row] = $cols;
                    }
                }
                else 
                { 
                    foreach ($this->Rows_sub_avance as $lines)
                    {
                        $this->Xls_col = 0;
                        $this->xls_sub_cons_lines($lines);
                        $this->Xls_row++;
                    }
                    $this->Xls_row = $xls_row_base;
                }
            } 
         } 
         if (isset($this->NM_Row_din) && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['embutida'])
         { 
             foreach ($this->NM_Row_din as $row => $height) 
             { 
                 $this->Nm_ActiveSheet->getRowDimension($row)->setRowHeight($height);
             } 
         } 
         $rs->MoveNext();
      }
      $this->xls_set_style();
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['embutida'] && $prim_reg)
      { 
          $this->proc_label();
          $this->xls_sub_cons_copy_label($this->Xls_row);
          $nm_grid_sem_reg = $this->Ini->Nm_lang['lang_errm_empt']; 
          $nm_grid_sem_reg  = NM_charset_to_utf8($nm_grid_sem_reg);
          $this->Xls_row++;
          $this->arr_export['lines'][$this->Xls_row][1]['data']   = $nm_grid_sem_reg;
          $this->arr_export['lines'][$this->Xls_row][1]['align']  = "right";
          $this->arr_export['lines'][$this->Xls_row][1]['type']   = "char";
          $this->arr_export['lines'][$this->Xls_row][1]['format'] = "";
      }
      if (isset($this->NM_Col_din) && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['embutida'])
      { 
          foreach ($this->NM_Col_din as $col => $width)
          { 
              $this->Nm_ActiveSheet->getColumnDimension($col)->setWidth($width / 5);
          } 
      } 
      if ($this->groupby_show == "S") {
          if ($this->New_Xls_row > $this->Xls_row) {
              $this->Xls_row = $this->New_Xls_row;
          }
          $this->Xls_col = 0;
          $this->Xls_row++;
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['SC_Ind_Groupby'] == "sc_free_group_by")
       {
           $SC_lst_Gby = array();
           foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['SC_Gb_Free_cmp'] as $cmp => $sql)
           {
               $SC_lst_Gby[] = $cmp;
           }
           $this->Nivel_gbBot = count($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['SC_Gb_Free_cmp']);
           krsort ($SC_lst_Gby);
           foreach ($SC_lst_Gby as $Ind => $cmp)
           {
               if (in_array($cmp, $this->SC_bot) && !$prim_gb)
               {
                   $tmp = "quebra_" . $cmp . "_sc_free_group_by_bot";
                   $this->$tmp($cmp);
                   $this->Nivel_gbBot--;
                   if ($this->groupby_show == "S") {
                       $this->Xls_col = 0;;
                       $this->Xls_row++;;
                   }
               }
           }
       }
      }
      if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['embutida'])
      { 
          if ($this->Tem_xls_res)
          { 
              $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['xls_res_grid'] = true;
              if (!$this->Ini->sc_export_ajax) {
                  $this->PB_dif = intval ($this->PB_dif / 2);
                  $Mens_bar  = NM_charset_to_utf8($this->Ini->Nm_lang['lang_othr_prcs']);
                  $Mens_smry = NM_charset_to_utf8($this->Ini->Nm_lang['lang_othr_smry_titl']);
                  $this->pb->setProgressbarMessage($Mens_bar . ": " . $Mens_smry);
                  $this->pb->addSteps($this->PB_dif);
              }
              $this->Res_xls->monta_xls();
              if ($this->Use_phpspreadsheet) {
                  $Xls_res = \PhpOffice\PhpSpreadsheet\IOFactory::load($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['xls_res_sheet']);
              }
              else {
                  $Xls_res = PHPExcel_IOFactory::load($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['xls_res_sheet']);
              }
              foreach($Xls_res->getAllSheets() as $sheet)
              {
                  $this->Xls_dados->addExternalSheet($sheet);
              }
              unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['xls_res_grid']);
              unlink($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['xls_res_sheet']);
          } 
          if (!$this->Ini->sc_export_ajax) {
              $Mens_bar = NM_charset_to_utf8($this->Ini->Nm_lang['lang_btns_export_finished']);
              $this->pb->setProgressbarMessage($Mens_bar);
              $this->pb->addSteps($this->PB_dif);
          }
          if ($this->Use_phpspreadsheet) {
              if ($this->Xls_tp == ".xlsx") {
                  $objWriter = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($this->Xls_dados);
              } 
              else {
                  $objWriter = new PhpOffice\PhpSpreadsheet\Writer\Xls($this->Xls_dados);
              } 
          } 
          else {
              if ($this->Xls_tp == ".xlsx") {
                  $objWriter = new PHPExcel_Writer_Excel2007($this->Xls_dados);
              } 
              else {
                  $objWriter = new PHPExcel_Writer_Excel5($this->Xls_dados);
              } 
          } 
          $objWriter->save($this->Xls_f);
          if ($this->Xls_password != "")
          { 
              $str_zip   = "";
              $Zip_f     = (FALSE !== strpos($this->Zip_f, ' ')) ? " \"" . $this->Zip_f . "\"" :  $this->Zip_f;
              $Arq_input = (FALSE !== strpos($this->Xls_f, ' ')) ? " \"" . $this->Xls_f . "\"" :  $this->Xls_f;
              if (is_file($Zip_f)) {
                  unlink($Zip_f);
              }
              if (FALSE !== strpos(strtolower(php_uname()), 'windows')) 
              {
                  chdir($this->Ini->path_third . "/zip/windows");
                  $str_zip = "zip.exe -P -j " . $this->Xls_password . " " . $Zip_f . " " . $Arq_input;
              }
              elseif (FALSE !== strpos(strtolower(php_uname()), 'linux')) 
              {
                  if (FALSE !== strpos(strtolower(php_uname()), 'i686')) 
                  {
                      chdir($this->Ini->path_third . "/zip/linux-i386/bin");
                  }
                  else
                  {
                     chdir($this->Ini->path_third . "/zip/linux-amd64/bin");
                  }
                  $str_zip = "./7za -p" . $this->Xls_password . " a " . $Zip_f . " " . $Arq_input;
              }
              elseif (FALSE !== strpos(strtolower(php_uname()), 'darwin'))
              {
                  chdir($this->Ini->path_third . "/zip/mac/bin");
                  $str_zip = "./7za -p" . $this->Xls_password . " a " . $Zip_f . " " . $Arq_input;
              }
              if (!empty($str_zip)) {
                  exec($str_zip);
              }
              // ----- ZIP log
              $fp = @fopen(trim(str_replace(array(".zip",'"'), array(".log",""), $Zip_f)), 'w');
              if ($fp)
              {
                  @fwrite($fp, $str_zip . "\r\n\r\n");
                  @fclose($fp);
              }
              unlink($Arq_input);
              $this->Arquivo = $this->Arq_zip;
              $this->Xls_f   = $this->Zip_f;
              $this->Tit_doc = $this->Tit_zip;
          } 
      } 
      else 
      { 
          $_SESSION['scriptcase']['export_return'] = $this->arr_export;
      } 
      if(isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['export_sel_columns']['field_order']))
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['field_order'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['export_sel_columns']['field_order'];
          unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['export_sel_columns']['field_order']);
      }
      if(isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['export_sel_columns']['usr_cmp_sel']))
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['usr_cmp_sel'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['export_sel_columns']['usr_cmp_sel'];
          unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['export_sel_columns']['usr_cmp_sel']);
      }
      $rs->Close();
      if (method_exists($this->grid_dir_indicador_progreso, "close_emb")) 
      {
          $this->grid_dir_indicador_progreso->close_emb();
      }
   }
   function proc_label()
   { 
      foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['field_order'] as $Cada_col)
      { 
          $SC_Label = (isset($this->New_label['planmeal_idobjetivo_resultado'])) ? $this->New_label['planmeal_idobjetivo_resultado'] : "Objetivo/Resultado"; 
          if ($Cada_col == "planmeal_idobjetivo_resultado" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              $this->count_span++;
              $current_cell_ref = $this->calc_cell($this->Xls_col);
              $SC_Label = NM_charset_to_utf8($SC_Label);
              if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['embutida'])
              { 
                  $this->arr_export['label'][$this->Xls_col]['data']     = $SC_Label;
                  $this->arr_export['label'][$this->Xls_col]['align']    = "left";
                  $this->arr_export['label'][$this->Xls_col]['autosize'] = "s";
                  $this->arr_export['label'][$this->Xls_col]['bold']     = "s";
              }
              else
              { 
                  if ($this->Use_phpspreadsheet) {
                      $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                      $this->Nm_ActiveSheet->setCellValueExplicit($current_cell_ref . $this->Xls_row, $SC_Label, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                  }
                  else {
                      $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                      $this->Nm_ActiveSheet->setCellValueExplicit($current_cell_ref . $this->Xls_row, $SC_Label, PHPExcel_Cell_DataType::TYPE_STRING);
                  }
                  $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getFont()->setBold(true);
                  $this->Nm_ActiveSheet->getColumnDimension($current_cell_ref)->setAutoSize(true);
              }
              $this->Xls_col++;
          }
          $SC_Label = (isset($this->New_label['planmeal_codigo'])) ? $this->New_label['planmeal_codigo'] : "Código"; 
          if ($Cada_col == "planmeal_codigo" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              $this->count_span++;
              $current_cell_ref = $this->calc_cell($this->Xls_col);
              $SC_Label = NM_charset_to_utf8($SC_Label);
              if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['embutida'])
              { 
                  $this->arr_export['label'][$this->Xls_col]['data']     = $SC_Label;
                  $this->arr_export['label'][$this->Xls_col]['align']    = "left";
                  $this->arr_export['label'][$this->Xls_col]['autosize'] = "s";
                  $this->arr_export['label'][$this->Xls_col]['bold']     = "s";
              }
              else
              { 
                  if ($this->Use_phpspreadsheet) {
                      $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                      $this->Nm_ActiveSheet->setCellValueExplicit($current_cell_ref . $this->Xls_row, $SC_Label, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                  }
                  else {
                      $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                      $this->Nm_ActiveSheet->setCellValueExplicit($current_cell_ref . $this->Xls_row, $SC_Label, PHPExcel_Cell_DataType::TYPE_STRING);
                  }
                  $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getFont()->setBold(true);
                  $this->Nm_ActiveSheet->getColumnDimension($current_cell_ref)->setAutoSize(true);
              }
              $this->Xls_col++;
          }
          $SC_Label = (isset($this->New_label['planmeal_indicador'])) ? $this->New_label['planmeal_indicador'] : "Indicador"; 
          if ($Cada_col == "planmeal_indicador" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              $this->count_span++;
              $current_cell_ref = $this->calc_cell($this->Xls_col);
              $SC_Label = NM_charset_to_utf8($SC_Label);
              if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['embutida'])
              { 
                  $this->arr_export['label'][$this->Xls_col]['data']     = $SC_Label;
                  $this->arr_export['label'][$this->Xls_col]['align']    = "left";
                  $this->arr_export['label'][$this->Xls_col]['autosize'] = "s";
                  $this->arr_export['label'][$this->Xls_col]['bold']     = "s";
              }
              else
              { 
                  if ($this->Use_phpspreadsheet) {
                      $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                      $this->Nm_ActiveSheet->setCellValueExplicit($current_cell_ref . $this->Xls_row, $SC_Label, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                  }
                  else {
                      $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                      $this->Nm_ActiveSheet->setCellValueExplicit($current_cell_ref . $this->Xls_row, $SC_Label, PHPExcel_Cell_DataType::TYPE_STRING);
                  }
                  $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getFont()->setBold(true);
                  $this->Nm_ActiveSheet->getColumnDimension($current_cell_ref)->setAutoSize(true);
              }
              $this->Xls_col++;
          }
          $SC_Label = (isset($this->New_label['planmeal_definicion_metodologia'])) ? $this->New_label['planmeal_definicion_metodologia'] : "Definicion Metodologia"; 
          if ($Cada_col == "planmeal_definicion_metodologia" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              $this->count_span++;
              $current_cell_ref = $this->calc_cell($this->Xls_col);
              $SC_Label = NM_charset_to_utf8($SC_Label);
              if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['embutida'])
              { 
                  $this->arr_export['label'][$this->Xls_col]['data']     = $SC_Label;
                  $this->arr_export['label'][$this->Xls_col]['align']    = "left";
                  $this->arr_export['label'][$this->Xls_col]['autosize'] = "s";
                  $this->arr_export['label'][$this->Xls_col]['bold']     = "s";
              }
              else
              { 
                  if ($this->Use_phpspreadsheet) {
                      $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                      $this->Nm_ActiveSheet->setCellValueExplicit($current_cell_ref . $this->Xls_row, $SC_Label, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                  }
                  else {
                      $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                      $this->Nm_ActiveSheet->setCellValueExplicit($current_cell_ref . $this->Xls_row, $SC_Label, PHPExcel_Cell_DataType::TYPE_STRING);
                  }
                  $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getFont()->setBold(true);
                  $this->Nm_ActiveSheet->getColumnDimension($current_cell_ref)->setAutoSize(true);
              }
              $this->Xls_col++;
          }
          $SC_Label = (isset($this->New_label['planmeal_idunidaddemedida'])) ? $this->New_label['planmeal_idunidaddemedida'] : "Unidad De Medida"; 
          if ($Cada_col == "planmeal_idunidaddemedida" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              $this->count_span++;
              $current_cell_ref = $this->calc_cell($this->Xls_col);
              $SC_Label = NM_charset_to_utf8($SC_Label);
              if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['embutida'])
              { 
                  $this->arr_export['label'][$this->Xls_col]['data']     = $SC_Label;
                  $this->arr_export['label'][$this->Xls_col]['align']    = "left";
                  $this->arr_export['label'][$this->Xls_col]['autosize'] = "s";
                  $this->arr_export['label'][$this->Xls_col]['bold']     = "s";
              }
              else
              { 
                  if ($this->Use_phpspreadsheet) {
                      $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                      $this->Nm_ActiveSheet->setCellValueExplicit($current_cell_ref . $this->Xls_row, $SC_Label, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                  }
                  else {
                      $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                      $this->Nm_ActiveSheet->setCellValueExplicit($current_cell_ref . $this->Xls_row, $SC_Label, PHPExcel_Cell_DataType::TYPE_STRING);
                  }
                  $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getFont()->setBold(true);
                  $this->Nm_ActiveSheet->getColumnDimension($current_cell_ref)->setAutoSize(true);
              }
              $this->Xls_col++;
          }
          $SC_Label = (isset($this->New_label['planmeal_descripcionalcance'])) ? $this->New_label['planmeal_descripcionalcance'] : "Descripcion Alcance"; 
          if ($Cada_col == "planmeal_descripcionalcance" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              $this->count_span++;
              $current_cell_ref = $this->calc_cell($this->Xls_col);
              $SC_Label = NM_charset_to_utf8($SC_Label);
              if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['embutida'])
              { 
                  $this->arr_export['label'][$this->Xls_col]['data']     = $SC_Label;
                  $this->arr_export['label'][$this->Xls_col]['align']    = "left";
                  $this->arr_export['label'][$this->Xls_col]['autosize'] = "s";
                  $this->arr_export['label'][$this->Xls_col]['bold']     = "s";
              }
              else
              { 
                  if ($this->Use_phpspreadsheet) {
                      $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                      $this->Nm_ActiveSheet->setCellValueExplicit($current_cell_ref . $this->Xls_row, $SC_Label, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                  }
                  else {
                      $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                      $this->Nm_ActiveSheet->setCellValueExplicit($current_cell_ref . $this->Xls_row, $SC_Label, PHPExcel_Cell_DataType::TYPE_STRING);
                  }
                  $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getFont()->setBold(true);
                  $this->Nm_ActiveSheet->getColumnDimension($current_cell_ref)->setAutoSize(true);
              }
              $this->Xls_col++;
          }
          $SC_Label = (isset($this->New_label['avance'])) ? $this->New_label['avance'] : "PROGRESO"; 
          if ($Cada_col == "avance" && (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off"))
          {
              $this->arr_span['avance'] = $this->count_span;
              $this->Emb_label_cols_avance = 0;
              $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicador_progreso']['embutida'] = true;
              $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicador_progreso']['embutida_label'] = true;
              $GLOBALS["script_case_init"] = $this->Ini->sc_page;
              $GLOBALS["nmgp_parms"] = "nmgp_opcao?#?xls?@?";
              if (method_exists($this->grid_dir_indicador_progreso, "controle"))
              {
                  $this->grid_dir_indicador_progreso->controle();
                  if (isset($_SESSION['scriptcase']['export_return']))
                  {
                     foreach ($_SESSION['scriptcase']['export_return']['label'] as $col => $dados)
                     {
                         if (isset($dados['col_span_i'])) {
                             $this->Emb_label_cols_avance += $dados['col_span_i'];
                         }
                         elseif (isset($dados['col_span_f'])) {
                             $this->Emb_label_cols_avance += $dados['col_span_f'];
                         }
                         else {
                             $this->Emb_label_cols_avance++;
                         }
                     }
                  }
                  $this->count_span += $this->Emb_label_cols_avance;
              }
              $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicador_progreso']['embutida'] = false;
              $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicador_progreso']['embutida_label'] = false;
              $current_cell_ref = $this->calc_cell($this->Xls_col);
              $SC_Label = NM_charset_to_utf8($SC_Label);
              if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['embutida'])
              { 
                  $this->arr_export['label'][$this->Xls_col]['data']     = $SC_Label;
                  $this->arr_export['label'][$this->Xls_col]['align']    = "left";
                  $this->arr_export['label'][$this->Xls_col]['autosize'] = "s";
                  $this->arr_export['label'][$this->Xls_col]['bold']     = "s";
              }
              else
              { 
                  if ($this->Use_phpspreadsheet) {
                      $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                      $this->Nm_ActiveSheet->setCellValueExplicit($current_cell_ref . $this->Xls_row, $SC_Label, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                  }
                  else {
                      $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                      $this->Nm_ActiveSheet->setCellValueExplicit($current_cell_ref . $this->Xls_row, $SC_Label, PHPExcel_Cell_DataType::TYPE_STRING);
                  }
                  $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getFont()->setBold(true);
                  $this->Nm_ActiveSheet->getColumnDimension($current_cell_ref)->setAutoSize(true);
              }
              if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['embutida'])
              { 
                  $this->arr_export['label'][$this->Xls_col]['col_span_f'] = $this->Emb_label_cols_avance;
                  $this->Xls_col++;
              }
              else
              { 
                  $this->Xls_col += $this->Emb_label_cols_avance;
              } 
          }
      } 
      $this->Xls_col = 0;
      $this->Xls_row++;
   } 
   //----- planmeal_idobjetivo_resultado
   function NM_export_planmeal_idobjetivo_resultado()
   {
         $current_cell_ref = $this->calc_cell($this->Xls_col);
         if (!isset($this->NM_ctrl_style[$current_cell_ref])) {
             $this->NM_ctrl_style[$current_cell_ref]['ini'] = $this->Xls_row;
             $this->NM_ctrl_style[$current_cell_ref]['align'] = "LEFT"; 
         }
         $this->NM_ctrl_style[$current_cell_ref]['end'] = $this->Xls_row;
         $this->look_planmeal_idobjetivo_resultado = NM_charset_to_utf8($this->look_planmeal_idobjetivo_resultado);
         if (is_numeric($this->look_planmeal_idobjetivo_resultado))
         {
             $this->NM_ctrl_style[$current_cell_ref]['format'] = '#,##0';
         }
         $this->Nm_ActiveSheet->setCellValue($current_cell_ref . $this->Xls_row, $this->look_planmeal_idobjetivo_resultado);
         $this->Xls_col++;
   }
   //----- planmeal_codigo
   function NM_export_planmeal_codigo()
   {
         $current_cell_ref = $this->calc_cell($this->Xls_col);
         if (!isset($this->NM_ctrl_style[$current_cell_ref])) {
             $this->NM_ctrl_style[$current_cell_ref]['ini'] = $this->Xls_row;
             $this->NM_ctrl_style[$current_cell_ref]['align'] = "LEFT"; 
         }
         $this->NM_ctrl_style[$current_cell_ref]['end'] = $this->Xls_row;
         $this->planmeal_codigo = html_entity_decode($this->planmeal_codigo, ENT_COMPAT, $_SESSION['scriptcase']['charset']);
         $this->planmeal_codigo = strip_tags($this->planmeal_codigo);
         $this->planmeal_codigo = NM_charset_to_utf8($this->planmeal_codigo);
         if ($this->Use_phpspreadsheet) {
             $this->Nm_ActiveSheet->setCellValueExplicit($current_cell_ref . $this->Xls_row, $this->planmeal_codigo, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
         }
         else {
             $this->Nm_ActiveSheet->setCellValueExplicit($current_cell_ref . $this->Xls_row, $this->planmeal_codigo, PHPExcel_Cell_DataType::TYPE_STRING);
         }
         $this->Xls_col++;
   }
   //----- planmeal_indicador
   function NM_export_planmeal_indicador()
   {
         $current_cell_ref = $this->calc_cell($this->Xls_col);
         if (!isset($this->NM_ctrl_style[$current_cell_ref])) {
             $this->NM_ctrl_style[$current_cell_ref]['ini'] = $this->Xls_row;
             $this->NM_ctrl_style[$current_cell_ref]['align'] = "LEFT"; 
         }
         $this->NM_ctrl_style[$current_cell_ref]['end'] = $this->Xls_row;
         $this->planmeal_indicador = html_entity_decode($this->planmeal_indicador, ENT_COMPAT, $_SESSION['scriptcase']['charset']);
         $this->planmeal_indicador = strip_tags($this->planmeal_indicador);
         $this->planmeal_indicador = NM_charset_to_utf8($this->planmeal_indicador);
         if ($this->Use_phpspreadsheet) {
             $this->Nm_ActiveSheet->setCellValueExplicit($current_cell_ref . $this->Xls_row, $this->planmeal_indicador, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
         }
         else {
             $this->Nm_ActiveSheet->setCellValueExplicit($current_cell_ref . $this->Xls_row, $this->planmeal_indicador, PHPExcel_Cell_DataType::TYPE_STRING);
         }
         $this->Xls_col++;
   }
   //----- planmeal_definicion_metodologia
   function NM_export_planmeal_definicion_metodologia()
   {
         $current_cell_ref = $this->calc_cell($this->Xls_col);
         if (!isset($this->NM_ctrl_style[$current_cell_ref])) {
             $this->NM_ctrl_style[$current_cell_ref]['ini'] = $this->Xls_row;
             $this->NM_ctrl_style[$current_cell_ref]['align'] = "LEFT"; 
         }
         $this->NM_ctrl_style[$current_cell_ref]['end'] = $this->Xls_row;
         $this->planmeal_definicion_metodologia = html_entity_decode($this->planmeal_definicion_metodologia, ENT_COMPAT, $_SESSION['scriptcase']['charset']);
         $this->planmeal_definicion_metodologia = strip_tags($this->planmeal_definicion_metodologia);
         $this->planmeal_definicion_metodologia = NM_charset_to_utf8($this->planmeal_definicion_metodologia);
         if ($this->Use_phpspreadsheet) {
             $this->Nm_ActiveSheet->setCellValueExplicit($current_cell_ref . $this->Xls_row, $this->planmeal_definicion_metodologia, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
         }
         else {
             $this->Nm_ActiveSheet->setCellValueExplicit($current_cell_ref . $this->Xls_row, $this->planmeal_definicion_metodologia, PHPExcel_Cell_DataType::TYPE_STRING);
         }
         $this->Xls_col++;
   }
   //----- planmeal_idunidaddemedida
   function NM_export_planmeal_idunidaddemedida()
   {
         $current_cell_ref = $this->calc_cell($this->Xls_col);
         if (!isset($this->NM_ctrl_style[$current_cell_ref])) {
             $this->NM_ctrl_style[$current_cell_ref]['ini'] = $this->Xls_row;
             $this->NM_ctrl_style[$current_cell_ref]['align'] = "LEFT"; 
         }
         $this->NM_ctrl_style[$current_cell_ref]['end'] = $this->Xls_row;
         $this->look_planmeal_idunidaddemedida = NM_charset_to_utf8($this->look_planmeal_idunidaddemedida);
         if (is_numeric($this->look_planmeal_idunidaddemedida))
         {
             $this->NM_ctrl_style[$current_cell_ref]['format'] = '#,##0';
         }
         $this->Nm_ActiveSheet->setCellValue($current_cell_ref . $this->Xls_row, $this->look_planmeal_idunidaddemedida);
         $this->Xls_col++;
   }
   //----- planmeal_descripcionalcance
   function NM_export_planmeal_descripcionalcance()
   {
         $current_cell_ref = $this->calc_cell($this->Xls_col);
         if (!isset($this->NM_ctrl_style[$current_cell_ref])) {
             $this->NM_ctrl_style[$current_cell_ref]['ini'] = $this->Xls_row;
             $this->NM_ctrl_style[$current_cell_ref]['align'] = "LEFT"; 
         }
         $this->NM_ctrl_style[$current_cell_ref]['end'] = $this->Xls_row;
         $this->planmeal_descripcionalcance = html_entity_decode($this->planmeal_descripcionalcance, ENT_COMPAT, $_SESSION['scriptcase']['charset']);
         $this->planmeal_descripcionalcance = strip_tags($this->planmeal_descripcionalcance);
         $this->planmeal_descripcionalcance = NM_charset_to_utf8($this->planmeal_descripcionalcance);
         if ($this->Use_phpspreadsheet) {
             $this->Nm_ActiveSheet->setCellValueExplicit($current_cell_ref . $this->Xls_row, $this->planmeal_descripcionalcance, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
         }
         else {
             $this->Nm_ActiveSheet->setCellValueExplicit($current_cell_ref . $this->Xls_row, $this->planmeal_descripcionalcance, PHPExcel_Cell_DataType::TYPE_STRING);
         }
         $this->Xls_col++;
   }
   //----- avance
   function NM_export_avance()
   {
         $GLOBALS["script_case_init"] = $this->Ini->sc_page;
         $GLOBALS["nmgp_parms"] = "nmgp_opcao?#?xls?@?gloplanmeal?#?" . str_replace("'", "@aspass@", $this->Orig_planmeal_idplanmeal) . "?@?";
         $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicador_progreso']['embutida'] = true;
         $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicador_progreso']['nolabel'] = true;
         if (method_exists($this->grid_dir_indicador_progreso, "controle"))
         {
             $this->grid_dir_indicador_progreso->controle();
             if (isset($_SESSION['scriptcase']['export_return']))
             {
                 $this->Rows_sub_avance = array();
                 if (isset($_SESSION['scriptcase']['export_return']['label']))
                 {
                     $_SESSION['scriptcase']['export_return']['label'][0]['col_span_i'] = $this->arr_span['avance'];
                     $this->Xls_col += $this->Emb_label_cols_avance;
                 }
                 if (isset($_SESSION['scriptcase']['export_return']['lines']))
                 {
                     foreach ($_SESSION['scriptcase']['export_return']['lines'] as $line => $cols)
                     {
                         $prim_col = true;
                         foreach ($cols as $icol => $dados)
                         {
                             $this->Rows_sub_avance[$line][$icol] = $dados;
                             if ($prim_col)
                             {
                                 if (isset($this->Rows_sub_avance[$line][$icol]['col_span_i']))
                                 {
                                    $this->Rows_sub_avance[$line][$icol]['col_span_i'] += $this->arr_span['avance'];
                                 }
                                 else
                                 {
                                    $this->Rows_sub_avance[$line][$icol]['col_span_i'] = $this->arr_span['avance'];
                                 }
                                 $prim_col = false;
                             }
                         }
                     }
                 }
             }
         }
         $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicador_progreso']['embutida'] = false;
   }
   //----- planmeal_idobjetivo_resultado
   function NM_sub_cons_planmeal_idobjetivo_resultado()
   {
         $this->look_planmeal_idobjetivo_resultado = NM_charset_to_utf8($this->look_planmeal_idobjetivo_resultado);
         $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['data']   = $this->look_planmeal_idobjetivo_resultado;
         $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['align']  = "";
         $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['type']   = "num";
         $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['format'] = "#,##0";
         $this->Xls_col++;
   }
   //----- planmeal_codigo
   function NM_sub_cons_planmeal_codigo()
   {
         $this->planmeal_codigo = html_entity_decode($this->planmeal_codigo, ENT_COMPAT, $_SESSION['scriptcase']['charset']);
         $this->planmeal_codigo = strip_tags($this->planmeal_codigo);
         $this->planmeal_codigo = NM_charset_to_utf8($this->planmeal_codigo);
         $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['data']   = $this->planmeal_codigo;
         $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['align']  = "left";
         $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['type']   = "char";
         $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['format'] = "";
         $this->Xls_col++;
   }
   //----- planmeal_indicador
   function NM_sub_cons_planmeal_indicador()
   {
         $this->planmeal_indicador = html_entity_decode($this->planmeal_indicador, ENT_COMPAT, $_SESSION['scriptcase']['charset']);
         $this->planmeal_indicador = strip_tags($this->planmeal_indicador);
         $this->planmeal_indicador = NM_charset_to_utf8($this->planmeal_indicador);
         $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['data']   = $this->planmeal_indicador;
         $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['align']  = "left";
         $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['type']   = "char";
         $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['format'] = "";
         $this->Xls_col++;
   }
   //----- planmeal_definicion_metodologia
   function NM_sub_cons_planmeal_definicion_metodologia()
   {
         $this->planmeal_definicion_metodologia = html_entity_decode($this->planmeal_definicion_metodologia, ENT_COMPAT, $_SESSION['scriptcase']['charset']);
         $this->planmeal_definicion_metodologia = strip_tags($this->planmeal_definicion_metodologia);
         $this->planmeal_definicion_metodologia = NM_charset_to_utf8($this->planmeal_definicion_metodologia);
         $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['data']   = $this->planmeal_definicion_metodologia;
         $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['align']  = "left";
         $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['type']   = "char";
         $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['format'] = "";
         $this->Xls_col++;
   }
   //----- planmeal_idunidaddemedida
   function NM_sub_cons_planmeal_idunidaddemedida()
   {
         $this->look_planmeal_idunidaddemedida = NM_charset_to_utf8($this->look_planmeal_idunidaddemedida);
         $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['data']   = $this->look_planmeal_idunidaddemedida;
         $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['align']  = "";
         $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['type']   = "num";
         $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['format'] = "#,##0";
         $this->Xls_col++;
   }
   //----- planmeal_descripcionalcance
   function NM_sub_cons_planmeal_descripcionalcance()
   {
         $this->planmeal_descripcionalcance = html_entity_decode($this->planmeal_descripcionalcance, ENT_COMPAT, $_SESSION['scriptcase']['charset']);
         $this->planmeal_descripcionalcance = strip_tags($this->planmeal_descripcionalcance);
         $this->planmeal_descripcionalcance = NM_charset_to_utf8($this->planmeal_descripcionalcance);
         $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['data']   = $this->planmeal_descripcionalcance;
         $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['align']  = "left";
         $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['type']   = "char";
         $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['format'] = "";
         $this->Xls_col++;
   }
   //----- avance
   function NM_sub_cons_avance()
   {
         $this->Rows_sub_avance = array();
         $GLOBALS["script_case_init"] = $this->Ini->sc_page;
         $GLOBALS["nmgp_parms"] = "nmgp_opcao?#?xls?@?gloplanmeal?#?" . str_replace("'", "@aspass@", $this->Orig_planmeal_idplanmeal) . "?@?";
         $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicador_progreso']['embutida'] = true;
         if (method_exists($this->grid_dir_indicador_progreso, "controle"))
         {
             $this->grid_dir_indicador_progreso->controle();
             if (isset($_SESSION['scriptcase']['export_return']))
             {
                 $this->row_sub = 1;
                 if (isset($_SESSION['scriptcase']['export_return']['lines']))
                 {
                     foreach ($_SESSION['scriptcase']['export_return']['lines'] as $line => $cols)
                     {
                         foreach ($cols as $icol => $dados)
                         {
                             $this->arr_export['lines'][$this->Xls_row][$this->Xls_col] = $dados;
                             $this->Xls_col++;
                         }
                         unset ($_SESSION['scriptcase']['export_return']['lines'][$line]);
                         break;
                     }
                 }
                 $this->row_sub++;
                 if (isset($_SESSION['scriptcase']['export_return']['lines']))
                 {
                     $xls_col_base = $this->Xls_col;
                     foreach ($_SESSION['scriptcase']['export_return']['lines'] as $line => $cols)
                     {
                         $this->Xls_col = $xls_col_base;
                         $prim_col = true;
                         foreach ($cols as $icol => $dados)
                         {
                             $this->Rows_sub_avance[$this->row_sub][$icol] = $dados;
                             if ($prim_col && $this->row_sub > 1)
                             {
                                 if (isset($this->Rows_sub_avance[$this->row_sub][$icol]['col_span_i']))
                                 {
                                    $this->Rows_sub_avance[$this->row_sub][$icol]['col_span_i'] += $this->arr_span['avance'];
                                 }
                                 else
                                 {
                                    $this->Rows_sub_avance[$this->row_sub][$icol]['col_span_i'] = $this->arr_span['avance'];
                                 }
                                $prim_col = false;
                             }
                             $this->Xls_col++;
                         }
                         $this->row_sub++;
                     }
                 }
             }
             else
             {
                 $this->Xls_col++;
             }
         }
         $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicador_progreso']['embutida'] = false;
         $this->Xls_col++;
   }
   function xls_sub_cons_copy_label($row)
   {
       if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['nolabel']) || $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['nolabel'])
       {
           foreach ($this->arr_export['label'] as $col => $dados)
           {
               $this->arr_export['lines'][$row][$col] = $dados;
           }
       }
   }
   function xls_set_style()
   {
       if (!empty($this->NM_ctrl_style))
       {
           foreach ($this->NM_ctrl_style as $col => $dados)
           {
               $cell_ref = $col . $dados['ini'] . ":" . $col . $dados['end'];
               if ($this->Use_phpspreadsheet) {
                   if ($dados['align'] == "LEFT") {
                       $this->Nm_ActiveSheet->getStyle($cell_ref)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                   }
                   elseif ($dados['align'] == "RIGHT") {
                       $this->Nm_ActiveSheet->getStyle($cell_ref)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                   }
                   else {
                       $this->Nm_ActiveSheet->getStyle($cell_ref)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                   }
               }
               else {
                   if ($dados['align'] == "LEFT") {
                       $this->Nm_ActiveSheet->getStyle($cell_ref)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                   }
                   elseif ($dados['align'] == "RIGHT") {
                       $this->Nm_ActiveSheet->getStyle($cell_ref)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                   }
                   else {
                       $this->Nm_ActiveSheet->getStyle($cell_ref)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                   }
               }
               if (isset($dados['format'])) {
                   $this->Nm_ActiveSheet->getStyle($cell_ref)->getNumberFormat()->setFormatCode($dados['format']);
               }
           }
           $this->NM_ctrl_style = array();
       }
   }
   function xls_sub_cons_label($lines)
   {
         foreach ($lines as $col => $dados)
         {
             if (isset($dados['col_span_i'])) {
                 $this->Xls_col += $dados['col_span_i'];
             }
             $current_cell_ref = $this->calc_cell($this->Xls_col);
             if ($this->Use_phpspreadsheet) {
                 if ($dados['align'] == 'center') {
                     $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                 }
                 elseif ($dados['align'] == 'left') {
                     $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                 }
                 else {
                     $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                 }
             }
             else {
                 if ($dados['align'] == 'center') {
                     $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                 }
                 elseif ($dados['align'] == 'left') {
                     $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                 }
                 else {
                     $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                 }
             }
             $this->Nm_ActiveSheet->setCellValue($current_cell_ref . $this->Xls_row, $dados['data']);
             $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getFont()->setBold(true);
             if ($dados['autosize'] == 's') {
                 $this->Nm_ActiveSheet->getColumnDimension($current_cell_ref)->setAutoSize(true);
             }
             if (isset($dados['col_span_f'])) {
                 $this->Xls_col += $dados['col_span_f'];
             }
             else {
                 $this->Xls_col++;
             }
         }
   }
   function xls_sub_cons_lines($lines)
   {
         foreach ($lines as $icol => $dados)
         {
             if (isset($dados['col_span_i'])) {
                 $this->Xls_col += $dados['col_span_i'];
             }
             $current_cell_ref = $this->calc_cell($this->Xls_col);
             if ($this->Use_phpspreadsheet) {
                 if ($dados['align'] == 'center') {
                     $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                 }
                 elseif ($dados['align'] == 'left') {
                     $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                 }
                 else {
                     $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
                 }
             }
             else {
                 if ($dados['align'] == 'center') {
                     $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                 }
                 elseif ($dados['align'] == 'left') {
                     $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                 }
                 else {
                     $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                 }
             }
             if ($dados['type'] == 'img') {
                 if (is_file($dados['data']))
                 { 
                     $sc_obj_img = new nm_trata_img($dados['data']);
                     $nm_image_altura  = $sc_obj_img->getHeight();
                     $nm_image_largura = $sc_obj_img->getWidth();
                     if ($this->Use_phpspreadsheet) {
                         $objDrawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                     }
                     else {
                         $objDrawing = new PHPExcel_Worksheet_Drawing();
                     }
                     if (!empty($dados['name'])) {
                         $objDrawing->setName($dados['name']);
                     } 
                     $objDrawing->setPath($dados['data']);
                     $objDrawing->setHeight($nm_image_altura);
                     $col = $current_cell_ref;
                     $objDrawing->setCoordinates($col . $this->Xls_row);
                     $objDrawing->setWorksheet($this->Nm_ActiveSheet);
                     if (!isset($this->NM_Col_din[$col]) || $this->NM_Col_din[$col] < $nm_image_largura)
                     { 
                         $this->NM_Col_din[$col] = $nm_image_largura;
                     } 
                     if (!isset($this->NM_Row_din[$this->Xls_row]) || $this->NM_Row_din[$this->Xls_row] < $nm_image_altura)
                     { 
                         $this->NM_Row_din[$this->Xls_row] = $nm_image_altura;
                     } 
                 } 
                 else 
                 { 
                     if ($this->Use_phpspreadsheet) {
                         $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                     }
                     else {
                         $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                     }
                     $this->Nm_ActiveSheet->setCellValue($current_cell_ref . $this->Xls_row, ' ');
                 } 
             } 
             elseif ($dados['type'] == 'data') {
                 if (empty($dados['data']) || $dados['data'] == "0000-00-00") {
                     if ($this->Use_phpspreadsheet) {
                         $this->Nm_ActiveSheet->setCellValueExplicit($current_cell_ref . $this->Xls_row, $dados['data'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                     }
                     else {
                         $this->Nm_ActiveSheet->setCellValueExplicit($current_cell_ref . $this->Xls_row, $dados['data'], PHPExcel_Cell_DataType::TYPE_STRING);
                     }
                 }
                 else {
                     $this->Nm_ActiveSheet->setCellValue($current_cell_ref . $this->Xls_row, $dados['data']);
                     $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getNumberFormat()->setFormatCode($dados['format']);
                 }
             } 
             elseif ($dados['type'] == 'num') {
                 if (is_numeric($dados['data'])) {
                     $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getNumberFormat()->setFormatCode($dados['format']);
                 }
                 $this->Nm_ActiveSheet->setCellValue($current_cell_ref . $this->Xls_row, $dados['data']);
             } 
             else { 
                 if ($this->Use_phpspreadsheet) {
                     $this->Nm_ActiveSheet->setCellValueExplicit($current_cell_ref . $this->Xls_row, $dados['data'], \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                 }
                 else {
                    $this->Nm_ActiveSheet->setCellValueExplicit($current_cell_ref . $this->Xls_row, $dados['data'], PHPExcel_Cell_DataType::TYPE_STRING);
                 }
             } 
             if (isset($dados['bold'])){ 
                 $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getFont()->setBold(true);
             } 
             if ($dados['autosize'] == 's') {
                 $this->Nm_ActiveSheet->getColumnDimension($current_cell_ref)->setAutoSize(true);
             }
             if (isset($dados['col_span_f'])) {
                 $this->Xls_col += $dados['col_span_f'];
             }
             else {
                 $this->Xls_col++;
             }
         }
         if ($this->Xls_row > $this->New_Xls_row) {
             $this->New_Xls_row = $this->Xls_row;
         }
         if (isset($dados['row_span_f'])) {
             $this->Xls_row += $dados['row_span_f'];
         }
   }
 function quebra_proyecto_idproyecto_sc_free_group_by($Cmp_qb, $Where_qb, $Cmp_Name) 
 {
   $Var_name_gb  = "SC_tot_" . $Cmp_Name;
   $Cmps_Gb_Free = "campos_quebra_" . $Cmp_Name;
   $Desc_Gb_Ant  = $Cmp_Name . "_ant_desc";
   global $$Var_name_gb, $Desc_Gb_Ant;
   $this->sc_proc_quebra_proyecto_idproyecto = true; 
   $this->Tot->quebra_proyecto_idproyecto_sc_free_group_by($Cmp_qb, $Where_qb, $Cmp_Name);
   $tot_proyecto_idproyecto = $$Var_name_gb;
   $conteudo = $tot_proyecto_idproyecto[0] ;  
   $this->count_proyecto_idproyecto = $tot_proyecto_idproyecto[1];
   $Temp_cmp_quebra = array(); 
   $conteudo = NM_encode_input(sc_strip_script($this->proyecto_idproyecto)); 
   $this->Lookup->lookup_sc_free_group_by_proyecto_idproyecto($conteudo , $this->proyecto_idproyecto) ; 
   $Temp_cmp_quebra[0]['cmp'] = $conteudo; 
   if (isset($this->nmgp_label_quebras['proyecto_idproyecto']))
   {
       $Temp_cmp_quebra[0]['lab'] = $this->nmgp_label_quebras['proyecto_idproyecto']; 
   }
   else
   {
       $Temp_cmp_quebra[0]['lab'] = "Cod. Proyecto"; 
   }
   $this->$Cmps_Gb_Free = $Temp_cmp_quebra;
   $this->sc_proc_quebra_proyecto_idproyecto = false; 
 } 
   function quebra_proyecto_idproyecto_sc_free_group_by_top()
   {
       if ($this->groupby_show != "S") {
           return;
       }
       $this->xls_set_style();
       $lim_col  = 1;
       $temp_cmp = "";
       $cont_col = 0;
       foreach ($this->campos_quebra_proyecto_idproyecto as $cada_campo) {
           if ($cont_col == $lim_col) {
               $temp_cmp = html_entity_decode($temp_cmp, ENT_COMPAT, $_SESSION['scriptcase']['charset']);
               $temp_cmp = strip_tags($temp_cmp);
               $temp_cmp = NM_charset_to_utf8($temp_cmp);
               if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['embutida']) {
                   $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['data']       = $temp_cmp;
                   $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['align']      = "left";
                   $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['type']       = "char";
                   $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['format']     = "";
                   $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['bold']       = "";
                   $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['col_span_f'] = $this->Xls_tot_col;
               }
               else {
                   $current_cell_ref = $this->calc_cell($this->Xls_col);
                   if ($this->Use_phpspreadsheet) {
                       $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                   }
                   else {
                       $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                   }
                   $this->Nm_ActiveSheet->setCellValue($current_cell_ref . $this->Xls_row, $temp_cmp);
                   $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getFont()->setBold(true);
               }
               $temp_cmp = "";
               $cont_col = 0;
               $this->Xls_row++;
           }
           $temp_cmp .= $cada_campo['lab'] . " => " . $cada_campo['cmp'] . "  ";
           $cont_col++;
       }
       if (!empty($temp_cmp)) {
           $temp_cmp = html_entity_decode($temp_cmp, ENT_COMPAT, $_SESSION['scriptcase']['charset']);
           $temp_cmp = strip_tags($temp_cmp);
           $temp_cmp = NM_charset_to_utf8($temp_cmp);
           if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['embutida']) {
               $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['data']       = $temp_cmp;
               $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['align']      = "left";
               $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['type']       = "char";
               $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['format']     = "";
               $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['bold']       = "";
               $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['col_span_f'] = $this->Xls_tot_col;
           }
           else {
               $current_cell_ref = $this->calc_cell($this->Xls_col);
               if ($this->Use_phpspreadsheet) {
                   $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
               }
               else {
                   $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
               }
               $this->Nm_ActiveSheet->setCellValue($current_cell_ref . $this->Xls_row, $temp_cmp);
               $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getFont()->setBold(true);
           }
       }
   }
   function quebra_proyecto_idproyecto_sc_free_group_by_bot()
   {
       if ($this->groupby_show != "S") {
           return;
       }
       $this->xls_set_style();
       $prim_cmp = true;
       $mens_tot_base = "";
       $mens_tot = "";
       foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['field_order'] as $Cada_cmp)
       {
           if (!isset($this->NM_cmp_hidden[$Cada_cmp]) || $this->NM_cmp_hidden[$Cada_cmp] != "off")
           {
               if ($prim_cmp)
               {
                   $mens_tot = html_entity_decode($mens_tot, ENT_COMPAT, $_SESSION['scriptcase']['charset']);
                   $mens_tot = strip_tags($mens_tot);
                   $mens_tot = NM_charset_to_utf8($mens_tot);
                   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['embutida']) {
                       $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['data']   = $mens_tot;
                       $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['align']  = "left";
                       $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['type']   = "char";
                       $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['format'] = "";
                       $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['bold']   = "";
                   }
                   else {
                       $current_cell_ref = $this->calc_cell($this->Xls_col);
                       if ($this->Use_phpspreadsheet) {
                           $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                       }
                       else {
                           $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                       }
                       $this->Nm_ActiveSheet->setCellValue($current_cell_ref . $this->Xls_row, $mens_tot);
                       $this->Nm_ActiveSheet->getStyle($current_cell_ref . $this->Xls_row)->getFont()->setBold(true);
                   }
               }
               elseif ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['embutida']) {
                       $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['data']   = "";
                       $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['align']  = "left";
                       $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['type']   = "char";
                       $this->arr_export['lines'][$this->Xls_row][$this->Xls_col]['format'] = "";
               }
               $this->Xls_col++;
               $prim_cmp = false;
           }
       }
   }
   function quebra_geral_sc_free_group_by_bot() 
   {
   }

   function calc_cell($col)
   {
       $arr_alfa = array("","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
       $val_ret = "";
       $result = $col + 1;
       while ($result > 26)
       {
           $cel      = $result % 26;
           $result   = $result / 26;
           if ($cel == 0)
           {
               $cel    = 26;
               $result--;
           }
           $val_ret = $arr_alfa[$cel] . $val_ret;
       }
       $val_ret = $arr_alfa[$result] . $val_ret;
       return $val_ret;
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
   function progress_bar_end()
   {
      unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['xls_file']);
      if (is_file($this->Xls_f))
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['xls_file'] = $this->Xls_f;
      }
      $path_doc_md5 = md5($this->Ini->path_imag_temp . "/" . $this->Arquivo);
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance'][$path_doc_md5][0] = $this->Ini->path_imag_temp . "/" . $this->Arquivo;
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance'][$path_doc_md5][1] = $this->Tit_doc;
      $Mens_bar = $this->Ini->Nm_lang['lang_othr_file_msge'];
      if ($_SESSION['scriptcase']['charset'] != "UTF-8") {
          $Mens_bar = sc_convert_encoding($Mens_bar, "UTF-8", $_SESSION['scriptcase']['charset']);
      }
      $this->pb->setProgressbarMessage($Mens_bar);
      $this->pb->setDownloadLink($this->Ini->path_imag_temp . "/" . $this->Arquivo);
      $this->pb->setDownloadMd5($path_doc_md5);
      $this->pb->completed();
   }
   //---- 
   function monta_html()
   {
      global $nm_url_saida, $nm_lang;
      include($this->Ini->path_btn . $this->Ini->Str_btn_grid);
      unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['xls_file']);
      if (is_file($this->Xls_f))
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['xls_file'] = $this->Xls_f;
      }
      $path_doc_md5 = md5($this->Ini->path_imag_temp . "/" . $this->Arquivo);
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance'][$path_doc_md5][0] = $this->Ini->path_imag_temp . "/" . $this->Arquivo;
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance'][$path_doc_md5][1] = $this->Tit_doc;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
            "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML<?php echo $_SESSION['scriptcase']['reg_conf']['html_dir'] ?>>
<HEAD>
 <TITLE><?php echo $this->Ini->Nm_lang['lang_othr_grid_title'] ?> planmeal :: Excel</TITLE>
 <META http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['scriptcase']['charset_html'] ?>" />
<?php
if ($_SESSION['scriptcase']['proc_mobile'])
{
?>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<?php
}
?>
 <META http-equiv="Expires" content="Fri, Jan 01 1900 00:00:00 GMT"/>
 <META http-equiv="Last-Modified" content="<?php echo gmdate("D, d M Y H:i:s"); ?> GMT"/>
 <META http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate"/>
 <META http-equiv="Cache-Control" content="post-check=0, pre-check=0"/>
 <META http-equiv="Pragma" content="no-cache"/>
 <link rel="shortcut icon" href="../_lib/img/scriptcase__NM__ico__NM__favicon.ico">
  <link rel="stylesheet" type="text/css" href="../_lib/css/<?php echo $this->Ini->str_schema_all ?>_export.css" /> 
  <link rel="stylesheet" type="text/css" href="../_lib/css/<?php echo $this->Ini->str_schema_all ?>_export<?php echo $_SESSION['scriptcase']['reg_conf']['css_dir'] ?>.css" /> 
 <?php
 if(isset($this->Ini->str_google_fonts) && !empty($this->Ini->str_google_fonts))
 {
 ?>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->Ini->str_google_fonts ?>" />
 <?php
 }
 ?>
  <link rel="stylesheet" type="text/css" href="../_lib/buttons/<?php echo $this->Ini->Str_btn_css ?>" /> 
</HEAD>
<BODY class="scExportPage">
<?php echo $this->Ini->Ajax_result_set ?>
<table style="border-collapse: collapse; border-width: 0; height: 100%; width: 100%"><tr><td style="padding: 0; text-align: center; vertical-align: middle">
 <table class="scExportTable" align="center">
  <tr>
   <td class="scExportTitle" style="height: 25px">XLS</td>
  </tr>
  <tr>
   <td class="scExportLine" style="width: 100%">
    <table style="border-collapse: collapse; border-width: 0; width: 100%"><tr><td class="scExportLineFont" style="padding: 3px 0 0 0" id="idMessage">
    <?php echo $this->Ini->Nm_lang['lang_othr_file_msge'] ?>
    </td><td class="scExportLineFont" style="text-align:right; padding: 3px 0 0 0">
     <?php echo nmButtonOutput($this->arr_buttons, "bexportview", "document.Fview.submit()", "document.Fview.submit()", "idBtnView", "", "", "", "", "", "", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
 ?>
     <?php echo nmButtonOutput($this->arr_buttons, "bdownload", "document.Fdown.submit()", "document.Fdown.submit()", "idBtnDown", "", "", "", "", "", "", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
 ?>
     <?php echo nmButtonOutput($this->arr_buttons, "bvoltar", "document.F0.submit()", "document.F0.submit()", "idBtnBack", "", "", "", "", "", "", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
 ?>
    </td></tr></table>
   </td>
  </tr>
 </table>
</td></tr></table>
<form name="Fview" method="get" action="<?php echo $this->Ini->path_imag_temp . "/" . $this->Arquivo ?>" target="_blank" style="display: none"> 
</form>
<form name="Fdown" method="get" action="grid_dir_indicadores_avance_download.php" target="_blank" style="display: none"> 
<input type="hidden" name="script_case_init" value="<?php echo NM_encode_input($this->Ini->sc_page); ?>"> 
<input type="hidden" name="nm_tit_doc" value="grid_dir_indicadores_avance"> 
<input type="hidden" name="nm_name_doc" value="<?php echo $path_doc_md5 ?>"> 
</form>
<FORM name="F0" method=post action="./"> 
<INPUT type="hidden" name="script_case_init" value="<?php echo NM_encode_input($this->Ini->sc_page); ?>"> 
<INPUT type="hidden" name="nmgp_opcao" value="<?php echo NM_encode_input($_SESSION['sc_session'][$this->Ini->sc_page]['grid_dir_indicadores_avance']['xls_return']); ?>"> 
</FORM> 
</BODY>
</HTML>
<?php
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
