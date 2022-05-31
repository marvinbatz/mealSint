<?php

class grid_jdp_beneficiario_xml
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
   var $count_ger;

   //---- 
   function __construct()
   {
      $this->nm_data   = new nm_data("es");
   }

   //---- 
   function monta_xml()
   {
      $this->inicializa_vars();
      $this->grava_arquivo();
      if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['embutida'])
      {
          if ($this->Ini->sc_export_ajax)
          {
              $this->Arr_result['file_export']  = NM_charset_to_utf8($this->Xml_f);
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
      else
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['opcao'] = "";
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
                   nm_limpa_str_grid_jdp_beneficiario($cadapar[1]);
                   nm_protect_num_grid_jdp_beneficiario($cadapar[0], $cadapar[1]);
                   if ($cadapar[1] == "@ ") {$cadapar[1] = trim($cadapar[1]); }
                   $Tmp_par   = $cadapar[0];
                   $$Tmp_par = $cadapar[1];
                   if ($Tmp_par == "nmgp_opcao")
                   {
                       $_SESSION['sc_session'][$script_case_init]['grid_jdp_beneficiario']['opcao'] = $cadapar[1];
                   }
               }
          }
      }
      if (!isset($gloSocio) && isset($glosocio)) 
      {
         $gloSocio = $glosocio;
      }
      if (isset($gloSocio)) 
      {
          $_SESSION['gloSocio'] = $gloSocio;
          nm_limpa_str_grid_jdp_beneficiario($_SESSION["gloSocio"]);
      }
      if (!isset($gloProyecto) && isset($gloproyecto)) 
      {
         $gloProyecto = $gloproyecto;
      }
      if (isset($gloProyecto)) 
      {
          $_SESSION['gloProyecto'] = $gloProyecto;
          nm_limpa_str_grid_jdp_beneficiario($_SESSION["gloProyecto"]);
      }
      $dir_raiz          = strrpos($_SERVER['PHP_SELF'],"/") ;  
      $dir_raiz          = substr($_SERVER['PHP_SELF'], 0, $dir_raiz + 1) ;  
      $this->New_Format  = true;
      $this->Xml_tag_label = true;
      $this->Tem_xml_res = false;
      $this->Xml_password = "";
      if (isset($_REQUEST['nm_xml_tag']) && !empty($_REQUEST['nm_xml_tag']))
      {
          $this->New_Format = ($_REQUEST['nm_xml_tag'] == "tag") ? true : false;
      }
      if (isset($_REQUEST['nm_xml_label']) && !empty($_REQUEST['nm_xml_label']))
      {
          $this->Xml_tag_label = ($_REQUEST['nm_xml_label'] == "S") ? true : false;
      }
      $this->Tem_xml_res  = true;
      if (isset($_REQUEST['SC_module_export']) && $_REQUEST['SC_module_export'] != "")
      { 
          $this->Tem_xml_res = (strpos(" " . $_REQUEST['SC_module_export'], "resume") !== false) ? true : false;
      } 
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['SC_Ind_Groupby'] == "sc_free_group_by" && empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['SC_Gb_Free_cmp']))
      {
          $this->Tem_xml_res  = false;
      }
      if (!is_file($this->Ini->root . $this->Ini->path_link . "grid_jdp_beneficiario/grid_jdp_beneficiario_res_xml.class.php"))
      {
          $this->Tem_xml_res  = false;
      }
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['embutida'] && isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['xml_label']))
      {
          $this->Xml_tag_label = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['xml_label'];
          $this->New_Format    = true;
      }
      $this->nm_location = $this->Ini->sc_protocolo . $this->Ini->server . $dir_raiz; 
      require_once($this->Ini->path_aplicacao . "grid_jdp_beneficiario_total.class.php"); 
      $this->Tot      = new grid_jdp_beneficiario_total($this->Ini->sc_page);
      $this->prep_modulos("Tot");
      $Gb_geral = "quebra_geral_" . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['SC_Ind_Groupby'];
      if (method_exists($this->Tot,$Gb_geral))
      {
          $this->Tot->$Gb_geral();
          $this->count_ger = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['tot_geral'][1];
      }
      if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['embutida'] && !$this->Ini->sc_export_ajax) {
          require_once($this->Ini->path_lib_php . "/sc_progress_bar.php");
          $this->pb = new scProgressBar();
          $this->pb->setRoot($this->Ini->root);
          $this->pb->setDir($_SESSION['scriptcase']['grid_jdp_beneficiario']['glo_nm_path_imag_temp'] . "/");
          $this->pb->setProgressbarMd5($_GET['pbmd5']);
          $this->pb->initialize();
          $this->pb->setReturnUrl("./");
          $this->pb->setReturnOption($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['xml_return']);
          if ($this->Tem_xml_res) {
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
      $this->nm_data    = new nm_data("es");
      $this->Arquivo      = "sc_xml";
      $this->Arquivo     .= "_" . date("YmdHis") . "_" . rand(0, 1000);
      $this->Arq_zip      = $this->Arquivo . "_grid_jdp_beneficiario.zip";
      $this->Arquivo     .= "_grid_jdp_beneficiario";
      $this->Arquivo_view = $this->Arquivo . "_view.xml";
      $this->Arquivo     .= ".xml";
      $this->Tit_doc      = "grid_jdp_beneficiario.xml";
      $this->Tit_zip      = "grid_jdp_beneficiario.zip";
      $this->Grava_view   = false;
      if (strtolower($_SESSION['scriptcase']['charset']) != strtolower($_SESSION['scriptcase']['charset_html']))
      {
          $this->Grava_view = true;
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
      global $nm_lang;
      global $nm_nada, $nm_lang;

      $GLOBALS["script_case_init"] = $this->Ini->sc_page;
      $pos      = strrpos($this->Ini->link_grid_beneficiarios_avance_cons_emb, '/');
      $link_xml = substr($this->Ini->link_grid_beneficiarios_avance_cons_emb, 0, $pos) . "/grid_beneficiarios_avance_xml.class.php";
      if (!is_file($this->Ini->link_grid_beneficiarios_avance_cons_emb) || !is_file($link_xml))
      {
          $this->NM_cmp_hidden['avance'] = "off";
      }
      else
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_beneficiarios_avance']['embutida'] = true;
          $_SESSION['scriptcase']['grid_beneficiarios_avance']['protect_modal'] = $this->Ini->sc_page;
          include_once ($this->Ini->link_grid_beneficiarios_avance_cons_emb);
          $this->grid_beneficiarios_avance = new grid_beneficiarios_avance_apl ;
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_beneficiarios_avance']['embutida'] = false;
          unset($_SESSION['scriptcase']['grid_beneficiarios_avance']['protect_modal']);
      }
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
      $this->sc_proc_grid = false; 
      $nm_raiz_img  = ""; 
      $this->sc_where_orig   = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['where_orig'];
      $this->sc_where_atual  = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['where_pesq'];
      $this->sc_where_filtro = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['where_pesq_filtro'];
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['campos_busca']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['campos_busca']))
      { 
          $Busca_temp = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['campos_busca'];
          if ($_SESSION['scriptcase']['charset'] != "UTF-8")
          {
              $Busca_temp = NM_conv_charset($Busca_temp, $_SESSION['scriptcase']['charset'], "UTF-8");
          }
          $this->ac_nombre = $Busca_temp['ac_nombre']; 
          $tmp_pos = strpos($this->ac_nombre, "##@@");
          if ($tmp_pos !== false && !is_array($this->ac_nombre))
          {
              $this->ac_nombre = substr($this->ac_nombre, 0, $tmp_pos);
          }
          $this->suba_nombre = $Busca_temp['suba_nombre']; 
          $tmp_pos = strpos($this->suba_nombre, "##@@");
          if ($tmp_pos !== false && !is_array($this->suba_nombre))
          {
              $this->suba_nombre = substr($this->suba_nombre, 0, $tmp_pos);
          }
      } 
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['xml_name']))
      {
          $Pos = strrpos($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['xml_name'], ".");
          if ($Pos === false) {
              $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['xml_name'] .= ".xml";
          }
          $this->Arquivo = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['xml_name'];
          $this->Arq_zip = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['xml_name'];
          $this->Tit_doc = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['xml_name'];
          $Pos = strrpos($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['xml_name'], ".");
          if ($Pos !== false) {
              $this->Arq_zip = substr($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['xml_name'], 0, $Pos);
          }
          $this->Arq_zip .= ".zip";
          $this->Tit_zip  = $this->Arq_zip;
          unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['xml_name']);
      }
      if (!$this->Grava_view)
      {
          $this->Arquivo_view = $this->Arquivo;
      }
      $this->arr_export = array('label' => array(), 'lines' => array());
      $this->arr_span   = array();

      if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['embutida'])
      { 
          $xml_charset = $_SESSION['scriptcase']['charset'];
          $this->Xml_f = $this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->Arquivo;
          $this->Zip_f = $this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->Arq_zip;
          $xml_f = fopen($this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->Arquivo, "w");
          fwrite($xml_f, "<?xml version=\"1.0\" encoding=\"$xml_charset\" ?>\r\n");
          fwrite($xml_f, "<root>\r\n");
          if ($this->Grava_view)
          {
              $xml_charset_v = $_SESSION['scriptcase']['charset_html'];
              $xml_v         = fopen($this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->Arquivo_view, "w");
              fwrite($xml_v, "<?xml version=\"1.0\" encoding=\"$xml_charset_v\" ?>\r\n");
              fwrite($xml_v, "<root>\r\n");
          }
      }
      $this->nm_field_dinamico = array();
      $this->nm_order_dinamico = array();
      $nmgp_select_count = "SELECT count(*) AS countTest from " . $this->Ini->nm_tabela; 
      if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mysql))
      { 
          $nmgp_select = "SELECT p.codigoP as sc_field_0, pl.codSocio as pl_codsocio, ac.nombre as ac_nombre, suba.nombre as suba_nombre, pl.fechaInicio as pl_fechainicio, pl.fechaFin as pl_fechafin, pl.detalle as pl_detalle, un.nombre as unidad, fdE.nombre as sc_field_1, tdE.nombre as sc_field_2, em.nombre as emergencia, tB.nombre as sc_field_3, pM.codigo as indicador, de.nombre as departamento, mu.nombre as municipio, co.nombre as comunidad, pl.colonia as pl_colonia, es.nombre as estado, pl.fechaInicioPlan as sc_field_5, pl.fechaFinPlan as sc_field_6, pl.informacionCualitativa as pl_informacioncualitativa, pl.observacionesAdicionales as pl_observacionesadicionales, pl.beneficiariosIndirectos as sc_field_4, pl.valorApr as sc_field_7, p.idProyecto as p_idproyecto, pl.idPlanificacion as pl_idplanificacion from " . $this->Ini->nm_tabela; 
      } 
      else 
      { 
          $nmgp_select = "SELECT p.codigoP as sc_field_0, pl.codSocio as pl_codsocio, ac.nombre as ac_nombre, suba.nombre as suba_nombre, pl.fechaInicio as pl_fechainicio, pl.fechaFin as pl_fechafin, pl.detalle as pl_detalle, un.nombre as unidad, fdE.nombre as sc_field_1, tdE.nombre as sc_field_2, em.nombre as emergencia, tB.nombre as sc_field_3, pM.codigo as indicador, de.nombre as departamento, mu.nombre as municipio, co.nombre as comunidad, pl.colonia as pl_colonia, es.nombre as estado, pl.fechaInicioPlan as sc_field_5, pl.fechaFinPlan as sc_field_6, pl.informacionCualitativa as pl_informacioncualitativa, pl.observacionesAdicionales as pl_observacionesadicionales, pl.beneficiariosIndirectos as sc_field_4, pl.valorApr as sc_field_7, p.idProyecto as p_idproyecto, pl.idPlanificacion as pl_idplanificacion from " . $this->Ini->nm_tabela; 
      } 
      $nmgp_select .= " " . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['where_pesq'];
      $nmgp_select_count .= " " . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['where_pesq'];
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['where_resumo']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['where_resumo'])) 
      { 
          if (empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['where_pesq'])) 
          { 
              $nmgp_select .= " where " . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['where_resumo']; 
              $nmgp_select_count .= " where " . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['where_resumo']; 
          } 
          else
          { 
              $nmgp_select .= " and (" . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['where_resumo'] . ")"; 
              $nmgp_select_count .= " and (" . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['where_resumo'] . ")"; 
          } 
      } 
      $nmgp_select .= " group by pl.idPlanificacion"; 
      $nmgp_select_count .= " group by pl.idPlanificacion"; 
      $nmgp_order_by = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['order_grid'];
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
      $this->xml_registro = "";
      $PB_tot = (isset($this->count_ger) && $this->count_ger > 0) ? "/" . $this->count_ger : "";
      while (!$rs->EOF)
      {
         $this->SC_seq_register++;
         if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['embutida'] && !$this->Ini->sc_export_ajax) {
             $Mens_bar = NM_charset_to_utf8($this->Ini->Nm_lang['lang_othr_prcs']);
             $this->pb->setProgressbarMessage($Mens_bar . ": " . $this->SC_seq_register . $PB_tot);
             $this->pb->addSteps(1);
         }
         if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['embutida'])
         { 
             $this->xml_registro .= "<" . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['embutida_tit'] . ">\r\n";
         }
         elseif ($this->New_Format)
         {
             $this->xml_registro = "<grid_jdp_beneficiario>\r\n";
         }
         else
         {
             $this->xml_registro = "<grid_jdp_beneficiario";
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
         $this->p_idproyecto = $rs->fields[24] ;  
         $this->p_idproyecto = (string)$this->p_idproyecto;
         $this->pl_idplanificacion = $rs->fields[25] ;  
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
         $this->Orig_p_idproyecto = $this->p_idproyecto;
         $this->Orig_pl_idplanificacion = $this->pl_idplanificacion;
         $this->sc_proc_grid = true; 
         foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['field_order'] as $Cada_col)
         { 
            if (!isset($this->NM_cmp_hidden[$Cada_col]) || $this->NM_cmp_hidden[$Cada_col] != "off")
            { 
                $NM_func_exp = "NM_export_" . $Cada_col;
                $this->$NM_func_exp();
            } 
         } 
         if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['embutida'])
         { 
             $this->xml_registro .= "</" . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['embutida_tit'] . ">\r\n";
         }
         elseif ($this->New_Format)
         {
             $this->xml_registro .= "</grid_jdp_beneficiario>\r\n";
         }
         else
         {
             $this->xml_registro .= " />\r\n";
         }
         if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['embutida'])
         { 
             fwrite($xml_f, $this->xml_registro);
             if ($this->Grava_view)
             {
                fwrite($xml_v, $this->xml_registro);
             }
         }
         $rs->MoveNext();
      }
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['embutida'])
      { 
          if (!$this->New_Format)
          {
              $this->xml_registro = "";
          }
          $_SESSION['scriptcase']['export_return'] = $this->xml_registro;
      }
      else
      { 
          fwrite($xml_f, "</root>");
          fclose($xml_f);
          if ($this->Grava_view)
          {
             fwrite($xml_v, "</root>");
             fclose($xml_v);
          }
          if ($this->Tem_xml_res)
          { 
              if (!$this->Ini->sc_export_ajax) {
                  $this->PB_dif = intval ($this->PB_dif / 2);
                  $Mens_bar  = NM_charset_to_utf8($this->Ini->Nm_lang['lang_othr_prcs']);
                  $Mens_smry = NM_charset_to_utf8($this->Ini->Nm_lang['lang_othr_smry_titl']);
                  $this->pb->setProgressbarMessage($Mens_bar . ": " . $Mens_smry);
                  $this->pb->addSteps($this->PB_dif);
              }
              require_once($this->Ini->path_aplicacao . "grid_jdp_beneficiario_res_xml.class.php");
              $this->Res = new grid_jdp_beneficiario_res_xml();
              $this->prep_modulos("Res");
              $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['xml_res_grid'] = true;
              $this->Res->monta_xml();
          } 
          if (!$this->Ini->sc_export_ajax) {
              $Mens_bar = NM_charset_to_utf8($this->Ini->Nm_lang['lang_btns_export_finished']);
              $this->pb->setProgressbarMessage($Mens_bar);
              $this->pb->addSteps($this->PB_dif);
          }
          if ($this->Xml_password != "" || $this->Tem_xml_res)
          { 
              $str_zip    = "";
              $Parm_pass  = ($this->Xml_password != "") ? " -p" : "";
              $Zip_f      = (FALSE !== strpos($this->Zip_f, ' ')) ? " \"" . $this->Zip_f . "\"" :  $this->Zip_f;
              $Arq_input  = (FALSE !== strpos($this->Xml_f, ' ')) ? " \"" . $this->Xml_f . "\"" :  $this->Xml_f;
              if (is_file($Zip_f)) {
                  unlink($Zip_f);
              }
              if (FALSE !== strpos(strtolower(php_uname()), 'windows')) 
              {
                  chdir($this->Ini->path_third . "/zip/windows");
                  $str_zip = "zip.exe " . strtoupper($Parm_pass) . " -j " . $this->Xml_password . " " . $Zip_f . " " . $Arq_input;
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
                  $str_zip = "./7za " . $Parm_pass . $this->Xml_password . " a " . $Zip_f . " " . $Arq_input;
              }
              elseif (FALSE !== strpos(strtolower(php_uname()), 'darwin'))
              {
                  chdir($this->Ini->path_third . "/zip/mac/bin");
                  $str_zip = "./7za " . $Parm_pass . $this->Xml_password . " a " . $Zip_f . " " . $Arq_input;
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
              $this->Xml_f   = $this->Zip_f;
              $this->Tit_doc = $this->Tit_zip;
              if ($this->Tem_xml_res)
              { 
                  $str_zip   = "";
                  $Arq_res   = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['xml_res_file']['xml'];
                  $Arq_input = (FALSE !== strpos($Arq_res, ' ')) ? " \"" . $Arq_res . "\"" :  $Arq_res;
                  if (FALSE !== strpos(strtolower(php_uname()), 'windows')) 
                  {
                      $str_zip = "zip.exe " . strtoupper($Parm_pass) . " -j -u " . $this->Xml_password . " " . $Zip_f . " " . $Arq_input;
                  }
                  elseif (FALSE !== strpos(strtolower(php_uname()), 'linux')) 
                  {
                      $str_zip = "./7za " . $Parm_pass . $this->Xml_password . " a " . $Zip_f . " " . $Arq_input;
                  }
                  elseif (FALSE !== strpos(strtolower(php_uname()), 'darwin'))
                  {
                      $str_zip = "./7za " . $Parm_pass . $this->Xml_password . " a " . $Zip_f . " " . $Arq_input;
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
                  unlink($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['xml_res_file']['xml']);
              }
              if ($this->Grava_view)
              {
                  $str_zip    = "";
                  $xml_view_f = $this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->Arquivo_view;
                  $zip_view_f = str_replace(".zip", "_view.zip", $this->Zip_f);
                  $zip_arq_v  = str_replace(".zip", "_view.zip", $this->Arq_zip);
                  $Zip_f      = (FALSE !== strpos($zip_view_f, ' ')) ? " \"" . $zip_view_f . "\"" :  $zip_view_f;
                  $Arq_input  = (FALSE !== strpos($xml_view_ff, ' ')) ? " \"" . $xml_view_f . "\"" :  $xml_view_f;
                  if (is_file($Zip_f)) {
                      unlink($Zip_f);
                  }
                  if (FALSE !== strpos(strtolower(php_uname()), 'windows')) 
                  {
                      chdir($this->Ini->path_third . "/zip/windows");
                      $str_zip = "zip.exe " . strtoupper($Parm_pass) . " -j " . $this->Xml_password . " " . $Zip_f . " " . $Arq_input;
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
                      $str_zip = "./7za " . $Parm_pass . $this->Xml_password . " a " . $Zip_f . " " . $Arq_input;
                  }
                  elseif (FALSE !== strpos(strtolower(php_uname()), 'darwin'))
                  {
                      chdir($this->Ini->path_third . "/zip/mac/bin");
                      $str_zip = "./7za " . $Parm_pass . $this->Xml_password . " a " . $Zip_f . " " . $Arq_input;
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
                  unlink($Arq_input);
                  $this->Arquivo_view = $zip_arq_v;
                  if ($this->Tem_xml_res)
                  { 
                      $str_zip   = "";
                      $Arq_res   = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['xml_res_file']['view'];
                      $Arq_input = (FALSE !== strpos($Arq_res, ' ')) ? " \"" . $Arq_res . "\"" :  $Arq_res;
                      if (FALSE !== strpos(strtolower(php_uname()), 'windows')) 
                      {
                          $str_zip = "zip.exe " . strtoupper($Parm_pass) . " -j -u " . $this->Xml_password . " " . $Zip_f . " " . $Arq_input;
                      }
                      elseif (FALSE !== strpos(strtolower(php_uname()), 'linux')) 
                      {
                          $str_zip = "./7za " . $Parm_pass . $this->Xml_password . " a " . $Zip_f . " " . $Arq_input;
                      }
                      elseif (FALSE !== strpos(strtolower(php_uname()), 'darwin'))
                      {
                          $str_zip = "./7za " . $Parm_pass . $this->Xml_password . " a " . $Zip_f . " " . $Arq_input;
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
                      unlink($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['xml_res_file']['view']);
                  }
              } 
              else 
              {
                  $this->Arquivo_view = $this->Arq_zip;
              } 
              unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['xml_res_grid']);
          } 
      }
      if(isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['export_sel_columns']['field_order']))
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['field_order'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['export_sel_columns']['field_order'];
          unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['export_sel_columns']['field_order']);
      }
      if(isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['export_sel_columns']['usr_cmp_sel']))
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['usr_cmp_sel'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['export_sel_columns']['usr_cmp_sel'];
          unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['export_sel_columns']['usr_cmp_sel']);
      }
      $rs->Close();
   }
   //----- sc_field_0
   function NM_export_sc_field_0()
   {
         if ($_SESSION['scriptcase']['charset'] == "UTF-8" && !NM_is_utf8($this->sc_field_0))
         {
             $this->sc_field_0 = sc_convert_encoding($this->sc_field_0, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         if ($this->Xml_tag_label)
         {
             $SC_Label = (isset($this->New_label['sc_field_0'])) ? $this->New_label['sc_field_0'] : "Código de Proyecto"; 
         }
         else
         {
             $SC_Label = "sc_field_0"; 
         }
         $this->clear_tag($SC_Label); 
         if ($this->New_Format)
         {
             $this->xml_registro .= " <" . $SC_Label . ">" . $this->trata_dados($this->sc_field_0) . "</" . $SC_Label . ">\r\n";
         }
         else
         {
             $this->xml_registro .= " " . $SC_Label . " =\"" . $this->trata_dados($this->sc_field_0) . "\"";
         }
   }
   //----- pl_codsocio
   function NM_export_pl_codsocio()
   {
         if ($_SESSION['scriptcase']['charset'] == "UTF-8" && !NM_is_utf8($this->pl_codsocio))
         {
             $this->pl_codsocio = sc_convert_encoding($this->pl_codsocio, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         if ($this->Xml_tag_label)
         {
             $SC_Label = (isset($this->New_label['pl_codsocio'])) ? $this->New_label['pl_codsocio'] : "Cod Socio"; 
         }
         else
         {
             $SC_Label = "pl_codsocio"; 
         }
         $this->clear_tag($SC_Label); 
         if ($this->New_Format)
         {
             $this->xml_registro .= " <" . $SC_Label . ">" . $this->trata_dados($this->pl_codsocio) . "</" . $SC_Label . ">\r\n";
         }
         else
         {
             $this->xml_registro .= " " . $SC_Label . " =\"" . $this->trata_dados($this->pl_codsocio) . "\"";
         }
   }
   //----- ac_nombre
   function NM_export_ac_nombre()
   {
         if ($_SESSION['scriptcase']['charset'] == "UTF-8" && !NM_is_utf8($this->ac_nombre))
         {
             $this->ac_nombre = sc_convert_encoding($this->ac_nombre, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         if ($this->Xml_tag_label)
         {
             $SC_Label = (isset($this->New_label['ac_nombre'])) ? $this->New_label['ac_nombre'] : "Actividad"; 
         }
         else
         {
             $SC_Label = "ac_nombre"; 
         }
         $this->clear_tag($SC_Label); 
         if ($this->New_Format)
         {
             $this->xml_registro .= " <" . $SC_Label . ">" . $this->trata_dados($this->ac_nombre) . "</" . $SC_Label . ">\r\n";
         }
         else
         {
             $this->xml_registro .= " " . $SC_Label . " =\"" . $this->trata_dados($this->ac_nombre) . "\"";
         }
   }
   //----- suba_nombre
   function NM_export_suba_nombre()
   {
         if ($_SESSION['scriptcase']['charset'] == "UTF-8" && !NM_is_utf8($this->suba_nombre))
         {
             $this->suba_nombre = sc_convert_encoding($this->suba_nombre, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         if ($this->Xml_tag_label)
         {
             $SC_Label = (isset($this->New_label['suba_nombre'])) ? $this->New_label['suba_nombre'] : "Sub Actividad"; 
         }
         else
         {
             $SC_Label = "suba_nombre"; 
         }
         $this->clear_tag($SC_Label); 
         if ($this->New_Format)
         {
             $this->xml_registro .= " <" . $SC_Label . ">" . $this->trata_dados($this->suba_nombre) . "</" . $SC_Label . ">\r\n";
         }
         else
         {
             $this->xml_registro .= " " . $SC_Label . " =\"" . $this->trata_dados($this->suba_nombre) . "\"";
         }
   }
   //----- pl_fechainicio
   function NM_export_pl_fechainicio()
   {
             $conteudo_x =  $this->pl_fechainicio;
             nm_conv_limpa_dado($conteudo_x, "YYYY-MM-DD");
             if (is_numeric($conteudo_x) && strlen($conteudo_x) > 0) 
             { 
                 $this->nm_data->SetaData($this->pl_fechainicio, "YYYY-MM-DD  ");
                 $this->pl_fechainicio = $this->nm_data->FormataSaida($this->nm_data->FormatRegion("DT", "ddmmaaaa"));
             } 
         if ($this->Xml_tag_label)
         {
             $SC_Label = (isset($this->New_label['pl_fechainicio'])) ? $this->New_label['pl_fechainicio'] : "Fecha Inicio"; 
         }
         else
         {
             $SC_Label = "pl_fechainicio"; 
         }
         $this->clear_tag($SC_Label); 
         if ($this->New_Format)
         {
             $this->xml_registro .= " <" . $SC_Label . ">" . $this->trata_dados($this->pl_fechainicio) . "</" . $SC_Label . ">\r\n";
         }
         else
         {
             $this->xml_registro .= " " . $SC_Label . " =\"" . $this->trata_dados($this->pl_fechainicio) . "\"";
         }
   }
   //----- pl_fechafin
   function NM_export_pl_fechafin()
   {
             $conteudo_x =  $this->pl_fechafin;
             nm_conv_limpa_dado($conteudo_x, "YYYY-MM-DD");
             if (is_numeric($conteudo_x) && strlen($conteudo_x) > 0) 
             { 
                 $this->nm_data->SetaData($this->pl_fechafin, "YYYY-MM-DD  ");
                 $this->pl_fechafin = $this->nm_data->FormataSaida($this->nm_data->FormatRegion("DT", "ddmmaaaa"));
             } 
         if ($this->Xml_tag_label)
         {
             $SC_Label = (isset($this->New_label['pl_fechafin'])) ? $this->New_label['pl_fechafin'] : "Fecha Fin"; 
         }
         else
         {
             $SC_Label = "pl_fechafin"; 
         }
         $this->clear_tag($SC_Label); 
         if ($this->New_Format)
         {
             $this->xml_registro .= " <" . $SC_Label . ">" . $this->trata_dados($this->pl_fechafin) . "</" . $SC_Label . ">\r\n";
         }
         else
         {
             $this->xml_registro .= " " . $SC_Label . " =\"" . $this->trata_dados($this->pl_fechafin) . "\"";
         }
   }
   //----- pl_detalle
   function NM_export_pl_detalle()
   {
         if ($_SESSION['scriptcase']['charset'] == "UTF-8" && !NM_is_utf8($this->pl_detalle))
         {
             $this->pl_detalle = sc_convert_encoding($this->pl_detalle, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         if ($this->Xml_tag_label)
         {
             $SC_Label = (isset($this->New_label['pl_detalle'])) ? $this->New_label['pl_detalle'] : "Detalle"; 
         }
         else
         {
             $SC_Label = "pl_detalle"; 
         }
         $this->clear_tag($SC_Label); 
         if ($this->New_Format)
         {
             $this->xml_registro .= " <" . $SC_Label . ">" . $this->trata_dados($this->pl_detalle) . "</" . $SC_Label . ">\r\n";
         }
         else
         {
             $this->xml_registro .= " " . $SC_Label . " =\"" . $this->trata_dados($this->pl_detalle) . "\"";
         }
   }
   //----- unidad
   function NM_export_unidad()
   {
         if ($_SESSION['scriptcase']['charset'] == "UTF-8" && !NM_is_utf8($this->unidad))
         {
             $this->unidad = sc_convert_encoding($this->unidad, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         if ($this->Xml_tag_label)
         {
             $SC_Label = (isset($this->New_label['unidad'])) ? $this->New_label['unidad'] : "Unidad"; 
         }
         else
         {
             $SC_Label = "unidad"; 
         }
         $this->clear_tag($SC_Label); 
         if ($this->New_Format)
         {
             $this->xml_registro .= " <" . $SC_Label . ">" . $this->trata_dados($this->unidad) . "</" . $SC_Label . ">\r\n";
         }
         else
         {
             $this->xml_registro .= " " . $SC_Label . " =\"" . $this->trata_dados($this->unidad) . "\"";
         }
   }
   //----- sc_field_1
   function NM_export_sc_field_1()
   {
         if ($_SESSION['scriptcase']['charset'] == "UTF-8" && !NM_is_utf8($this->sc_field_1))
         {
             $this->sc_field_1 = sc_convert_encoding($this->sc_field_1, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         if ($this->Xml_tag_label)
         {
             $SC_Label = (isset($this->New_label['sc_field_1'])) ? $this->New_label['sc_field_1'] : "Frecuencia De Entrega"; 
         }
         else
         {
             $SC_Label = "sc_field_1"; 
         }
         $this->clear_tag($SC_Label); 
         if ($this->New_Format)
         {
             $this->xml_registro .= " <" . $SC_Label . ">" . $this->trata_dados($this->sc_field_1) . "</" . $SC_Label . ">\r\n";
         }
         else
         {
             $this->xml_registro .= " " . $SC_Label . " =\"" . $this->trata_dados($this->sc_field_1) . "\"";
         }
   }
   //----- sc_field_2
   function NM_export_sc_field_2()
   {
         if ($_SESSION['scriptcase']['charset'] == "UTF-8" && !NM_is_utf8($this->sc_field_2))
         {
             $this->sc_field_2 = sc_convert_encoding($this->sc_field_2, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         if ($this->Xml_tag_label)
         {
             $SC_Label = (isset($this->New_label['sc_field_2'])) ? $this->New_label['sc_field_2'] : "Tipo De Entrega"; 
         }
         else
         {
             $SC_Label = "sc_field_2"; 
         }
         $this->clear_tag($SC_Label); 
         if ($this->New_Format)
         {
             $this->xml_registro .= " <" . $SC_Label . ">" . $this->trata_dados($this->sc_field_2) . "</" . $SC_Label . ">\r\n";
         }
         else
         {
             $this->xml_registro .= " " . $SC_Label . " =\"" . $this->trata_dados($this->sc_field_2) . "\"";
         }
   }
   //----- emergencia
   function NM_export_emergencia()
   {
         if ($_SESSION['scriptcase']['charset'] == "UTF-8" && !NM_is_utf8($this->emergencia))
         {
             $this->emergencia = sc_convert_encoding($this->emergencia, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         if ($this->Xml_tag_label)
         {
             $SC_Label = (isset($this->New_label['emergencia'])) ? $this->New_label['emergencia'] : "Emergencia"; 
         }
         else
         {
             $SC_Label = "emergencia"; 
         }
         $this->clear_tag($SC_Label); 
         if ($this->New_Format)
         {
             $this->xml_registro .= " <" . $SC_Label . ">" . $this->trata_dados($this->emergencia) . "</" . $SC_Label . ">\r\n";
         }
         else
         {
             $this->xml_registro .= " " . $SC_Label . " =\"" . $this->trata_dados($this->emergencia) . "\"";
         }
   }
   //----- sc_field_3
   function NM_export_sc_field_3()
   {
         if ($_SESSION['scriptcase']['charset'] == "UTF-8" && !NM_is_utf8($this->sc_field_3))
         {
             $this->sc_field_3 = sc_convert_encoding($this->sc_field_3, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         if ($this->Xml_tag_label)
         {
             $SC_Label = (isset($this->New_label['sc_field_3'])) ? $this->New_label['sc_field_3'] : "Grupo De Beneficiarios"; 
         }
         else
         {
             $SC_Label = "sc_field_3"; 
         }
         $this->clear_tag($SC_Label); 
         if ($this->New_Format)
         {
             $this->xml_registro .= " <" . $SC_Label . ">" . $this->trata_dados($this->sc_field_3) . "</" . $SC_Label . ">\r\n";
         }
         else
         {
             $this->xml_registro .= " " . $SC_Label . " =\"" . $this->trata_dados($this->sc_field_3) . "\"";
         }
   }
   //----- indicador
   function NM_export_indicador()
   {
         if ($_SESSION['scriptcase']['charset'] == "UTF-8" && !NM_is_utf8($this->indicador))
         {
             $this->indicador = sc_convert_encoding($this->indicador, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         if ($this->Xml_tag_label)
         {
             $SC_Label = (isset($this->New_label['indicador'])) ? $this->New_label['indicador'] : "Indicador"; 
         }
         else
         {
             $SC_Label = "indicador"; 
         }
         $this->clear_tag($SC_Label); 
         if ($this->New_Format)
         {
             $this->xml_registro .= " <" . $SC_Label . ">" . $this->trata_dados($this->indicador) . "</" . $SC_Label . ">\r\n";
         }
         else
         {
             $this->xml_registro .= " " . $SC_Label . " =\"" . $this->trata_dados($this->indicador) . "\"";
         }
   }
   //----- departamento
   function NM_export_departamento()
   {
         if ($_SESSION['scriptcase']['charset'] == "UTF-8" && !NM_is_utf8($this->departamento))
         {
             $this->departamento = sc_convert_encoding($this->departamento, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         if ($this->Xml_tag_label)
         {
             $SC_Label = (isset($this->New_label['departamento'])) ? $this->New_label['departamento'] : "Departamento"; 
         }
         else
         {
             $SC_Label = "departamento"; 
         }
         $this->clear_tag($SC_Label); 
         if ($this->New_Format)
         {
             $this->xml_registro .= " <" . $SC_Label . ">" . $this->trata_dados($this->departamento) . "</" . $SC_Label . ">\r\n";
         }
         else
         {
             $this->xml_registro .= " " . $SC_Label . " =\"" . $this->trata_dados($this->departamento) . "\"";
         }
   }
   //----- municipio
   function NM_export_municipio()
   {
         if ($_SESSION['scriptcase']['charset'] == "UTF-8" && !NM_is_utf8($this->municipio))
         {
             $this->municipio = sc_convert_encoding($this->municipio, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         if ($this->Xml_tag_label)
         {
             $SC_Label = (isset($this->New_label['municipio'])) ? $this->New_label['municipio'] : "Municipio"; 
         }
         else
         {
             $SC_Label = "municipio"; 
         }
         $this->clear_tag($SC_Label); 
         if ($this->New_Format)
         {
             $this->xml_registro .= " <" . $SC_Label . ">" . $this->trata_dados($this->municipio) . "</" . $SC_Label . ">\r\n";
         }
         else
         {
             $this->xml_registro .= " " . $SC_Label . " =\"" . $this->trata_dados($this->municipio) . "\"";
         }
   }
   //----- comunidad
   function NM_export_comunidad()
   {
         if ($_SESSION['scriptcase']['charset'] == "UTF-8" && !NM_is_utf8($this->comunidad))
         {
             $this->comunidad = sc_convert_encoding($this->comunidad, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         if ($this->Xml_tag_label)
         {
             $SC_Label = (isset($this->New_label['comunidad'])) ? $this->New_label['comunidad'] : "Comunidad"; 
         }
         else
         {
             $SC_Label = "comunidad"; 
         }
         $this->clear_tag($SC_Label); 
         if ($this->New_Format)
         {
             $this->xml_registro .= " <" . $SC_Label . ">" . $this->trata_dados($this->comunidad) . "</" . $SC_Label . ">\r\n";
         }
         else
         {
             $this->xml_registro .= " " . $SC_Label . " =\"" . $this->trata_dados($this->comunidad) . "\"";
         }
   }
   //----- pl_colonia
   function NM_export_pl_colonia()
   {
         if ($_SESSION['scriptcase']['charset'] == "UTF-8" && !NM_is_utf8($this->pl_colonia))
         {
             $this->pl_colonia = sc_convert_encoding($this->pl_colonia, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         if ($this->Xml_tag_label)
         {
             $SC_Label = (isset($this->New_label['pl_colonia'])) ? $this->New_label['pl_colonia'] : "Colonia"; 
         }
         else
         {
             $SC_Label = "pl_colonia"; 
         }
         $this->clear_tag($SC_Label); 
         if ($this->New_Format)
         {
             $this->xml_registro .= " <" . $SC_Label . ">" . $this->trata_dados($this->pl_colonia) . "</" . $SC_Label . ">\r\n";
         }
         else
         {
             $this->xml_registro .= " " . $SC_Label . " =\"" . $this->trata_dados($this->pl_colonia) . "\"";
         }
   }
   //----- estado
   function NM_export_estado()
   {
         if ($_SESSION['scriptcase']['charset'] == "UTF-8" && !NM_is_utf8($this->estado))
         {
             $this->estado = sc_convert_encoding($this->estado, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         if ($this->Xml_tag_label)
         {
             $SC_Label = (isset($this->New_label['estado'])) ? $this->New_label['estado'] : "Estado"; 
         }
         else
         {
             $SC_Label = "estado"; 
         }
         $this->clear_tag($SC_Label); 
         if ($this->New_Format)
         {
             $this->xml_registro .= " <" . $SC_Label . ">" . $this->trata_dados($this->estado) . "</" . $SC_Label . ">\r\n";
         }
         else
         {
             $this->xml_registro .= " " . $SC_Label . " =\"" . $this->trata_dados($this->estado) . "\"";
         }
   }
   //----- sc_field_5
   function NM_export_sc_field_5()
   {
             $conteudo_x =  $this->sc_field_5;
             nm_conv_limpa_dado($conteudo_x, "YYYY-MM-DD");
             if (is_numeric($conteudo_x) && strlen($conteudo_x) > 0) 
             { 
                 $this->nm_data->SetaData($this->sc_field_5, "YYYY-MM-DD  ");
                 $this->sc_field_5 = $this->nm_data->FormataSaida($this->nm_data->FormatRegion("DT", "ddmmaaaa"));
             } 
         if ($this->Xml_tag_label)
         {
             $SC_Label = (isset($this->New_label['sc_field_5'])) ? $this->New_label['sc_field_5'] : "Fecha Inicio Actividad"; 
         }
         else
         {
             $SC_Label = "sc_field_5"; 
         }
         $this->clear_tag($SC_Label); 
         if ($this->New_Format)
         {
             $this->xml_registro .= " <" . $SC_Label . ">" . $this->trata_dados($this->sc_field_5) . "</" . $SC_Label . ">\r\n";
         }
         else
         {
             $this->xml_registro .= " " . $SC_Label . " =\"" . $this->trata_dados($this->sc_field_5) . "\"";
         }
   }
   //----- sc_field_6
   function NM_export_sc_field_6()
   {
             $conteudo_x =  $this->sc_field_6;
             nm_conv_limpa_dado($conteudo_x, "YYYY-MM-DD");
             if (is_numeric($conteudo_x) && strlen($conteudo_x) > 0) 
             { 
                 $this->nm_data->SetaData($this->sc_field_6, "YYYY-MM-DD  ");
                 $this->sc_field_6 = $this->nm_data->FormataSaida($this->nm_data->FormatRegion("DT", "ddmmaaaa"));
             } 
         if ($this->Xml_tag_label)
         {
             $SC_Label = (isset($this->New_label['sc_field_6'])) ? $this->New_label['sc_field_6'] : "Fecha Fin Actividad"; 
         }
         else
         {
             $SC_Label = "sc_field_6"; 
         }
         $this->clear_tag($SC_Label); 
         if ($this->New_Format)
         {
             $this->xml_registro .= " <" . $SC_Label . ">" . $this->trata_dados($this->sc_field_6) . "</" . $SC_Label . ">\r\n";
         }
         else
         {
             $this->xml_registro .= " " . $SC_Label . " =\"" . $this->trata_dados($this->sc_field_6) . "\"";
         }
   }
   //----- pl_informacioncualitativa
   function NM_export_pl_informacioncualitativa()
   {
         if ($_SESSION['scriptcase']['charset'] == "UTF-8" && !NM_is_utf8($this->pl_informacioncualitativa))
         {
             $this->pl_informacioncualitativa = sc_convert_encoding($this->pl_informacioncualitativa, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         if ($this->Xml_tag_label)
         {
             $SC_Label = (isset($this->New_label['pl_informacioncualitativa'])) ? $this->New_label['pl_informacioncualitativa'] : "Informacion Cualitativa"; 
         }
         else
         {
             $SC_Label = "pl_informacioncualitativa"; 
         }
         $this->clear_tag($SC_Label); 
         if ($this->New_Format)
         {
             $this->xml_registro .= " <" . $SC_Label . ">" . $this->trata_dados($this->pl_informacioncualitativa) . "</" . $SC_Label . ">\r\n";
         }
         else
         {
             $this->xml_registro .= " " . $SC_Label . " =\"" . $this->trata_dados($this->pl_informacioncualitativa) . "\"";
         }
   }
   //----- pl_observacionesadicionales
   function NM_export_pl_observacionesadicionales()
   {
         if ($_SESSION['scriptcase']['charset'] == "UTF-8" && !NM_is_utf8($this->pl_observacionesadicionales))
         {
             $this->pl_observacionesadicionales = sc_convert_encoding($this->pl_observacionesadicionales, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         if ($this->Xml_tag_label)
         {
             $SC_Label = (isset($this->New_label['pl_observacionesadicionales'])) ? $this->New_label['pl_observacionesadicionales'] : "Observaciones Adicionales"; 
         }
         else
         {
             $SC_Label = "pl_observacionesadicionales"; 
         }
         $this->clear_tag($SC_Label); 
         if ($this->New_Format)
         {
             $this->xml_registro .= " <" . $SC_Label . ">" . $this->trata_dados($this->pl_observacionesadicionales) . "</" . $SC_Label . ">\r\n";
         }
         else
         {
             $this->xml_registro .= " " . $SC_Label . " =\"" . $this->trata_dados($this->pl_observacionesadicionales) . "\"";
         }
   }
   //----- sc_field_4
   function NM_export_sc_field_4()
   {
             nmgp_Form_Num_Val($this->sc_field_4, $_SESSION['scriptcase']['reg_conf']['grup_num'], $_SESSION['scriptcase']['reg_conf']['dec_num'], "0", "S", "2", "", "N:" . $_SESSION['scriptcase']['reg_conf']['neg_num'] , $_SESSION['scriptcase']['reg_conf']['simb_neg'], $_SESSION['scriptcase']['reg_conf']['num_group_digit']) ; 
         if ($this->Xml_tag_label)
         {
             $SC_Label = (isset($this->New_label['sc_field_4'])) ? $this->New_label['sc_field_4'] : "Cantidad Estimada Beneficiarios Idirectos"; 
         }
         else
         {
             $SC_Label = "sc_field_4"; 
         }
         $this->clear_tag($SC_Label); 
         if ($this->New_Format)
         {
             $this->xml_registro .= " <" . $SC_Label . ">" . $this->trata_dados($this->sc_field_4) . "</" . $SC_Label . ">\r\n";
         }
         else
         {
             $this->xml_registro .= " " . $SC_Label . " =\"" . $this->trata_dados($this->sc_field_4) . "\"";
         }
   }
   //----- mediosdeverificacion
   function NM_export_mediosdeverificacion()
   {
         if ($_SESSION['scriptcase']['charset'] == "UTF-8" && !NM_is_utf8($this->mediosdeverificacion))
         {
             $this->mediosdeverificacion = sc_convert_encoding($this->mediosdeverificacion, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         if ($this->Xml_tag_label)
         {
             $SC_Label = (isset($this->New_label['mediosdeverificacion'])) ? $this->New_label['mediosdeverificacion'] : "VER MEDIOS DE VERIFICACIÓN"; 
         }
         else
         {
             $SC_Label = "mediosdeverificacion"; 
         }
         $this->clear_tag($SC_Label); 
         if ($this->New_Format)
         {
             $this->xml_registro .= " <" . $SC_Label . ">" . $this->trata_dados($this->mediosdeverificacion) . "</" . $SC_Label . ">\r\n";
         }
         else
         {
             $this->xml_registro .= " " . $SC_Label . " =\"" . $this->trata_dados($this->mediosdeverificacion) . "\"";
         }
   }
   //----- sc_field_7
   function NM_export_sc_field_7()
   {
             nmgp_Form_Num_Val($this->sc_field_7, $_SESSION['scriptcase']['reg_conf']['grup_num'], $_SESSION['scriptcase']['reg_conf']['dec_num'], "0", "S", "2", "", "N:" . $_SESSION['scriptcase']['reg_conf']['neg_num'] , $_SESSION['scriptcase']['reg_conf']['simb_neg'], $_SESSION['scriptcase']['reg_conf']['num_group_digit']) ; 
         if ($this->Xml_tag_label)
         {
             $SC_Label = (isset($this->New_label['sc_field_7'])) ? $this->New_label['sc_field_7'] : "Valor APR"; 
         }
         else
         {
             $SC_Label = "sc_field_7"; 
         }
         $this->clear_tag($SC_Label); 
         if ($this->New_Format)
         {
             $this->xml_registro .= " <" . $SC_Label . ">" . $this->trata_dados($this->sc_field_7) . "</" . $SC_Label . ">\r\n";
         }
         else
         {
             $this->xml_registro .= " " . $SC_Label . " =\"" . $this->trata_dados($this->sc_field_7) . "\"";
         }
   }
   //----- avance
   function NM_export_avance()
   {
              if ($this->New_Format)
              {
                  $_SESSION['sc_session'][$this->Ini->sc_page]['grid_beneficiarios_avance']['embutida']  = true;
                  $_SESSION['sc_session'][$this->Ini->sc_page]['grid_beneficiarios_avance']['xml_label'] = $this->Xml_tag_label;
                  $GLOBALS["script_case_init"] = $this->Ini->sc_page;
                  $GLOBALS["nmgp_parms"] = "nmgp_opcao?#?xml?@?";
                  $detailParameters = array();
                  $detailParameters[] = "gloplanificacion?#?" . str_replace("'", "@aspass@", $this->Orig_pl_idplanificacion);
                  $GLOBALS["nmgp_parms"] .= implode('?@?', $detailParameters) . '?@?';
                  if ($this->Xml_tag_label)
                  {
                      $SC_Label = (isset($this->New_label['avance'])) ? $this->New_label['avance'] : "AVANCE"; 
                  }
                  else
                  {
                      $SC_Label = "avance"; 
                  }
                  $this->clear_tag($SC_Label); 
                  $_SESSION['sc_session'][$this->Ini->sc_page]['grid_beneficiarios_avance']['embutida_tit'] = "avance";
                  $_SESSION['sc_session'][$this->Ini->sc_page]['grid_beneficiarios_avance']['embutida_xml_format'] = $this->New_Format;
                  if (method_exists($this->grid_beneficiarios_avance, "controle"))
                  {
                      $this->grid_beneficiarios_avance->controle();
                      if (isset($_SESSION['scriptcase']['export_return']) && !empty($_SESSION['scriptcase']['export_return']))
                      {
                          if ($this->New_Format)
                          {
                              $this->xml_registro .= " <" . $SC_Label . ">\r\n";
                          }
                          $this->xml_registro .= $_SESSION['scriptcase']['export_return'];
                          if ($this->New_Format)
                          {
                              $this->xml_registro .= " </" . $SC_Label . ">\r\n";
                          }
                      }
                      else
                      {
                          if ($this->New_Format)
                          {
                              $this->xml_registro .= " <" . $SC_Label . ">\r\n";
                              $this->xml_registro .= " </" . $SC_Label . ">\r\n";
                          }
                          else
                          {
                              $this->xml_registro .= " " . $SC_Label . "=\"\"\r\n";
                          }
                      }
                  }
                  else
                  {
                      if ($this->New_Format)
                      {
                          $this->xml_registro .= "<" . $SC_Label . ">\r\n";
                          $this->xml_registro .= " </" . $SC_Label . ">\r\n";
                      }
                      else
                      {
                          $this->xml_registro .= " " . $SC_Label . "=\"\"\r\n";
                      }
                  }
                  $_SESSION['sc_session'][$this->Ini->sc_page]['grid_beneficiarios_avance']['embutida'] = false;
              }
   }
   //----- beneficiarios
   function NM_export_beneficiarios()
   {
         if ($_SESSION['scriptcase']['charset'] == "UTF-8" && !NM_is_utf8($this->beneficiarios))
         {
             $this->beneficiarios = sc_convert_encoding($this->beneficiarios, "UTF-8", $_SESSION['scriptcase']['charset']);
         }
         if ($this->Xml_tag_label)
         {
             $SC_Label = (isset($this->New_label['beneficiarios'])) ? $this->New_label['beneficiarios'] : "VER INGRESOS"; 
         }
         else
         {
             $SC_Label = "beneficiarios"; 
         }
         $this->clear_tag($SC_Label); 
         if ($this->New_Format)
         {
             $this->xml_registro .= " <" . $SC_Label . ">" . $this->trata_dados($this->beneficiarios) . "</" . $SC_Label . ">\r\n";
         }
         else
         {
             $this->xml_registro .= " " . $SC_Label . " =\"" . $this->trata_dados($this->beneficiarios) . "\"";
         }
   }

   //----- 
   function trata_dados($conteudo)
   {
      $str_temp =  $conteudo;
      $str_temp =  str_replace("<br />", "",  $str_temp);
      $str_temp =  str_replace("&", "&amp;",  $str_temp);
      $str_temp =  str_replace("<", "&lt;",   $str_temp);
      $str_temp =  str_replace(">", "&gt;",   $str_temp);
      $str_temp =  str_replace("'", "&apos;", $str_temp);
      $str_temp =  str_replace('"', "&quot;",  $str_temp);
      $str_temp =  str_replace('(', "_",  $str_temp);
      $str_temp =  str_replace(')', "",  $str_temp);
      return ($str_temp);
   }

   function clear_tag(&$conteudo)
   {
      $out = (is_numeric(substr($conteudo, 0, 1)) || substr($conteudo, 0, 1) == "") ? "_" : "";
      $str_temp = "abcdefghijklmnopqrstuvwxyz0123456789";
      for ($i = 0; $i < strlen($conteudo); $i++)
      {
          $char = substr($conteudo, $i, 1);
          $ok = false;
          for ($z = 0; $z < strlen($str_temp); $z++)
          {
              if (strtolower($char) == substr($str_temp, $z, 1))
              {
                  $ok = true;
                  break;
              }
          }
          $out .= ($ok) ? $char : "_";
      }
      $conteudo = $out;
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
      unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['xml_file']);
      if (is_file($this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->Arquivo))
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['xml_file'] = $this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->Arquivo;
      }
      $path_doc_md5 = md5($this->Ini->path_imag_temp . "/" . $this->Arquivo);
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario'][$path_doc_md5][0] = $this->Ini->path_imag_temp . "/" . $this->Arquivo;
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario'][$path_doc_md5][1] = $this->Tit_doc;
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
      unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['xml_file']);
      if (is_file($this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->Arquivo))
      {
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['xml_file'] = $this->Ini->root . $this->Ini->path_imag_temp . "/" . $this->Arquivo;
      }
      $path_doc_md5 = md5($this->Ini->path_imag_temp . "/" . $this->Arquivo);
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario'][$path_doc_md5][0] = $this->Ini->path_imag_temp . "/" . $this->Arquivo;
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario'][$path_doc_md5][1] = $this->Tit_doc;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
            "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML<?php echo $_SESSION['scriptcase']['reg_conf']['html_dir'] ?>>
<HEAD>
 <TITLE><?php echo $this->Ini->Nm_lang['lang_othr_grid_title'] ?> Actividades :: XML</TITLE>
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
   <td class="scExportTitle" style="height: 25px">XML</td>
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
<form name="Fview" method="get" action="<?php echo $this->Ini->path_imag_temp . "/" . $this->Arquivo_view ?>" target="_blank" style="display: none"> 
</form>
<form name="Fdown" method="get" action="grid_jdp_beneficiario_download.php" target="_blank" style="display: none"> 
<input type="hidden" name="script_case_init" value="<?php echo NM_encode_input($this->Ini->sc_page); ?>"> 
<input type="hidden" name="nm_tit_doc" value="grid_jdp_beneficiario"> 
<input type="hidden" name="nm_name_doc" value="<?php echo $path_doc_md5 ?>"> 
</form>
<FORM name="F0" method=post action="./" style="display: none"> 
<INPUT type="hidden" name="script_case_init" value="<?php echo NM_encode_input($this->Ini->sc_page); ?>"> 
<INPUT type="hidden" name="nmgp_opcao" value="<?php echo NM_encode_input($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiario']['xml_return']); ?>"> 
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
