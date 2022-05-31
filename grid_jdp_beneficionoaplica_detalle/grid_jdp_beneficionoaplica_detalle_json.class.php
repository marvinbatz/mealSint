<?php

class grid_jdp_beneficionoaplica_detalle_json
{
   var $Db;
   var $Erro;
   var $Ini;
   var $Lookup;
   var $nm_data;
   var $Arquivo;
   var $Arquivo_view;
   var $Tit_doc;
   var $sc_proc_grid; 
   var $NM_cmp_hidden = array();

   function __construct()
   {
      $this->nm_data = new nm_data("es");
   }

   function monta_json()
   {
      $this->inicializa_vars();
      $this->grava_arquivo();
      if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['embutida'])
      {
          if ($this->Ini->sc_export_ajax)
          {
              $this->Arr_result['file_export']  = NM_charset_to_utf8($this->Json_f);
              $this->Arr_result['title_export'] = NM_charset_to_utf8($this->Tit_doc);
              $Temp = ob_get_clean();
              if ($Temp !== false && trim($Temp) != "")
              {
                  $this->Arr_result['htmOutput'] = NM_charset_to_utf8($Temp);
              }
              $result_json = json_encode($this->Arr_result, JSON_UNESCAPED_UNICODE);
              if ($result_json == false)
              {
                  $oJson = new Services_JSON();
                  $result_json = $oJson->encode($this->Arr_result);
              }
              echo $result_json;
              exit;
          }
          else
          {
              $this->progress_bar_end();
          }
      }
      else
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['opcao'] = "";
      }
   }

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
                   nm_limpa_str_grid_jdp_beneficionoaplica_detalle($cadapar[1]);
                   nm_protect_num_grid_jdp_beneficionoaplica_detalle($cadapar[0], $cadapar[1]);
                   if ($cadapar[1] == "@ ") {$cadapar[1] = trim($cadapar[1]); }
                   $Tmp_par   = $cadapar[0];
                   $$Tmp_par = $cadapar[1];
                   if ($Tmp_par == "nmgp_opcao")
                   {
                       $_SESSION['sc_session'][$script_case_init]['grid_jdp_beneficionoaplica_detalle']['opcao'] = $cadapar[1];
                   }
               }
          }
      }
      if (!isset($gloPlanificacion) && isset($gloplanificacion)) 
      {
         $gloPlanificacion = $gloplanificacion;
      }
      if (isset($gloPlanificacion)) 
      {
          $_SESSION['gloPlanificacion'] = $gloPlanificacion;
          nm_limpa_str_grid_jdp_beneficionoaplica_detalle($_SESSION["gloPlanificacion"]);
      }
      $dir_raiz          = strrpos($_SERVER['PHP_SELF'],"/") ;  
      $dir_raiz          = substr($_SERVER['PHP_SELF'], 0, $dir_raiz + 1) ;  
      $this->Json_use_label = true;
      $this->Json_format = false;
      $this->Tem_json_res = false;
      $this->Json_password = "";
      if (isset($_REQUEST['nm_json_label']) && !empty($_REQUEST['nm_json_label']))
      {
          $this->Json_use_label = ($_REQUEST['nm_json_label'] == "S") ? true : false;
      }
      if (isset($_REQUEST['nm_json_format']) && !empty($_REQUEST['nm_json_format']))
      {
          $this->Json_format = ($_REQUEST['nm_json_format'] == "S") ? true : false;
      }
      $this->Tem_json_res  = true;
      if (isset($_REQUEST['SC_module_export']) && $_REQUEST['SC_module_export'] != "")
      { 
          $this->Tem_json_res = (strpos(" " . $_REQUEST['SC_module_export'], "resume") !== false) ? true : false;
      } 
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['SC_Ind_Groupby'] == "sc_free_total")
      {
          $this->Tem_json_res  = false;
      }
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['SC_Ind_Groupby'] == "sc_free_group_by" && empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['SC_Gb_Free_cmp']))
      {
          $this->Tem_json_res  = false;
      }
      if (!is_file($this->Ini->root . $this->Ini->path_link . "grid_jdp_beneficionoaplica_detalle/grid_jdp_beneficionoaplica_detalle_res_json.class.php"))
      {
          $this->Tem_json_res  = false;
      }
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['embutida'] && isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['json_label']))
      {
          $this->Json_use_label = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['json_label'];
      }
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['embutida'] && isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['json_format']))
      {
          $this->Json_format = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['json_format'];
      }
      $this->nm_location = $this->Ini->sc_protocolo . $this->Ini->server . $dir_raiz; 
      if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['embutida'] && !$this->Ini->sc_export_ajax) {
          require_once($this->Ini->path_lib_php . "/sc_progress_bar.php");
          $this->pb = new scProgressBar();
          $this->pb->setRoot($this->Ini->root);
          $this->pb->setDir($_SESSION['scriptcase']['grid_jdp_beneficionoaplica_detalle']['glo_nm_path_imag_temp'] . "/");
          $this->pb->setProgressbarMd5($_GET['pbmd5']);
          $this->pb->initialize();
          $this->pb->setReturnUrl("./");
          $this->pb->setReturnOption($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['json_return']);
          if ($this->Tem_json_res) {
              $PB_plus = intval ($this->count_ger * 0.04);
              $PB_plus = ($PB_plus < 2) ? 2 : $PB_plus;
          }
          else {
              $PB_plus = intval ($this->count_ger * 0.02);
              $PB_plus = ($PB_plus < 1) ? 1 : $PB_plus;
          }
          $PB_tot = $this->count_ger + $PB_plus;
          $this->PB_dif = $PB_tot - $this->count_ger;
          $this->pb->setTotalSteps($PB_tot);
      }
      $this->nm_data = new nm_data("es");
      $this->Arquivo      = "sc_json";
      $this->Arquivo     .= "_" . date("YmdHis") . "_" . rand(0, 1000);
      $this->Arq_zip      = $this->Arquivo . "_grid_jdp_beneficionoaplica_detalle.zip";
      $this->Arquivo     .= "_grid_jdp_beneficionoaplica_detalle";
      $this->Arquivo     .= ".json";
      $this->Tit_doc      = "grid_jdp_beneficionoaplica_detalle.json";
      $this->Tit_zip      = "grid_jdp_beneficionoaplica_detalle.zip";
   }

   function prep_modulos($modulo)
   {
      $this->$modulo->Ini    = $this->Ini;
      $this->$modulo->Db     = $this->Db;
      $this->$modulo->Erro   = $this->Erro;
      $this->$modulo->Lookup = $this->Lookup;
   }

   function grava_arquivo()
   {
      global $nm_lang;
      global $nm_nada, $nm_lang;

      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
      $this->sc_proc_grid = false; 
      $nm_raiz_img  = ""; 
      $this->sc_where_orig   = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['where_orig'];
      $this->sc_where_atual  = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['where_pesq'];
      $this->sc_where_filtro = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['where_pesq_filtro'];
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['campos_busca']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['campos_busca']))
      { 
          $Busca_temp = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['campos_busca'];
          if ($_SESSION['scriptcase']['charset'] != "UTF-8")
          {
              $Busca_temp = NM_conv_charset($Busca_temp, $_SESSION['scriptcase']['charset'], "UTF-8");
          }
          $this->pl_idplanificacion = $Busca_temp['pl_idplanificacion']; 
          $tmp_pos = strpos($this->pl_idplanificacion, "##@@");
          if ($tmp_pos !== false && !is_array($this->pl_idplanificacion))
          {
              $this->pl_idplanificacion = substr($this->pl_idplanificacion, 0, $tmp_pos);
          }
          $this->sc_field_0 = $Busca_temp['sc_field_0']; 
          $tmp_pos = strpos($this->sc_field_0, "##@@");
          if ($tmp_pos !== false && !is_array($this->sc_field_0))
          {
              $this->sc_field_0 = substr($this->sc_field_0, 0, $tmp_pos);
          }
          $this->ac_nombre = $Busca_temp['ac_nombre']; 
          $tmp_pos = strpos($this->ac_nombre, "##@@");
          if ($tmp_pos !== false && !is_array($this->ac_nombre))
          {
              $this->ac_nombre = substr($this->ac_nombre, 0, $tmp_pos);
          }
      } 
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['json_name']))
      {
          $Pos = strrpos($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['json_name'], ".");
          if ($Pos === false) {
              $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['json_name'] .= ".json";
          }
          $this->Arquivo = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['json_name'];
          $this->Arq_zip = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['json_name'];
          $this->Tit_doc = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['json_name'];
          $Pos = strrpos($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['json_name'], ".");
          if ($Pos !== false) {
              $this->Arq_zip = substr($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['json_name'], 0, $Pos);
          }
          $this->Arq_zip .= ".zip";
          $this->Tit_zip  = $this->Arq_zip;
          unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['json_name']);
      }
      $this->arr_export = array('label' => array(), 'lines' => array());
      $this->arr_span   = array();

      if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['embutida'])
      { 
          $this->Json_f = $this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->Arquivo;
          $this->Zip_f = $this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->Arq_zip;
          $json_f = fopen($this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->Arquivo, "w");
      }
      $this->nm_field_dinamico = array();
      $this->nm_order_dinamico = array();
      $this->Sub_Consultas[] = "avance";
      $nmgp_select_count = "SELECT count(*) AS countTest from " . $this->Ini->nm_tabela; 
      if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mysql))
      { 
          $nmgp_select = "SELECT p.codigoP as sc_field_0, pl.codSocio as pl_codsocio, ac.nombre as ac_nombre, suba.nombre as suba_nombre, pl.fechaInicio as pl_fechainicio, pl.fechaFin as pl_fechafin, pl.detalle as pl_detalle, un.nombre as unidad, fdE.nombre as sc_field_1, tdE.nombre as sc_field_2, em.nombre as emergencia, tB.nombre as sc_field_3, pM.codigo as indicador, de.nombre as departamento, mu.nombre as municipio, co.nombre as comunidad, pl.colonia as pl_colonia, es.nombre as estado, pl.fechaInicioPlan as sc_field_5, pl.fechaFinPlan as sc_field_6, pl.informacionCualitativa as pl_informacioncualitativa, pl.observacionesAdicionales as pl_observacionesadicionales, pl.beneficiariosIndirectos as sc_field_4, pl.valorApr as sc_field_7, pl.idPlanificacion as pl_idplanificacion from " . $this->Ini->nm_tabela; 
      } 
      else 
      { 
          $nmgp_select = "SELECT p.codigoP as sc_field_0, pl.codSocio as pl_codsocio, ac.nombre as ac_nombre, suba.nombre as suba_nombre, pl.fechaInicio as pl_fechainicio, pl.fechaFin as pl_fechafin, pl.detalle as pl_detalle, un.nombre as unidad, fdE.nombre as sc_field_1, tdE.nombre as sc_field_2, em.nombre as emergencia, tB.nombre as sc_field_3, pM.codigo as indicador, de.nombre as departamento, mu.nombre as municipio, co.nombre as comunidad, pl.colonia as pl_colonia, es.nombre as estado, pl.fechaInicioPlan as sc_field_5, pl.fechaFinPlan as sc_field_6, pl.informacionCualitativa as pl_informacioncualitativa, pl.observacionesAdicionales as pl_observacionesadicionales, pl.beneficiariosIndirectos as sc_field_4, pl.valorApr as sc_field_7, pl.idPlanificacion as pl_idplanificacion from " . $this->Ini->nm_tabela; 
      } 
      $nmgp_select .= " " . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['where_pesq'];
      $nmgp_select_count .= " " . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['where_pesq'];
      $nmgp_select .= " group by pl.idPlanificacion"; 
      $nmgp_select_count .= " group by pl.idPlanificacion"; 
      $nmgp_order_by = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['order_grid'];
      $nmgp_select .= $nmgp_order_by; 
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nmgp_select_count;
      $rt = $this->Db->Execute($nmgp_select_count);
      if ($rt === false && !$rt->EOF && $GLOBALS["NM_ERRO_IBASE"] != 1)
      {
         $this->Erro->mensagem(__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg());
         exit;
      }
      $this->count_ger = $rt->fields[0];
      $rt->Close();
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nmgp_select;
      $rs = $this->Db->Execute($nmgp_select);
      if ($rs === false && !$rs->EOF && $GLOBALS["NM_ERRO_IBASE"] != 1)
      {
         $this->Erro->mensagem(__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg());
         exit;
      }
      $this->SC_seq_register = 0;
      $this->json_registro = array();
      $this->SC_seq_json   = 0;
      $PB_tot = (isset($this->count_ger) && $this->count_ger > 0) ? "/" . $this->count_ger : "";
      while (!$rs->EOF)
      {
         $this->SC_seq_register++;
         if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['embutida'] && !$this->Ini->sc_export_ajax) {
             $Mens_bar = NM_charset_to_utf8($this->Ini->Nm_lang['lang_othr_prcs']);
             $this->pb->setProgressbarMessage($Mens_bar . ": " . $this->SC_seq_register . $PB_tot);
             $this->pb->addSteps(1);
         }
         $this->sc_field_0 = $rs->fields[0] ;  
         $this->pl_codsocio = $rs->fields[1] ;  
         $this->ac_nombre = $rs->fields[2] ;  
         $this->suba_nombre = $rs->fields[3] ;  
         $this->pl_fechainicio = $rs->fields[4] ;  
         $this->pl_fechafin = $rs->fields[5] ;  
         $this->pl_detalle = $rs->fields[6] ;  
         $this->unidad = $rs->fields[7] ;  
         $this->sc_field_1 = $rs->fields[8] ;  
         $this->sc_field_2 = $rs->fields[9] ;  
         $this->emergencia = $rs->fields[10] ;  
         $this->sc_field_3 = $rs->fields[11] ;  
         $this->indicador = $rs->fields[12] ;  
         $this->departamento = $rs->fields[13] ;  
         $this->municipio = $rs->fields[14] ;  
         $this->comunidad = $rs->fields[15] ;  
         $this->pl_colonia = $rs->fields[16] ;  
         $this->estado = $rs->fields[17] ;  
         $this->sc_field_5 = $rs->fields[18] ;  
         $this->sc_field_6 = $rs->fields[19] ;  
         $this->pl_informacioncualitativa = $rs->fields[20] ;  
         $this->pl_observacionesadicionales = $rs->fields[21] ;  
         $this->sc_field_4 = $rs->fields[22] ;  
         $this->sc_field_4 = (string)$this->sc_field_4;
         $this->sc_field_7 = $rs->fields[23] ;  
         $this->sc_field_7 = (string)$this->sc_field_7;
         $this->pl_idplanificacion = $rs->fields[24] ;  
         $this->pl_idplanificacion = (string)$this->pl_idplanificacion;
         $this->Orig_sc_field_0 = $this->sc_field_0;
         $this->Orig_pl_codsocio = $this->pl_codsocio;
         $this->Orig_ac_nombre = $this->ac_nombre;
         $this->Orig_suba_nombre = $this->suba_nombre;
         $this->Orig_pl_fechainicio = $this->pl_fechainicio;
         $this->Orig_pl_fechafin = $this->pl_fechafin;
         $this->Orig_pl_detalle = $this->pl_detalle;
         $this->Orig_unidad = $this->unidad;
         $this->Orig_sc_field_1 = $this->sc_field_1;
         $this->Orig_sc_field_2 = $this->sc_field_2;
         $this->Orig_emergencia = $this->emergencia;
         $this->Orig_sc_field_3 = $this->sc_field_3;
         $this->Orig_indicador = $this->indicador;
         $this->Orig_departamento = $this->departamento;
         $this->Orig_municipio = $this->municipio;
         $this->Orig_comunidad = $this->comunidad;
         $this->Orig_pl_colonia = $this->pl_colonia;
         $this->Orig_estado = $this->estado;
         $this->Orig_sc_field_5 = $this->sc_field_5;
         $this->Orig_sc_field_6 = $this->sc_field_6;
         $this->Orig_pl_informacioncualitativa = $this->pl_informacioncualitativa;
         $this->Orig_pl_observacionesadicionales = $this->pl_observacionesadicionales;
         $this->Orig_sc_field_4 = $this->sc_field_4;
         $this->Orig_sc_field_7 = $this->sc_field_7;
         $this->Orig_pl_idplanificacion = $this->pl_idplanificacion;
         $this->sc_proc_grid = true; 
         foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['field_order'] as $Cada_col)
         { 
            if ((!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off") && !in_array($Cada_col, $this->Sub_Consultas))
            { 
                $NM_func_exp = "NM_export_" . $Cada_col;
                $this->$NM_func_exp();
            } 
         } 
         $this->SC_seq_json++;
         $rs->MoveNext();
      }
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['embutida'])
      { 
          $_SESSION['scriptcase']['export_return'] = $this->json_registro;
      }
      else
      { 
          $result_json = json_encode($this->json_registro, JSON_UNESCAPED_UNICODE);
          if ($result_json == false)
          {
              $oJson = new Services_JSON();
              $result_json = $oJson->encode($this->json_registro);
          }
          fwrite($json_f, $result_json);
          fclose($json_f);
          if ($this->Tem_json_res)
          { 
              if (!$this->Ini->sc_export_ajax) {
                  $this->PB_dif = intval ($this->PB_dif / 2);
                  $Mens_bar  = NM_charset_to_utf8($this->Ini->Nm_lang['lang_othr_prcs']);
                  $Mens_smry = NM_charset_to_utf8($this->Ini->Nm_lang['lang_othr_smry_titl']);
                  $this->pb->setProgressbarMessage($Mens_bar . ": " . $Mens_smry);
                  $this->pb->addSteps($this->PB_dif);
              }
              require_once($this->Ini->path_aplicacao . "grid_jdp_beneficionoaplica_detalle_res_json.class.php");
              $this->Res = new grid_jdp_beneficionoaplica_detalle_res_json();
              $this->prep_modulos("Res");
              $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['json_res_grid'] = true;
              $this->Res->monta_json();
          } 
          if (!$this->Ini->sc_export_ajax) {
              $Mens_bar = NM_charset_to_utf8($this->Ini->Nm_lang['lang_btns_export_finished']);
              $this->pb->setProgressbarMessage($Mens_bar);
              $this->pb->addSteps($this->PB_dif);
          }
          if ($this->Json_password != "" || $this->Tem_json_res)
          { 
              $str_zip    = "";
              $Parm_pass  = ($this->Json_password != "") ? " -p" : "";
              $Zip_f      = (FALSE !== strpos($this->Zip_f, ' ')) ? " \"" . $this->Zip_f . "\"" :  $this->Zip_f;
              $Arq_input  = (FALSE !== strpos($this->Json_f, ' ')) ? " \"" . $this->Json_f . "\"" :  $this->Json_f;
              if (is_file($Zip_f)) {
                  unlink($Zip_f);
              }
              if (FALSE !== strpos(strtolower(php_uname()), 'windows')) 
              {
                  chdir($this->Ini->path_third . "/zip/windows");
                  $str_zip = "zip.exe " . strtoupper($Parm_pass) . " -j " . $this->Json_password . " " . $Zip_f . " " . $Arq_input;
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
                  $str_zip = "./7za " . $Parm_pass . $this->Json_password . " a " . $Zip_f . " " . $Arq_input;
              }
              elseif (FALSE !== strpos(strtolower(php_uname()), 'darwin'))
              {
                  chdir($this->Ini->path_third . "/zip/mac/bin");
                  $str_zip = "./7za " . $Parm_pass . $this->Json_password . " a " . $Zip_f . " " . $Arq_input;
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
              $this->Json_f   = $this->Zip_f;
              $this->Tit_doc = $this->Tit_zip;
              if ($this->Tem_json_res)
              { 
                  $str_zip   = "";
                  $Arq_res   = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['json_res_file']['json'];
                  $Arq_input = (FALSE !== strpos($Arq_res, ' ')) ? " \"" . $Arq_res . "\"" :  $Arq_res;
                  if (FALSE !== strpos(strtolower(php_uname()), 'windows')) 
                  {
                      $str_zip = "zip.exe " . strtoupper($Parm_pass) . " -j -u " . $this->Json_password . " " . $Zip_f . " " . $Arq_input;
                  }
                  elseif (FALSE !== strpos(strtolower(php_uname()), 'linux')) 
                  {
                      $str_zip = "./7za " . $Parm_pass . $this->Json_password . " a " . $Zip_f . " " . $Arq_input;
                  }
                  elseif (FALSE !== strpos(strtolower(php_uname()), 'darwin'))
                  {
                      $str_zip = "./7za " . $Parm_pass . $this->Json_password . " a " . $Zip_f . " " . $Arq_input;
                  }
                  if (!empty($str_zip)) {
                      exec($str_zip);
                  }
                  // ----- ZIP log
                  $fp = @fopen(trim(str_replace(array(".zip",'"'), array(".log",""), $Zip_f)), 'a');
                  if ($fp)
                  {
                      @fwrite($fp, $str_zip . "\r\n\r\n");
                      @fclose($fp);
                  }
                  unlink($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['json_res_file']['json']);
              }
              unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['json_res_grid']);
          } 
      }
      if(isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['export_sel_columns']['field_order']))
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['field_order'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['export_sel_columns']['field_order'];
          unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['export_sel_columns']['field_order']);
      }
      if(isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['export_sel_columns']['usr_cmp_sel']))
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['usr_cmp_sel'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['export_sel_columns']['usr_cmp_sel'];
          unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['export_sel_columns']['usr_cmp_sel']);
      }
      $rs->Close();
   }
   //----- sc_field_0
   function NM_export_sc_field_0()
   {
         $this->sc_field_0 = NM_charset_to_utf8($this->sc_field_0);
         if ($this->Json_use_label)
         {
             $SC_Label = (isset($this->New_label['sc_field_0'])) ? $this->New_label['sc_field_0'] : "Código de Proyecto"; 
         }
         else
         {
             $SC_Label = "sc_field_0"; 
         }
         $SC_Label = NM_charset_to_utf8($SC_Label); 
         $this->json_registro[$this->SC_seq_json][$SC_Label] = $this->sc_field_0;
   }
   //----- pl_codsocio
   function NM_export_pl_codsocio()
   {
         $this->pl_codsocio = NM_charset_to_utf8($this->pl_codsocio);
         if ($this->Json_use_label)
         {
             $SC_Label = (isset($this->New_label['pl_codsocio'])) ? $this->New_label['pl_codsocio'] : "Cod Socio"; 
         }
         else
         {
             $SC_Label = "pl_codsocio"; 
         }
         $SC_Label = NM_charset_to_utf8($SC_Label); 
         $this->json_registro[$this->SC_seq_json][$SC_Label] = $this->pl_codsocio;
   }
   //----- ac_nombre
   function NM_export_ac_nombre()
   {
         $this->ac_nombre = NM_charset_to_utf8($this->ac_nombre);
         if ($this->Json_use_label)
         {
             $SC_Label = (isset($this->New_label['ac_nombre'])) ? $this->New_label['ac_nombre'] : "Actividad"; 
         }
         else
         {
             $SC_Label = "ac_nombre"; 
         }
         $SC_Label = NM_charset_to_utf8($SC_Label); 
         $this->json_registro[$this->SC_seq_json][$SC_Label] = $this->ac_nombre;
   }
   //----- suba_nombre
   function NM_export_suba_nombre()
   {
         $this->suba_nombre = NM_charset_to_utf8($this->suba_nombre);
         if ($this->Json_use_label)
         {
             $SC_Label = (isset($this->New_label['suba_nombre'])) ? $this->New_label['suba_nombre'] : "Sub Actividad"; 
         }
         else
         {
             $SC_Label = "suba_nombre"; 
         }
         $SC_Label = NM_charset_to_utf8($SC_Label); 
         $this->json_registro[$this->SC_seq_json][$SC_Label] = $this->suba_nombre;
   }
   //----- pl_fechainicio
   function NM_export_pl_fechainicio()
   {
         if ($this->Json_format)
         {
             $conteudo_x =  $this->pl_fechainicio;
             nm_conv_limpa_dado($conteudo_x, "YYYY-MM-DD");
             if (is_numeric($conteudo_x) && strlen($conteudo_x) > 0) 
             { 
                 $this->nm_data->SetaData($this->pl_fechainicio, "YYYY-MM-DD  ");
                 $this->pl_fechainicio = $this->nm_data->FormataSaida($this->nm_data->FormatRegion("DT", "ddmmaaaa"));
             } 
         }
         if ($this->Json_use_label)
         {
             $SC_Label = (isset($this->New_label['pl_fechainicio'])) ? $this->New_label['pl_fechainicio'] : "Fecha Inicio"; 
         }
         else
         {
             $SC_Label = "pl_fechainicio"; 
         }
         $SC_Label = NM_charset_to_utf8($SC_Label); 
         $this->json_registro[$this->SC_seq_json][$SC_Label] = $this->pl_fechainicio;
   }
   //----- pl_fechafin
   function NM_export_pl_fechafin()
   {
         if ($this->Json_format)
         {
             $conteudo_x =  $this->pl_fechafin;
             nm_conv_limpa_dado($conteudo_x, "YYYY-MM-DD");
             if (is_numeric($conteudo_x) && strlen($conteudo_x) > 0) 
             { 
                 $this->nm_data->SetaData($this->pl_fechafin, "YYYY-MM-DD  ");
                 $this->pl_fechafin = $this->nm_data->FormataSaida($this->nm_data->FormatRegion("DT", "ddmmaaaa"));
             } 
         }
         if ($this->Json_use_label)
         {
             $SC_Label = (isset($this->New_label['pl_fechafin'])) ? $this->New_label['pl_fechafin'] : "Fecha Fin"; 
         }
         else
         {
             $SC_Label = "pl_fechafin"; 
         }
         $SC_Label = NM_charset_to_utf8($SC_Label); 
         $this->json_registro[$this->SC_seq_json][$SC_Label] = $this->pl_fechafin;
   }
   //----- pl_detalle
   function NM_export_pl_detalle()
   {
         $this->pl_detalle = NM_charset_to_utf8($this->pl_detalle);
         if ($this->Json_use_label)
         {
             $SC_Label = (isset($this->New_label['pl_detalle'])) ? $this->New_label['pl_detalle'] : "Detalle"; 
         }
         else
         {
             $SC_Label = "pl_detalle"; 
         }
         $SC_Label = NM_charset_to_utf8($SC_Label); 
         $this->json_registro[$this->SC_seq_json][$SC_Label] = $this->pl_detalle;
   }
   //----- unidad
   function NM_export_unidad()
   {
         $this->unidad = NM_charset_to_utf8($this->unidad);
         if ($this->Json_use_label)
         {
             $SC_Label = (isset($this->New_label['unidad'])) ? $this->New_label['unidad'] : "Unidad"; 
         }
         else
         {
             $SC_Label = "unidad"; 
         }
         $SC_Label = NM_charset_to_utf8($SC_Label); 
         $this->json_registro[$this->SC_seq_json][$SC_Label] = $this->unidad;
   }
   //----- sc_field_1
   function NM_export_sc_field_1()
   {
         $this->sc_field_1 = NM_charset_to_utf8($this->sc_field_1);
         if ($this->Json_use_label)
         {
             $SC_Label = (isset($this->New_label['sc_field_1'])) ? $this->New_label['sc_field_1'] : "Frecuencia De Entrega"; 
         }
         else
         {
             $SC_Label = "sc_field_1"; 
         }
         $SC_Label = NM_charset_to_utf8($SC_Label); 
         $this->json_registro[$this->SC_seq_json][$SC_Label] = $this->sc_field_1;
   }
   //----- sc_field_2
   function NM_export_sc_field_2()
   {
         $this->sc_field_2 = NM_charset_to_utf8($this->sc_field_2);
         if ($this->Json_use_label)
         {
             $SC_Label = (isset($this->New_label['sc_field_2'])) ? $this->New_label['sc_field_2'] : "Tipo De Entrega"; 
         }
         else
         {
             $SC_Label = "sc_field_2"; 
         }
         $SC_Label = NM_charset_to_utf8($SC_Label); 
         $this->json_registro[$this->SC_seq_json][$SC_Label] = $this->sc_field_2;
   }
   //----- emergencia
   function NM_export_emergencia()
   {
         $this->emergencia = NM_charset_to_utf8($this->emergencia);
         if ($this->Json_use_label)
         {
             $SC_Label = (isset($this->New_label['emergencia'])) ? $this->New_label['emergencia'] : "Emergencia"; 
         }
         else
         {
             $SC_Label = "emergencia"; 
         }
         $SC_Label = NM_charset_to_utf8($SC_Label); 
         $this->json_registro[$this->SC_seq_json][$SC_Label] = $this->emergencia;
   }
   //----- sc_field_3
   function NM_export_sc_field_3()
   {
         $this->sc_field_3 = NM_charset_to_utf8($this->sc_field_3);
         if ($this->Json_use_label)
         {
             $SC_Label = (isset($this->New_label['sc_field_3'])) ? $this->New_label['sc_field_3'] : "Grupo De Beneficiarios"; 
         }
         else
         {
             $SC_Label = "sc_field_3"; 
         }
         $SC_Label = NM_charset_to_utf8($SC_Label); 
         $this->json_registro[$this->SC_seq_json][$SC_Label] = $this->sc_field_3;
   }
   //----- indicador
   function NM_export_indicador()
   {
         $this->indicador = NM_charset_to_utf8($this->indicador);
         if ($this->Json_use_label)
         {
             $SC_Label = (isset($this->New_label['indicador'])) ? $this->New_label['indicador'] : "Indicador"; 
         }
         else
         {
             $SC_Label = "indicador"; 
         }
         $SC_Label = NM_charset_to_utf8($SC_Label); 
         $this->json_registro[$this->SC_seq_json][$SC_Label] = $this->indicador;
   }
   //----- departamento
   function NM_export_departamento()
   {
         $this->departamento = NM_charset_to_utf8($this->departamento);
         if ($this->Json_use_label)
         {
             $SC_Label = (isset($this->New_label['departamento'])) ? $this->New_label['departamento'] : "Departamento"; 
         }
         else
         {
             $SC_Label = "departamento"; 
         }
         $SC_Label = NM_charset_to_utf8($SC_Label); 
         $this->json_registro[$this->SC_seq_json][$SC_Label] = $this->departamento;
   }
   //----- municipio
   function NM_export_municipio()
   {
         $this->municipio = NM_charset_to_utf8($this->municipio);
         if ($this->Json_use_label)
         {
             $SC_Label = (isset($this->New_label['municipio'])) ? $this->New_label['municipio'] : "Municipio"; 
         }
         else
         {
             $SC_Label = "municipio"; 
         }
         $SC_Label = NM_charset_to_utf8($SC_Label); 
         $this->json_registro[$this->SC_seq_json][$SC_Label] = $this->municipio;
   }
   //----- comunidad
   function NM_export_comunidad()
   {
         $this->comunidad = NM_charset_to_utf8($this->comunidad);
         if ($this->Json_use_label)
         {
             $SC_Label = (isset($this->New_label['comunidad'])) ? $this->New_label['comunidad'] : "Comunidad"; 
         }
         else
         {
             $SC_Label = "comunidad"; 
         }
         $SC_Label = NM_charset_to_utf8($SC_Label); 
         $this->json_registro[$this->SC_seq_json][$SC_Label] = $this->comunidad;
   }
   //----- pl_colonia
   function NM_export_pl_colonia()
   {
         $this->pl_colonia = NM_charset_to_utf8($this->pl_colonia);
         if ($this->Json_use_label)
         {
             $SC_Label = (isset($this->New_label['pl_colonia'])) ? $this->New_label['pl_colonia'] : "Colonia"; 
         }
         else
         {
             $SC_Label = "pl_colonia"; 
         }
         $SC_Label = NM_charset_to_utf8($SC_Label); 
         $this->json_registro[$this->SC_seq_json][$SC_Label] = $this->pl_colonia;
   }
   //----- estado
   function NM_export_estado()
   {
         $this->estado = NM_charset_to_utf8($this->estado);
         if ($this->Json_use_label)
         {
             $SC_Label = (isset($this->New_label['estado'])) ? $this->New_label['estado'] : "Estado"; 
         }
         else
         {
             $SC_Label = "estado"; 
         }
         $SC_Label = NM_charset_to_utf8($SC_Label); 
         $this->json_registro[$this->SC_seq_json][$SC_Label] = $this->estado;
   }
   //----- sc_field_5
   function NM_export_sc_field_5()
   {
         if ($this->Json_format)
         {
             $conteudo_x =  $this->sc_field_5;
             nm_conv_limpa_dado($conteudo_x, "YYYY-MM-DD");
             if (is_numeric($conteudo_x) && strlen($conteudo_x) > 0) 
             { 
                 $this->nm_data->SetaData($this->sc_field_5, "YYYY-MM-DD  ");
                 $this->sc_field_5 = $this->nm_data->FormataSaida($this->nm_data->FormatRegion("DT", "ddmmaaaa"));
             } 
         }
         if ($this->Json_use_label)
         {
             $SC_Label = (isset($this->New_label['sc_field_5'])) ? $this->New_label['sc_field_5'] : "Fecha Inicio Actividad"; 
         }
         else
         {
             $SC_Label = "sc_field_5"; 
         }
         $SC_Label = NM_charset_to_utf8($SC_Label); 
         $this->json_registro[$this->SC_seq_json][$SC_Label] = $this->sc_field_5;
   }
   //----- sc_field_6
   function NM_export_sc_field_6()
   {
         if ($this->Json_format)
         {
             $conteudo_x =  $this->sc_field_6;
             nm_conv_limpa_dado($conteudo_x, "YYYY-MM-DD");
             if (is_numeric($conteudo_x) && strlen($conteudo_x) > 0) 
             { 
                 $this->nm_data->SetaData($this->sc_field_6, "YYYY-MM-DD  ");
                 $this->sc_field_6 = $this->nm_data->FormataSaida($this->nm_data->FormatRegion("DT", "ddmmaaaa"));
             } 
         }
         if ($this->Json_use_label)
         {
             $SC_Label = (isset($this->New_label['sc_field_6'])) ? $this->New_label['sc_field_6'] : "Fecha Fin Actividad"; 
         }
         else
         {
             $SC_Label = "sc_field_6"; 
         }
         $SC_Label = NM_charset_to_utf8($SC_Label); 
         $this->json_registro[$this->SC_seq_json][$SC_Label] = $this->sc_field_6;
   }
   //----- pl_informacioncualitativa
   function NM_export_pl_informacioncualitativa()
   {
         $this->pl_informacioncualitativa = NM_charset_to_utf8($this->pl_informacioncualitativa);
         if ($this->Json_use_label)
         {
             $SC_Label = (isset($this->New_label['pl_informacioncualitativa'])) ? $this->New_label['pl_informacioncualitativa'] : "Informacion Cualitativa"; 
         }
         else
         {
             $SC_Label = "pl_informacioncualitativa"; 
         }
         $SC_Label = NM_charset_to_utf8($SC_Label); 
         $this->json_registro[$this->SC_seq_json][$SC_Label] = $this->pl_informacioncualitativa;
   }
   //----- pl_observacionesadicionales
   function NM_export_pl_observacionesadicionales()
   {
         $this->pl_observacionesadicionales = NM_charset_to_utf8($this->pl_observacionesadicionales);
         if ($this->Json_use_label)
         {
             $SC_Label = (isset($this->New_label['pl_observacionesadicionales'])) ? $this->New_label['pl_observacionesadicionales'] : "Observaciones Adicionales"; 
         }
         else
         {
             $SC_Label = "pl_observacionesadicionales"; 
         }
         $SC_Label = NM_charset_to_utf8($SC_Label); 
         $this->json_registro[$this->SC_seq_json][$SC_Label] = $this->pl_observacionesadicionales;
   }
   //----- sc_field_4
   function NM_export_sc_field_4()
   {
         if ($this->Json_format)
         {
             nmgp_Form_Num_Val($this->sc_field_4, $_SESSION['scriptcase']['reg_conf']['grup_num'], $_SESSION['scriptcase']['reg_conf']['dec_num'], "0", "S", "2", "", "N:" . $_SESSION['scriptcase']['reg_conf']['neg_num'] , $_SESSION['scriptcase']['reg_conf']['simb_neg'], $_SESSION['scriptcase']['reg_conf']['num_group_digit']) ; 
         }
         if ($this->Json_use_label)
         {
             $SC_Label = (isset($this->New_label['sc_field_4'])) ? $this->New_label['sc_field_4'] : "Cantidad Estimada Beneficiarios Idirectos"; 
         }
         else
         {
             $SC_Label = "sc_field_4"; 
         }
         $SC_Label = NM_charset_to_utf8($SC_Label); 
         $this->json_registro[$this->SC_seq_json][$SC_Label] = $this->sc_field_4;
   }
   //----- mediosdeverificacion
   function NM_export_mediosdeverificacion()
   {
         $this->mediosdeverificacion = NM_charset_to_utf8($this->mediosdeverificacion);
         if ($this->Json_use_label)
         {
             $SC_Label = (isset($this->New_label['mediosdeverificacion'])) ? $this->New_label['mediosdeverificacion'] : "VER MEDIOS DE VERIFICACIÓN"; 
         }
         else
         {
             $SC_Label = "mediosdeverificacion"; 
         }
         $SC_Label = NM_charset_to_utf8($SC_Label); 
         $this->json_registro[$this->SC_seq_json][$SC_Label] = $this->mediosdeverificacion;
   }
   //----- sc_field_7
   function NM_export_sc_field_7()
   {
         if ($this->Json_format)
         {
             nmgp_Form_Num_Val($this->sc_field_7, $_SESSION['scriptcase']['reg_conf']['grup_num'], $_SESSION['scriptcase']['reg_conf']['dec_num'], "0", "S", "2", "", "N:" . $_SESSION['scriptcase']['reg_conf']['neg_num'] , $_SESSION['scriptcase']['reg_conf']['simb_neg'], $_SESSION['scriptcase']['reg_conf']['num_group_digit']) ; 
         }
         if ($this->Json_use_label)
         {
             $SC_Label = (isset($this->New_label['sc_field_7'])) ? $this->New_label['sc_field_7'] : "Valor APR"; 
         }
         else
         {
             $SC_Label = "sc_field_7"; 
         }
         $SC_Label = NM_charset_to_utf8($SC_Label); 
         $this->json_registro[$this->SC_seq_json][$SC_Label] = $this->sc_field_7;
   }
   //----- beneficiarios
   function NM_export_beneficiarios()
   {
         $this->beneficiarios = NM_charset_to_utf8($this->beneficiarios);
         if ($this->Json_use_label)
         {
             $SC_Label = (isset($this->New_label['beneficiarios'])) ? $this->New_label['beneficiarios'] : "VER INGRESOS"; 
         }
         else
         {
             $SC_Label = "beneficiarios"; 
         }
         $SC_Label = NM_charset_to_utf8($SC_Label); 
         $this->json_registro[$this->SC_seq_json][$SC_Label] = $this->beneficiarios;
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
      unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['json_file']);
      if (is_file($this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->Arquivo))
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['json_file'] = $this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->Arquivo;
      }
      $path_doc_md5 = md5($this->Ini->path_imag_temp . "/" . $this->Arquivo);
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle'][$path_doc_md5][0] = $this->Ini->path_imag_temp . "/" . $this->Arquivo;
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle'][$path_doc_md5][1] = $this->Tit_doc;
      $Mens_bar = $this->Ini->Nm_lang['lang_othr_file_msge'];
      if ($_SESSION['scriptcase']['charset'] != "UTF-8") {
          $Mens_bar = sc_convert_encoding($Mens_bar, "UTF-8", $_SESSION['scriptcase']['charset']);
      }
      $this->pb->setProgressbarMessage($Mens_bar);
      $this->pb->setDownloadLink($this->Ini->path_imag_temp . "/" . $this->Arquivo);
      $this->pb->setDownloadMd5($path_doc_md5);
      $this->pb->completed();
   }
   function monta_html()
   {
      global $nm_url_saida, $nm_lang;
      include($this->Ini->path_btn . $this->Ini->Str_btn_grid);
      unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['json_file']);
      if (is_file($this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->Arquivo))
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['json_file'] = $this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->Arquivo;
      }
      $path_doc_md5 = md5($this->Ini->path_imag_temp . "/" . $this->Arquivo);
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle'][$path_doc_md5][0] = $this->Ini->path_imag_temp . "/" . $this->Arquivo;
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle'][$path_doc_md5][1] = $this->Tit_doc;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
            "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML<?php echo $_SESSION['scriptcase']['reg_conf']['html_dir'] ?>>
<HEAD>
 <TITLE><?php echo $this->Ini->Nm_lang['lang_othr_grid_title'] ?> Actividades :: JSON</TITLE>
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
   <td class="scExportTitle" style="height: 25px">JSON</td>
  </tr>
  <tr>
   <td class="scExportLine" style="width: 100%">
    <table style="border-collapse: collapse; border-width: 0; width: 100%"><tr><td class="scExportLineFont" style="padding: 3px 0 0 0" id="idMessage">
    <?php echo $this->Ini->Nm_lang['lang_othr_file_msge'] ?>
    </td><td class="scExportLineFont" style="text-align:right; padding: 3px 0 0 0">
     <?php echo nmButtonOutput($this->arr_buttons, "bdownload", "document.Fdown.submit()", "document.Fdown.submit()", "idBtnDown", "", "", "", "", "", "", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
 ?>
     <?php echo nmButtonOutput($this->arr_buttons, "bvoltar", "document.F0.submit()", "document.F0.submit()", "idBtnBack", "", "", "", "", "", "", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
 ?>
    </td></tr></table>
   </td>
  </tr>
 </table>
</td></tr></table>
<form name="Fview" method="get" action="<?php echo $this->Ini->path_imag_temp . "/" . $this->Arquivo_view ?>" target="_blank" style="display: none"> 
</form>
<form name="Fdown" method="get" action="grid_jdp_beneficionoaplica_detalle_download.php" target="_blank" style="display: none"> 
<input type="hidden" name="script_case_init" value="<?php echo NM_encode_input($this->Ini->sc_page); ?>"> 
<input type="hidden" name="nm_tit_doc" value="grid_jdp_beneficionoaplica_detalle"> 
<input type="hidden" name="nm_name_doc" value="<?php echo $path_doc_md5 ?>"> 
</form>
<FORM name="F0" method=post action="./" style="display: none"> 
<INPUT type="hidden" name="script_case_init" value="<?php echo NM_encode_input($this->Ini->sc_page); ?>"> 
<INPUT type="hidden" name="nmgp_opcao" value="<?php echo NM_encode_input($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficionoaplica_detalle']['json_return']); ?>"> 
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
