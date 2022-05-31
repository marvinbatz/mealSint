<?php
class grid_jdp_beneficiohogar_detalle_grid
{
   var $Ini;
   var $Erro;
   var $Db;
   var $Tot;
   var $Lin_impressas;
   var $Lin_final;
   var $Rows_span;
   var $nm_grid_slides_linha;
   var $Nm_bloco_aberto;
   var $rs_grid;
   var $nm_grid_ini;
   var $nm_grid_sem_reg;
   var $nm_prim_linha;
   var $Rec_ini;
   var $Rec_fim;
   var $nmgp_reg_start;
   var $nmgp_reg_inicial;
   var $nmgp_reg_final;
   var $SC_seq_register;
   var $SC_seq_page;
   var $nm_location;
   var $nm_data;
   var $nm_cod_barra;
   var $sc_proc_grid; 
   var $NM_raiz_img; 
   var $NM_opcao; 
   var $NM_flag_antigo; 
   var $nm_campos_cab = array();
   var $NM_cmp_hidden   = array();
   var $nmgp_botoes     = array();
   var $nm_btn_exist    = array();
   var $nm_btn_label    = array(); 
   var $nm_btn_disabled = array();
   var $Cmps_ord_def    = array();
   var $nmgp_label_quebras = array();
   var $nmgp_prim_pag_pdf;
   var $Campos_Mens_erro;
   var $Print_All;
   var $NM_field_over;
   var $NM_field_click;
   var $NM_cont_body; 
   var $NM_emb_tree_no; 
   var $progress_fp;
   var $progress_tot;
   var $progress_now;
   var $progress_lim_tot;
   var $progress_lim_now;
   var $progress_lim_qtd;
   var $progress_grid;
   var $progress_pdf;
   var $progress_res;
   var $progress_graf;
   var $count_ger;
   var $mediosdeverificacion;
   var $beneficiarios;
   var $sc_field_0;
   var $pl_codsocio;
   var $ac_nombre;
   var $suba_nombre;
   var $pl_fechainicio;
   var $pl_fechafin;
   var $pl_detalle;
   var $unidad;
   var $sc_field_1;
   var $sc_field_2;
   var $emergencia;
   var $sc_field_3;
   var $indicador;
   var $departamento;
   var $municipio;
   var $comunidad;
   var $pl_colonia;
   var $estado;
   var $sc_field_5;
   var $sc_field_6;
   var $pl_informacioncualitativa;
   var $pl_observacionesadicionales;
   var $sc_field_4;
   var $sc_field_7;
   var $pl_idplanificacion;
   var $grid_beneficiohogar_avance;
//--- 
 function monta_grid($linhas = 0)
 {
   global $script_case_init, $nm_saida;
   $GLOBALS["script_case_init"] = $this->Ini->sc_page;

   clearstatcache();
   $this->NM_cor_embutida();
   if (!is_file($this->Ini->link_grid_beneficiohogar_avance_cons_emb))
   {
       $this->NM_cmp_hidden['avance'] = "off";
   }
   else
   {
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_beneficiohogar_avance']['embutida'] = true;
       $_SESSION['scriptcase']['grid_beneficiohogar_avance']['protect_modal'] = $this->Ini->sc_page;
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_beneficiohogar_avance']['exibe_titulos'] = "S";
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_beneficiohogar_avance']['exibe_total'] = "S";
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_beneficiohogar_avance']['exibe_seq'] = "S";
       include_once ($this->Ini->link_grid_beneficiohogar_avance_cons_emb);
       $this->grid_beneficiohogar_avance = new grid_beneficiohogar_avance_apl ;
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_beneficiohogar_avance']['embutida'] = false;
       unset($_SESSION['scriptcase']['grid_beneficiohogar_avance']['protect_modal']);
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida_init'])
   { 
        return; 
   } 
   $this->inicializa();
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['charts_html'] = '';
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'])
   { 
       $this->Lin_impressas = 0;
       $this->Lin_final     = FALSE;
       $this->grid();
       $this->nm_fim_grid();
   } 
   else 
   { 
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Ind_Groupby'] != "sc_free_total")
      {
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'])
       { 
           include_once($this->Ini->path_embutida . "grid_jdp_beneficiohogar_detalle/" . $this->Ini->Apl_resumo); 
       } 
       else 
       { 
           include_once($this->Ini->path_aplicacao . $this->Ini->Apl_resumo); 
       } 
       $this->Res         = new grid_jdp_beneficiohogar_detalle_resumo();
       $this->Res->Db     = $this->Db;
       $this->Res->Erro   = $this->Erro;
       $this->Res->Ini    = $this->Ini;
       $this->Res->Lookup = $this->Lookup;
      }
       if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['pdf_res'])
       {
            if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf'] || $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf_vert'])
            {
            } 
            else
            {
                $this->cabecalho();
            } 
       } 
            if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf'] || $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf_vert'])
            {
            } 
            else
            {
       $nm_saida->saida("                  <TR>\r\n");
       $nm_saida->saida("                  <TD id='sc_grid_content' style='padding: 0px;' colspan=3>\r\n");
            } 
       $nm_saida->saida("    <table width='100%' cellspacing=0 cellpadding=0>\r\n");
       $nmgrp_apl_opcao= (isset($_SESSION['sc_session']['scriptcase']['embutida_form_pdf']['grid_jdp_beneficiohogar_detalle'])) ? "pdf" : $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'];
       if ($nmgrp_apl_opcao != "pdf")
       { 
           $this->nmgp_barra_top();
       } 
       if ($nmgrp_apl_opcao != "pdf" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != 'print')
       { 
           if ($this->Ini->grid_search_change_fil)
           { 
               $seq_search = 1;
               foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['grid_pesq'] as $cmp => $def)
               {
                  $Seq_grid      = $seq_search;
                  $Cmp_grid      = $cmp;
                  $Def_grid      = array('descr' => $def['descr'], 'hint' => $def['hint']);
                  $Lin_grid_add  = $this->grid_search_tag_ini($Cmp_grid, $Def_grid, $Seq_grid);
                  $NM_func_grid_add = "grid_search_" . $Cmp_grid;
                  $Lin_grid_add .= $this->$NM_func_grid_add($Seq_grid, 'S', $def['opc'], $def['val'], $nmgp_tab_label[$Cmp_grid]);
                  $Lin_grid_add .= $this->grid_search_tag_end();
                  $this->Ini->Arr_result['grid_search_add'][] = array ('field' => $cmp, 'tag' => NM_charset_to_utf8($Lin_grid_add));
                  $seq_search++;
               } 
           } 
           elseif (!$this->Proc_link_res) 
           { 
               $this->html_grid_search();
           } 
       } 
       unset ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['save_grid']);
       if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['pdf_res'] && (!isset($_GET['flash_graf']) || 'chart' != $_GET['flash_graf']))
       {
           $this->grid();
       }
       if ($nmgrp_apl_opcao != "pdf")
       { 
           $this->nmgp_barra_bot();
       } 
       $nm_saida->saida("   </table>\r\n");
       $nm_saida->saida("  </TD>\r\n");
       $nm_saida->saida(" </TR>\r\n");
       if (strpos(" " . $this->Ini->SC_module_export, "resume") !== false)
       { 
           $Gera_res = true;
       } 
       else 
       { 
           $Gera_res = false;
       } 
       if (strpos(" " . $this->Ini->SC_module_export, "chart") !== false)
       { 
           $Gera_graf = true;
       } 
       else 
       { 
           $Gera_graf = false;
       } 
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['print_all'] && empty($this->nm_grid_sem_reg) && ($Gera_res || $Gera_graf) && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Ind_Groupby'] != "sc_free_total")
       { 
           $this->Res->monta_html_ini_pdf();
           $this->Res->monta_resumo();
           $this->Res->monta_html_fim_pdf();
           if ($Gera_graf)
           {
               $this->grafico_pdf();
           }
       } 
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] == "pdf" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Ind_Groupby'] != "sc_free_total")
       { 
           if (isset($_GET['flash_graf']) && 'chart' == $_GET['flash_graf'])
           {
               $this->Res->monta_resumo(true);
               require_once($this->Ini->path_aplicacao . $this->Ini->Apl_grafico); 
               $this->Graf  = new grid_jdp_beneficiohogar_detalle_grafico();
               $this->Graf->Db     = $this->Db;
               $this->Graf->Erro   = $this->Erro;
               $this->Graf->Ini    = $this->Ini;
               $this->Graf->Lookup = $this->Lookup;
               $this->Graf->monta_grafico();
               exit;
           }
           elseif ($Gera_res || $Gera_graf)
           {
               $this->Res->monta_html_ini_pdf();
               $this->Res->monta_resumo();
               $this->Res->monta_html_fim_pdf();
           }
       } 
       $flag_apaga_pdf_log = TRUE;
       if (!$this->Print_All && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] == "pdf")
       { 
           $flag_apaga_pdf_log = FALSE;
       } 
       $this->nm_fim_grid($flag_apaga_pdf_log);
       if (!$this->Print_All && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] == "pdf")
       { 
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] = "igual";
       } 
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] == "print")
   {
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_ant'];
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] = "";
   }
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_ant'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'];
 }
 function resume($linhas = 0)
 {
    $this->Lin_impressas = 0;
    $this->Lin_final     = FALSE;
    $this->grid($linhas);
 }
//--- 
 function inicializa()
 {
   global $nm_saida, $NM_run_iframe,
   $nm_tem_quebra,
   $rec, $nmgp_chave, $nmgp_opcao, $nmgp_ordem, $nmgp_chave_det,
   $nmgp_quant_linhas, $nmgp_quant_colunas, $nmgp_url_saida, $nmgp_parms;
//
   if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['Ind_lig_mult'])) {
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['Ind_lig_mult'] = 0;
   }
   $this->Img_embbed      = false;
   $this->nm_data         = new nm_data("es");
   $this->pdf_label_group = (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_pdf']['label_group'])) ? $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_pdf']['label_group'] : "N";
   $this->pdf_all_cab     = (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_pdf']['all_cab']))     ? $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_pdf']['all_cab'] : "S";
   $this->pdf_all_label   = (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_pdf']['all_label']))   ? $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_pdf']['all_label'] : "S";
   $this->Grid_body = 'id="sc_grid_body"';
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'])
   {
       $this->Grid_body = "";
   }
   $this->Css_Cmp = array();
   $NM_css = file($this->Ini->root . $this->Ini->path_link . "grid_jdp_beneficiohogar_detalle/grid_jdp_beneficiohogar_detalle_grid_" .strtolower($_SESSION['scriptcase']['reg_conf']['css_dir']) . ".css");
   foreach ($NM_css as $cada_css)
   {
       $Pos1 = strpos($cada_css, "{");
       $Pos2 = strpos($cada_css, "}");
       $Tag  = trim(substr($cada_css, 1, $Pos1 - 1));
       $Css  = substr($cada_css, $Pos1 + 1, $Pos2 - $Pos1 - 1);
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['doc_word'])
       { 
           $this->Css_Cmp[$Tag] = $Css;
       }
       else
       { 
           $this->Css_Cmp[$Tag] = "";
       }
   }
   if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['pesq_tab_label']))
   {
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['pesq_tab_label'] = "";
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['pesq_tab_label'] .= "ac_nombre?#?" . "Actividad" . "?@?";
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['pesq_tab_label'] .= "suba_nombre?#?" . "Sub Actividad" . "?@?";
   }
   if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['grid_search_add']))
   {
       $nmgp_tab_label = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['pesq_tab_label'];
       if (!empty($nmgp_tab_label))
       {
          $nm_tab_campos = explode("?@?", $nmgp_tab_label);
          $nmgp_tab_label = array();
          foreach ($nm_tab_campos as $cada_campo)
          {
              $parte_campo = explode("?#?", $cada_campo);
              $nmgp_tab_label[$parte_campo[0]] = $parte_campo[1];
          }
       }
       $Seq_grid      = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['grid_search_add']['seq'];
       $Cmp_grid      = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['grid_search_add']['cmp'];
       $Def_grid      = array('descr' => $nmgp_tab_label[$Cmp_grid], 'hint' => $nmgp_tab_label[$Cmp_grid]);
       $Lin_grid_add  = $this->grid_search_tag_ini($Cmp_grid, $Def_grid, $Seq_grid);
       $NM_func_grid_add = "grid_search_" . $Cmp_grid;
       $Lin_grid_add .= $this->$NM_func_grid_add($Seq_grid, 'S', '', array(), $nmgp_tab_label[$Cmp_grid]);
       $Lin_grid_add .= $this->grid_search_tag_end();
       $this->Arr_result = array();
       $Temp = ob_get_clean();
       if ($Temp !== false && trim($Temp) != "")
       {
           $this->Arr_result['htmOutput'] = NM_charset_to_utf8($Temp);
       }
       $this->Arr_result['grid_add'][] = NM_charset_to_utf8($Lin_grid_add);
       $oJson = new Services_JSON();
       echo $oJson->encode($this->Arr_result);
       unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['grid_search_add']);
       exit;
   }
   if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['dyn_search_aut_comp']))
   {
       $NM_func_aut_comp = "lookup_ajax_" . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['dyn_search_aut_comp']['cmp'];
       $parm = ($_SESSION['scriptcase']['charset'] != "UTF-8" && NM_is_utf8($_GET['q'])) ? sc_convert_encoding($_GET['q'], $_SESSION['scriptcase']['charset'], "UTF-8") : $_GET['q'];
       $nmgp_def_dados = $this->$NM_func_aut_comp($parm);
       ob_end_clean();
       $count_aut_comp = 0;
       $resp_aut_comp  = array();
       foreach ($nmgp_def_dados as $Ind => $Lista)
       {
          if (is_array($Lista))
          {
              foreach ($Lista as $Cod => $Valor)
              {
                  if ($_GET['cod_desc'] == "S")
                  {
                      $Valor = $Cod . " - " . $Valor;
                  }
                  $resp_aut_comp[] = array('label' => $Valor , 'value' => $Cod);
                  $count_aut_comp++;
              }
          }
          if ($count_aut_comp == $_GET['max_itens'])
          {
              break;
          }
       }
       $oJson = new Services_JSON();
       echo $oJson->encode($resp_aut_comp);
       unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['dyn_search_aut_comp']);
       exit;
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'])
   {
       if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['Lig_Md5']))
       {
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['Lig_Md5'] = array();
       }
   }
   elseif ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "pdf" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != 'print')
   {
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['Lig_Md5'] = array();
   }
   $this->force_toolbar = false;
   if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['force_toolbar']))
   { 
       $this->force_toolbar = true;
       unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['force_toolbar']);
   } 
       $this->Tem_tab_vert = false;
   $this->width_tabula_quebra  = "0px";
   $this->width_tabula_display = "none";
   if (isset($_SESSION['scriptcase']['sc_apl_conf']['grid_jdp_beneficiohogar_detalle']['lig_edit']) && $_SESSION['scriptcase']['sc_apl_conf']['grid_jdp_beneficiohogar_detalle']['lig_edit'] != '')
   {
       if ($_SESSION['scriptcase']['sc_apl_conf']['grid_jdp_beneficiohogar_detalle']['lig_edit'] == "on")  {$_SESSION['scriptcase']['sc_apl_conf']['grid_jdp_beneficiohogar_detalle']['lig_edit'] = "S";}
       if ($_SESSION['scriptcase']['sc_apl_conf']['grid_jdp_beneficiohogar_detalle']['lig_edit'] == "off") {$_SESSION['scriptcase']['sc_apl_conf']['grid_jdp_beneficiohogar_detalle']['lig_edit'] = "N";}
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['mostra_edit'] = $_SESSION['scriptcase']['sc_apl_conf']['grid_jdp_beneficiohogar_detalle']['lig_edit'];
   }
   $this->grid_emb_form      = false;
   $this->grid_emb_form_full = false;
   if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida_form']) && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida_form'])
   {
       if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida_form_full']) && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida_form_full'])
       {
          $this->grid_emb_form_full = true;
       }
       else
       {
           $this->grid_emb_form = true;
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['mostra_edit'] = "N";
       }
   }
   if ($this->Ini->SC_Link_View || ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_psq'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['psq_edit'] == 'N'))
   {
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['mostra_edit'] = "N";
   }
   $nm_tem_quebra = 0;
   $this->Nm_bloco_aberto = false;
   $this->NM_cont_body   = 0; 
   $this->NM_emb_tree_no = false; 
   if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'])
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['NM_arr_tree'] = array();
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ind_tree'] = 0;
   }
   elseif (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['emb_tree_no']) && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['emb_tree_no'])
   { 
       $this->NM_emb_tree_no = true; 
   }
   $this->aba_iframe = false;
   $this->Print_All = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['print_all'];
   if ($this->Print_All)
   {
       $this->Ini->nm_limite_lin = $this->Ini->nm_limite_lin_prt; 
   }
   if (isset($_SESSION['scriptcase']['sc_aba_iframe']))
   {
       foreach ($_SESSION['scriptcase']['sc_aba_iframe'] as $aba => $apls_aba)
       {
           if (in_array("grid_jdp_beneficiohogar_detalle", $apls_aba))
           {
               $this->aba_iframe = true;
               break;
           }
       }
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['iframe_menu'] && (!isset($_SESSION['scriptcase']['menu_mobile']) || empty($_SESSION['scriptcase']['menu_mobile'])))
   {
       $this->aba_iframe = true;
   }
   $this->nmgp_botoes['group_2'] = "on";
   $this->nmgp_botoes['group_1'] = "on";
   $this->nmgp_botoes['group_4'] = "on";
   $this->nmgp_botoes['group_3'] = "on";
   $this->nmgp_botoes['exit'] = "on";
   $this->nmgp_botoes['first'] = "on";
   $this->nmgp_botoes['back'] = "on";
   $this->nmgp_botoes['forward'] = "on";
   $this->nmgp_botoes['last'] = "on";
   $this->nmgp_botoes['filter'] = "on";
   $this->nmgp_botoes['pdf'] = "on";
   $this->nmgp_botoes['xls'] = "on";
   $this->nmgp_botoes['xml'] = "on";
   $this->nmgp_botoes['json'] = "on";
   $this->nmgp_botoes['csv'] = "on";
   $this->nmgp_botoes['word'] = "on";
   $this->nmgp_botoes['doc'] = "on";
   $this->nmgp_botoes['export'] = "on";
   $this->nmgp_botoes['print'] = "on";
   $this->nmgp_botoes['html'] = "on";
   $this->nmgp_botoes['goto'] = "on";
   $this->nmgp_botoes['qtline'] = "on";
   $this->nmgp_botoes['navpage'] = "on";
   $this->nmgp_botoes['rows'] = "on";
   $this->nmgp_botoes['summary'] = "on";
   $this->nmgp_botoes['sel_col'] = "on";
   $this->nmgp_botoes['qsearch'] = "on";
   $this->nmgp_botoes['groupby'] = "on";
   $this->nmgp_botoes['gridsave'] = "on";
   $this->nmgp_botoes['gridsavesession'] = "on";
   $this->Cmps_ord_def['ac_nombre'] = " asc";
   $this->Cmps_ord_def['suba_nombre'] = " asc";
   if (isset($_SESSION['scriptcase']['sc_apl_conf']['grid_jdp_beneficiohogar_detalle']['btn_display']) && !empty($_SESSION['scriptcase']['sc_apl_conf']['grid_jdp_beneficiohogar_detalle']['btn_display']))
   {
       foreach ($_SESSION['scriptcase']['sc_apl_conf']['grid_jdp_beneficiohogar_detalle']['btn_display'] as $NM_cada_btn => $NM_cada_opc)
       {
           $this->nmgp_botoes[$NM_cada_btn] = $NM_cada_opc;
       }
   }
   $this->Proc_link_res = false;
   if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['where_resumo']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['where_resumo'])) 
   { 
       $this->Proc_link_res            = true;
       $this->nmgp_botoes['filter']    = 'off';
       $this->nmgp_botoes['groupby']   = 'off';
       $this->nmgp_botoes['dynsearch'] = 'off';
       $this->nmgp_botoes['qsearch']   = 'off';
       $this->nmgp_botoes['gridsave']  = 'off';
       $this->nmgp_botoes['exit']      = 'off';
   } 
   $this->sc_proc_grid = false; 
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['doc_word'] || $this->Ini->sc_export_ajax_img)
   { 
       $this->NM_raiz_img = $this->Ini->root; 
   } 
   else 
   { 
       $this->NM_raiz_img = ""; 
   } 
   $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
   $this->nm_where_dinamico = "";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['where_pesq'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['where_pesq_ant'];  
   if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['campos_busca']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['campos_busca']))
   { 
       $Busca_temp = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['campos_busca'];
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
   $this->nm_field_dinamico = array();
   $this->nm_order_dinamico = array();
   $this->sc_where_orig   = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['where_orig'];
   $this->sc_where_atual  = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['where_pesq'];
   $this->sc_where_filtro = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['where_pesq_filtro'];
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] == "muda_qt_linhas")
   { 
       unset($rec);
   } 
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] == "muda_rec_linhas")
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] = "muda_qt_linhas";
   } 

   if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['dashboard_info']['under_dashboard']) && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['dashboard_info']['under_dashboard'] && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['dashboard_info']['maximized']) {
       $tmpDashboardApp = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['dashboard_info']['dashboard_app'];
       if (isset($_SESSION['scriptcase']['dashboard_toolbar'][$tmpDashboardApp]['grid_jdp_beneficiohogar_detalle'])) {
           $tmpDashboardButtons = $_SESSION['scriptcase']['dashboard_toolbar'][$tmpDashboardApp]['grid_jdp_beneficiohogar_detalle'];

           $this->nmgp_botoes['first']     = $tmpDashboardButtons['grid_navigate']  ? 'on' : 'off';
           $this->nmgp_botoes['back']      = $tmpDashboardButtons['grid_navigate']  ? 'on' : 'off';
           $this->nmgp_botoes['last']      = $tmpDashboardButtons['grid_navigate']  ? 'on' : 'off';
           $this->nmgp_botoes['forward']   = $tmpDashboardButtons['grid_navigate']  ? 'on' : 'off';
           $this->nmgp_botoes['summary']   = $tmpDashboardButtons['grid_summary']   ? 'on' : 'off';
           $this->nmgp_botoes['qsearch']   = $tmpDashboardButtons['grid_qsearch']   ? 'on' : 'off';
           $this->nmgp_botoes['dynsearch'] = $tmpDashboardButtons['grid_dynsearch'] ? 'on' : 'off';
           $this->nmgp_botoes['filter']    = $tmpDashboardButtons['grid_filter']    ? 'on' : 'off';
           $this->nmgp_botoes['sel_col']   = $tmpDashboardButtons['grid_sel_col']   ? 'on' : 'off';
           $this->nmgp_botoes['sort_col']  = $tmpDashboardButtons['grid_sort_col']  ? 'on' : 'off';
           $this->nmgp_botoes['goto']      = $tmpDashboardButtons['grid_goto']      ? 'on' : 'off';
           $this->nmgp_botoes['qtline']    = $tmpDashboardButtons['grid_lineqty']   ? 'on' : 'off';
           $this->nmgp_botoes['navpage']   = $tmpDashboardButtons['grid_navpage']   ? 'on' : 'off';
           $this->nmgp_botoes['pdf']       = $tmpDashboardButtons['grid_pdf']       ? 'on' : 'off';
           $this->nmgp_botoes['xls']       = $tmpDashboardButtons['grid_xls']       ? 'on' : 'off';
           $this->nmgp_botoes['xml']       = $tmpDashboardButtons['grid_xml']       ? 'on' : 'off';
           $this->nmgp_botoes['json']      = $tmpDashboardButtons['grid_json']      ? 'on' : 'off';
           $this->nmgp_botoes['csv']       = $tmpDashboardButtons['grid_csv']       ? 'on' : 'off';
           $this->nmgp_botoes['rtf']       = $tmpDashboardButtons['grid_rtf']       ? 'on' : 'off';
           $this->nmgp_botoes['word']      = $tmpDashboardButtons['grid_word']      ? 'on' : 'off';
           $this->nmgp_botoes['doc']       = $tmpDashboardButtons['grid_doc']       ? 'on' : 'off';
           $this->nmgp_botoes['print']     = $tmpDashboardButtons['grid_print']     ? 'on' : 'off';
           $this->nmgp_botoes['new']       = $tmpDashboardButtons['grid_new']       ? 'on' : 'off';
           $this->nmgp_botoes['img']       = $tmpDashboardButtons['img']            ? 'on' : 'off';
           $this->nmgp_botoes['html']      = $tmpDashboardButtons['html']           ? 'on' : 'off';
           $this->nmgp_botoes['reload']    = $tmpDashboardButtons['grid_reload']    ? 'on' : 'off';
       }
   }

   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'])
   {
       $nmgp_ordem = ""; 
       $rec = "ini"; 
   } 
//
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'])
   { 
       include_once($this->Ini->path_embutida . "grid_jdp_beneficiohogar_detalle/grid_jdp_beneficiohogar_detalle_total.class.php"); 
   } 
   else 
   { 
       include_once($this->Ini->path_aplicacao . "grid_jdp_beneficiohogar_detalle_total.class.php"); 
   } 
   $dir_raiz          = strrpos($_SERVER['PHP_SELF'],"/") ;  
   $dir_raiz          = substr($_SERVER['PHP_SELF'], 0, $dir_raiz + 1) ;  
   $this->nm_location = $this->Ini->sc_protocolo . $this->Ini->server . $dir_raiz; 
   if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'])
   { 
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "pdf" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida_pdf'] != "pdf")  
       { 
           $_SESSION['scriptcase']['contr_link_emb'] = $this->nm_location;
       } 
       else 
       { 
           $_SESSION['scriptcase']['contr_link_emb'] = "pdf";
       } 
   } 
   else 
   { 
       $this->nm_location = $_SESSION['scriptcase']['contr_link_emb'];
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida_pdf'] = $_SESSION['scriptcase']['contr_link_emb'];
   } 
   $this->Tot         = new grid_jdp_beneficiohogar_detalle_total($this->Ini->sc_page);
   $this->Tot->Db     = $this->Db;
   $this->Tot->Erro   = $this->Erro;
   $this->Tot->Ini    = $this->Ini;
   $this->Tot->Lookup = $this->Lookup;
   if (empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_lin_grid']))
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_lin_grid'] = 1;
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_col_grid'] = 1 ;  
   }   
   if (isset($_SESSION['scriptcase']['sc_apl_conf']['grid_jdp_beneficiohogar_detalle']['rows']) && !empty($_SESSION['scriptcase']['sc_apl_conf']['grid_jdp_beneficiohogar_detalle']['rows']))
   {
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_lin_grid'] = $_SESSION['scriptcase']['sc_apl_conf']['grid_jdp_beneficiohogar_detalle']['rows'];  
       unset($_SESSION['scriptcase']['sc_apl_conf']['grid_jdp_beneficiohogar_detalle']['rows']);
   }
   if (isset($_SESSION['scriptcase']['sc_apl_conf']['grid_jdp_beneficiohogar_detalle']['cols']) && !empty($_SESSION['scriptcase']['sc_apl_conf']['grid_jdp_beneficiohogar_detalle']['cols']))
   {
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_col_grid'] = $_SESSION['scriptcase']['sc_apl_conf']['grid_jdp_beneficiohogar_detalle']['cols'];  
       unset($_SESSION['scriptcase']['sc_apl_conf']['grid_jdp_beneficiohogar_detalle']['cols']);
   }
   if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_liga']['rows']))
   {
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_lin_grid'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_liga']['rows'];  
   }
   if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_liga']['cols']))
   {
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_col_grid'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_liga']['cols'];  
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] == "muda_qt_linhas") 
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao']  = "igual" ;  
       if (!empty($nmgp_quant_linhas) && !is_array($nmgp_quant_linhas)) 
       { 
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_lin_grid'] = $nmgp_quant_linhas ;  
       } 
       if (!empty($nmgp_quant_colunas)) 
       { 
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_col_grid'] = $nmgp_quant_colunas ;  
       } 
   }   
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_reg_grid'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_lin_grid'] * $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_col_grid']; 
   $this->nm_grid_slides_linha = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_col_grid'];
   $this->Ini->nm_limite_lin = $this->Ini->nm_limite_lin * $this->nm_grid_slides_linha; 
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Ind_Groupby'] == "sc_free_total") 
   {
       if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_select']))  
       { 
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_select'] = array(); 
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_select']['pl.idPlanificacion'] = 'desc'; 
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_select_orig'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_select']; 
       } 
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Ind_Groupby'] == "sc_free_total") 
   {
       if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_quebra']))  
       { 
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_quebra'] = array(); 
       } 
   }
   if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_grid']))  
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_grid'] = "" ; 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_ant']  = ""; 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_desc'] = ""; 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_cmp']  = ""; 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_label'] = "";  
   }   
   if (!empty($nmgp_ordem))  
   { 
       $nmgp_ordem = str_replace('\"', '"', $nmgp_ordem); 
       if (!isset($this->Cmps_ord_def[$nmgp_ordem])) 
       { 
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] = "igual" ;  
       }
       else
       { 
           $Ordem_tem_quebra = false;
           foreach($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_quebra'] as $campo => $resto) 
           {
               foreach($resto as $sqldef => $ordem) 
               {
                   if ($sqldef == $nmgp_ordem) 
                   { 
                       $Ordem_tem_quebra = true;
                       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] = "inicio" ;  
                       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_grid'] = ""; 
                       $ordem = ($ordem == "asc") ? "desc" : "asc";
                       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_quebra'][$campo][$nmgp_ordem] = $ordem;
                       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_cmp'] = $nmgp_ordem;
                       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_label'] = trim($ordem);
                   }   
               }   
           }   
           if (!$Ordem_tem_quebra)
           {
               $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_grid'] = $nmgp_ordem  ; 
           }
       }
   }   
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] == "ordem")  
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] = "inicio" ;  
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_ant'] == $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_grid'])  
       { 
           if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_desc'] != " desc")  
           { 
               $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_desc'] = " desc" ; 
           } 
           else   
           { 
               $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_desc'] = " asc" ;  
           } 
       } 
       else 
       { 
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_desc'] = $this->Cmps_ord_def[$nmgp_ordem];  
       } 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_label'] = trim($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_desc']);  
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_ant'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_grid'];  
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_cmp'] = $nmgp_ordem;  
   }  
   if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['inicio']))  
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['inicio'] = 0 ;  
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['final']  = 0 ;  
   }   
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_edit'])  
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_edit'] = false;  
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "inicio") 
       { 
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] = "edit" ; 
       } 
   }   
   if (!empty($nmgp_parms) && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "pdf")   
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] = "igual";
       $rec = "ini";
   }
   if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['where_orig']) || $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['prim_cons'] || !empty($nmgp_parms))  
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['prim_cons'] = false;  
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['where_orig'] = " where pl.idPlanificacion=" . $_SESSION['gloPlanificacion'] . " AND pl.idtipoBeneficiario=2";  
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['where_pesq']        = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['where_orig'];  
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['where_pesq_ant']    = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['where_orig'];  
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['cond_pesq']         = ""; 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['where_pesq_filtro'] = "";
   }   
   if  (!empty($this->nm_where_dinamico)) 
   {   
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['where_pesq'] .= $this->nm_where_dinamico;
   }   
   $this->sc_where_orig   = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['where_orig'];
   $this->sc_where_atual  = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['where_pesq'];
   $this->sc_where_filtro = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['where_pesq_filtro'];
   $this->sc_where_atual_f = (!empty($this->sc_where_atual)) ? "(" . trim(substr($this->sc_where_atual, 6)) . ")" : "";
   $this->sc_where_atual_f = str_replace("%", "@percent@", $this->sc_where_atual_f);
   $this->sc_where_atual_f = "NM_where_filter*scin" . str_replace("'", "@aspass@", $this->sc_where_atual_f) . "*scout";
//
//--------- 
//
   $nmgp_opc_orig = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao']; 
   if (isset($rec)) 
   { 
       if ($rec == "ini") 
       { 
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] = "inicio" ; 
       } 
       elseif ($rec == "fim") 
       { 
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] = "final" ; 
       } 
       else 
       { 
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] = "avanca" ; 
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['final'] = $rec; 
           if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['final'] > 0) 
           { 
               $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['final']-- ; 
           } 
       } 
   } 
   $this->NM_opcao = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao']; 
   if ($this->NM_opcao == "print") 
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] = "print" ; 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao']       = "igual" ; 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_beneficiohogar_avance']['opcao_print'] = "print" ; 
       if ($this->Ini->sc_export_ajax) 
       { 
           $this->Img_embbed = true;
       } 
   } 
// 
   $this->count_ger = 0;
   if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['tot_geral'][1])) 
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['sc_total'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['tot_geral'][1] ;  
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] == "final" || $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_reg_grid'] == "all") 
   { 
       $Gb_geral = "quebra_geral_" . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Ind_Groupby'];
       $this->Tot->$Gb_geral();
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['sc_total'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['tot_geral'][1] ;  
       $this->count_ger = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['tot_geral'][1];
   } 
   if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['where_dinamic']) && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['where_dinamic'] != $this->nm_where_dinamico)  
   { 
       unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['tot_geral']);
   } 
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['where_dinamic'] = $this->nm_where_dinamico;  
   if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['tot_geral']) || $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['where_pesq'] != $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['where_pesq_ant'] || $nmgp_opc_orig == "edit") 
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['contr_total_geral'] = "NAO";
       unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['sc_total']);
       $Gb_geral = "quebra_geral_" . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Ind_Groupby'];
       $this->Tot->$Gb_geral();
       if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['contr_array_resumo']))  
       { 
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['contr_array_resumo'] = "NAO";
       } 
   } 
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['sc_total'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['tot_geral'][1] ;  
   $this->count_ger = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['tot_geral'][1];
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_reg_grid'] == "all") 
   { 
        $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_reg_grid'] = $this->count_ger;
        $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao']       = "inicio";
   } 
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] == "inicio" || $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] == "pesq") 
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['inicio'] = 0 ; 
   } 
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] == "final") 
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['inicio'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['sc_total'] - $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_reg_grid']; 
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['inicio'] < 0) 
       { 
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['inicio'] = 0 ; 
       } 
   } 
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] == "retorna") 
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['inicio'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['inicio'] - $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_reg_grid']; 
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['inicio'] < 0) 
       { 
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['inicio'] = 0 ; 
       } 
   } 
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] == "avanca" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['sc_total'] >  $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['final']) 
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['inicio'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['final']; 
   } 
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != "print" && substr($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'], 0, 7) != "detalhe" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "pdf") 
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] = "igual"; 
   } 
   $this->Rec_ini = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['inicio'] - $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_reg_grid']; 
   if ($this->Rec_ini < 0) 
   { 
       $this->Rec_ini = 0; 
   } 
   $this->Rec_fim = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['inicio'] + $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_reg_grid'] + 1; 
   if ($this->Rec_fim > $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['sc_total']) 
   { 
       $this->Rec_fim = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['sc_total']; 
   } 
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['inicio'] > 0) 
   { 
       $this->Rec_ini++ ; 
   } 
   $this->nmgp_reg_start = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['inicio']; 
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['inicio'] > 0) 
   { 
       $this->nmgp_reg_start--; 
   } 
   $this->nm_grid_ini = $this->nmgp_reg_start + 1; 
   if ($this->nmgp_reg_start != 0) 
   { 
       $this->nm_grid_ini++;
   }  
//----- 
   if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mysql))
   { 
       $nmgp_select = "SELECT p.codigoP as sc_field_0, pl.codSocio as pl_codsocio, ac.nombre as ac_nombre, suba.nombre as suba_nombre, pl.fechaInicio as pl_fechainicio, pl.fechaFin as pl_fechafin, pl.detalle as pl_detalle, un.nombre as unidad, fdE.nombre as sc_field_1, tdE.nombre as sc_field_2, em.nombre as emergencia, tB.nombre as sc_field_3, pM.codigo as indicador, de.nombre as departamento, mu.nombre as municipio, co.nombre as comunidad, pl.colonia as pl_colonia, es.nombre as estado, pl.fechaInicioPlan as sc_field_5, pl.fechaFinPlan as sc_field_6, pl.informacionCualitativa as pl_informacioncualitativa, pl.observacionesAdicionales as pl_observacionesadicionales, pl.beneficiariosIndirectos as sc_field_4, pl.valorApr as sc_field_7, pl.idPlanificacion as pl_idplanificacion from " . $this->Ini->nm_tabela; 
   } 
   else 
   { 
       $nmgp_select = "SELECT p.codigoP as sc_field_0, pl.codSocio as pl_codsocio, ac.nombre as ac_nombre, suba.nombre as suba_nombre, pl.fechaInicio as pl_fechainicio, pl.fechaFin as pl_fechafin, pl.detalle as pl_detalle, un.nombre as unidad, fdE.nombre as sc_field_1, tdE.nombre as sc_field_2, em.nombre as emergencia, tB.nombre as sc_field_3, pM.codigo as indicador, de.nombre as departamento, mu.nombre as municipio, co.nombre as comunidad, pl.colonia as pl_colonia, es.nombre as estado, pl.fechaInicioPlan as sc_field_5, pl.fechaFinPlan as sc_field_6, pl.informacionCualitativa as pl_informacioncualitativa, pl.observacionesAdicionales as pl_observacionesadicionales, pl.beneficiariosIndirectos as sc_field_4, pl.valorApr as sc_field_7, pl.idPlanificacion as pl_idplanificacion from " . $this->Ini->nm_tabela; 
   } 
   $nmgp_select .= " " . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['where_pesq']; 
   $nmgp_select .= " group by pl.idPlanificacion"; 
   $nmgp_order_by = ""; 
   $campos_order_select = "";
   foreach($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_select'] as $campo => $ordem) 
   {
        if ($campo != $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_grid']) 
        {
           if (!empty($campos_order_select)) 
           {
               $campos_order_select .= ", ";
           }
           $campos_order_select .= $campo . " " . $ordem;
        }
   }
   $campos_order = "";
   foreach($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_quebra'] as $campo => $resto) 
   {
       foreach($resto as $sqldef => $ordem) 
       {
           $format       = $this->Ini->Get_Gb_date_format($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Ind_Groupby'], $campo);
           $campos_order = $this->Ini->Get_date_order_groupby($sqldef, $ordem, $format, $campos_order);
       }
   }
   if (!empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_grid'])) 
   { 
       if (!empty($campos_order)) 
       { 
           $campos_order .= ", ";
       } 
       $nmgp_order_by = " order by " . $campos_order . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_grid'] . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_desc']; 
   } 
   elseif (!empty($campos_order_select)) 
   { 
       if (!empty($campos_order)) 
       { 
           $campos_order .= ", ";
       } 
       $nmgp_order_by = " order by " . $campos_order . $campos_order_select; 
   } 
   elseif (!empty($campos_order)) 
   { 
       $nmgp_order_by = " order by " . $campos_order; 
   } 
   if (substr(trim($nmgp_order_by), -1) == ",")
   {
       $nmgp_order_by = " " . substr(trim($nmgp_order_by), 0, -1);
   }
   if (trim($nmgp_order_by) == "order by")
   {
       $nmgp_order_by = "";
   }
   $nmgp_select .= $nmgp_order_by; 
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['order_grid'] = $nmgp_order_by;
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] || $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] == "pdf" || $this->Ini->Apl_paginacao == "FULL")
   {
       $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nmgp_select; 
       $this->rs_grid = $this->Db->Execute($nmgp_select) ; 
   }
   else  
   {
       $_SESSION['scriptcase']['sc_sql_ult_comando'] = "SelectLimit($nmgp_select, " . ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_reg_grid'] + 2) . ", $this->nmgp_reg_start)" ; 
       $this->rs_grid = $this->Db->SelectLimit($nmgp_select, $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_reg_grid'] + 2, $this->nmgp_reg_start) ; 
   }  
   if ($this->rs_grid === false && !$this->rs_grid->EOF && $GLOBALS["NM_ERRO_IBASE"] != 1) 
   { 
       $this->Erro->mensagem(__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg()); 
       exit ; 
   }  
   if ($this->rs_grid->EOF || ($this->rs_grid === false && $GLOBALS["NM_ERRO_IBASE"] == 1)) 
   { 
       $this->force_toolbar = true;
       $this->nm_grid_sem_reg = $this->Ini->Nm_lang['lang_errm_empt']; 
   }  
   else 
   { 
       $this->sc_field_0 = $this->rs_grid->fields[0] ;  
       $this->pl_codsocio = $this->rs_grid->fields[1] ;  
       $this->ac_nombre = $this->rs_grid->fields[2] ;  
       $this->suba_nombre = $this->rs_grid->fields[3] ;  
       $this->pl_fechainicio = $this->rs_grid->fields[4] ;  
       $this->pl_fechafin = $this->rs_grid->fields[5] ;  
       $this->pl_detalle = $this->rs_grid->fields[6] ;  
       $this->unidad = $this->rs_grid->fields[7] ;  
       $this->sc_field_1 = $this->rs_grid->fields[8] ;  
       $this->sc_field_2 = $this->rs_grid->fields[9] ;  
       $this->emergencia = $this->rs_grid->fields[10] ;  
       $this->sc_field_3 = $this->rs_grid->fields[11] ;  
       $this->indicador = $this->rs_grid->fields[12] ;  
       $this->departamento = $this->rs_grid->fields[13] ;  
       $this->municipio = $this->rs_grid->fields[14] ;  
       $this->comunidad = $this->rs_grid->fields[15] ;  
       $this->pl_colonia = $this->rs_grid->fields[16] ;  
       $this->estado = $this->rs_grid->fields[17] ;  
       $this->sc_field_5 = $this->rs_grid->fields[18] ;  
       $this->sc_field_6 = $this->rs_grid->fields[19] ;  
       $this->pl_informacioncualitativa = $this->rs_grid->fields[20] ;  
       $this->pl_observacionesadicionales = $this->rs_grid->fields[21] ;  
       $this->sc_field_4 = $this->rs_grid->fields[22] ;  
       $this->sc_field_4 = (string)$this->sc_field_4;
       $this->sc_field_7 = $this->rs_grid->fields[23] ;  
       $this->sc_field_7 = (string)$this->sc_field_7;
       $this->pl_idplanificacion = $this->rs_grid->fields[24] ;  
       $this->pl_idplanificacion = (string)$this->pl_idplanificacion;
       $this->SC_seq_register = $this->nmgp_reg_start ; 
       $this->SC_seq_page = 0;
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['final'] = $this->nmgp_reg_start ; 
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['inicio'] != 0 && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "pdf") 
       { 
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['final']++ ; 
           $this->SC_seq_register = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['final']; 
           $this->rs_grid->MoveNext(); 
           $this->sc_field_0 = $this->rs_grid->fields[0] ;  
           $this->pl_codsocio = $this->rs_grid->fields[1] ;  
           $this->ac_nombre = $this->rs_grid->fields[2] ;  
           $this->suba_nombre = $this->rs_grid->fields[3] ;  
           $this->pl_fechainicio = $this->rs_grid->fields[4] ;  
           $this->pl_fechafin = $this->rs_grid->fields[5] ;  
           $this->pl_detalle = $this->rs_grid->fields[6] ;  
           $this->unidad = $this->rs_grid->fields[7] ;  
           $this->sc_field_1 = $this->rs_grid->fields[8] ;  
           $this->sc_field_2 = $this->rs_grid->fields[9] ;  
           $this->emergencia = $this->rs_grid->fields[10] ;  
           $this->sc_field_3 = $this->rs_grid->fields[11] ;  
           $this->indicador = $this->rs_grid->fields[12] ;  
           $this->departamento = $this->rs_grid->fields[13] ;  
           $this->municipio = $this->rs_grid->fields[14] ;  
           $this->comunidad = $this->rs_grid->fields[15] ;  
           $this->pl_colonia = $this->rs_grid->fields[16] ;  
           $this->estado = $this->rs_grid->fields[17] ;  
           $this->sc_field_5 = $this->rs_grid->fields[18] ;  
           $this->sc_field_6 = $this->rs_grid->fields[19] ;  
           $this->pl_informacioncualitativa = $this->rs_grid->fields[20] ;  
           $this->pl_observacionesadicionales = $this->rs_grid->fields[21] ;  
           $this->sc_field_4 = $this->rs_grid->fields[22] ;  
           $this->sc_field_7 = $this->rs_grid->fields[23] ;  
           $this->pl_idplanificacion = $this->rs_grid->fields[24] ;  
       } 
   } 
   $this->nmgp_reg_inicial = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['final'] + 1;
   $this->nmgp_reg_final   = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['final'] + $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_reg_grid'];
   $this->nmgp_reg_final   = ($this->nmgp_reg_final > $this->count_ger) ? $this->count_ger : $this->nmgp_reg_final;
// 
   if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'])
   { 
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['doc_word'] && !$this->Ini->sc_export_ajax)
       {
           require_once($this->Ini->path_lib_php . "/sc_progress_bar.php");
           $this->pb = new scProgressBar();
           $this->pb->setRoot($this->Ini->root);
           $this->pb->setDir($_SESSION['scriptcase']['grid_jdp_beneficiohogar_detalle']['glo_nm_path_imag_temp'] . "/");
           $this->pb->setProgressbarMd5($_GET['pbmd5']);
           $this->pb->initialize();
           $this->pb->setReturnUrl("./");
           $this->pb->setReturnOption($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['word_return']);
           $this->pb->setTotalSteps($this->count_ger);
       }
       if ($this->Ini->Proc_print && $this->Ini->Export_html_zip  && !$this->Ini->sc_export_ajax)
       {
           require_once($this->Ini->path_lib_php . "/sc_progress_bar.php");
           $this->pb = new scProgressBar();
           $this->pb->setRoot($this->Ini->root);
           $this->pb->setDir($_SESSION['scriptcase']['grid_jdp_beneficiohogar_detalle']['glo_nm_path_imag_temp'] . "/");
           $this->pb->setProgressbarMd5($_GET['pbmd5']);
           $this->pb->initialize();
           $this->pb->setReturnUrl("./");
           $this->pb->setReturnOption($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['print_return']);
           $this->pb->setTotalSteps($this->count_ger);
       }
       if (!$this->Ini->sc_export_ajax && !$this->Print_All && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] == "pdf" && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['pdf_res'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida_pdf'] != "pdf")
       {
           //---------- Gauge ----------
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
            "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML<?php echo $_SESSION['scriptcase']['reg_conf']['html_dir'] ?>>
<HEAD>
 <TITLE><?php echo $this->Ini->Nm_lang['lang_othr_grid_title'] ?> Actividades :: PDF</TITLE>
 <META http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
           if ($_SESSION['scriptcase']['proc_mobile'])
           {
?>
                    <meta name="viewport" content="minimal-ui, width=300, initial-scale=1, maximum-scale=1, user-scalable=no">
                    <meta name="mobile-web-app-capable" content="yes">
                    <meta name="apple-mobile-web-app-capable" content="yes">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <link rel="apple-touch-icon"   sizes="57x57" href="">
                    <link rel="apple-touch-icon"   sizes="60x60" href="">
                    <link rel="apple-touch-icon"   sizes="72x72" href="">
                    <link rel="apple-touch-icon"   sizes="76x76" href="">
                    <link rel="apple-touch-icon" sizes="114x114" href="">
                    <link rel="apple-touch-icon" sizes="120x120" href="">
                    <link rel="apple-touch-icon" sizes="144x144" href="">
                    <link rel="apple-touch-icon" sizes="152x152" href="">
                    <link rel="apple-touch-icon" sizes="180x180" href="">
                    <link rel="icon" type="image/png" sizes="192x192" href="">
                    <link rel="icon" type="image/png"   sizes="32x32" href="">
                    <link rel="icon" type="image/png"   sizes="96x96" href="">
                    <link rel="icon" type="image/png"   sizes="16x16" href="">
                    <meta name="msapplication-TileColor" content="#727cf5">
                    <meta name="msapplication-TileImage" content="">
                    <meta name="theme-color" content="#727cf5">
                    <meta name="apple-mobile-web-app-status-bar-style" content="#727cf5">
                    <link rel="shortcut icon" href=""><?php
           }
?>
 <META http-equiv="Expires" content="Fri, Jan 01 1900 00:00:00 GMT">
 <META http-equiv="Last-Modified" content="<?php echo gmdate("D, d M Y H:i:s"); ?>" GMT">
 <META http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
 <META http-equiv="Cache-Control" content="post-check=0, pre-check=0">
 <META http-equiv="Pragma" content="no-cache">
 <link rel="shortcut icon" href="../_lib/img/scriptcase__NM__ico__NM__favicon.ico">
 <link rel="stylesheet" type="text/css" href="../_lib/css/<?php echo $this->Ini->str_schema_all ?>_grid.css" /> 
 <link rel="stylesheet" type="text/css" href="../_lib/css/<?php echo $this->Ini->str_schema_all ?>_grid<?php echo $_SESSION['scriptcase']['reg_conf']['css_dir'] ?>.css" /> 
 <?php 
 if(isset($this->Ini->str_google_fonts) && !empty($this->Ini->str_google_fonts)) 
 { 
 ?> 
 <link href="<?php echo $this->Ini->str_google_fonts ?>" rel="stylesheet" /> 
 <?php 
 } 
 ?> 
 <link rel="stylesheet" type="text/css" href="../_lib/buttons/<?php echo $this->Ini->Str_btn_css ?>" /> 
 <SCRIPT LANGUAGE="Javascript" SRC="<?php echo $this->Ini->path_js; ?>/nm_gauge.js"></SCRIPT>
</HEAD>
<BODY scrolling="no">
<table class="scGridTabela" style="padding: 0px; border-spacing: 0px; border-width: 0px; vertical-align: top;"><tr class="scGridFieldOddVert"><td>
<?php echo $this->Ini->Nm_lang['lang_pdff_gnrt']; ?>...<br>
<?php
           $this->progress_grid    = $this->rs_grid->RecordCount();
           $this->progress_pdf     = 0;
           $this->progress_res     = isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['pivot_charts']) ? sizeof($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['pivot_charts']) : 0;
           $this->progress_graf    = 0;
           $this->progress_tot     = 0;
           $this->progress_now     = 0;
           $this->progress_lim_tot = 0;
           $this->progress_lim_now = 0;
           if (-1 < $this->progress_grid)
           {
               $this->progress_lim_qtd = (250 < $this->progress_grid) ? 250 : $this->progress_grid;
               $this->progress_lim_tot = floor($this->progress_grid / $this->progress_lim_qtd);
               $this->progress_pdf     = floor($this->progress_grid * 0.25) + 1;
               $this->progress_tot     = $this->progress_grid + $this->progress_pdf + $this->progress_res + $this->progress_graf;
               $str_pbfile             = $this->Ini->root . $this->Ini->path_imag_temp . '/sc_pb_' . session_id() . '.tmp';
               $this->progress_fp      = fopen($str_pbfile, 'w');
               grid_jdp_beneficiohogar_detalle_pdf_progress_call("PDF\n", $this->Ini->Nm_lang);
               grid_jdp_beneficiohogar_detalle_pdf_progress_call($this->Ini->path_js   . "\n", $this->Ini->Nm_lang);
               grid_jdp_beneficiohogar_detalle_pdf_progress_call($this->Ini->path_prod . "/img/\n", $this->Ini->Nm_lang);
               grid_jdp_beneficiohogar_detalle_pdf_progress_call($this->progress_tot   . "\n", $this->Ini->Nm_lang);
               fwrite($this->progress_fp, "PDF\n");
               fwrite($this->progress_fp, $this->Ini->path_js   . "\n");
               fwrite($this->progress_fp, $this->Ini->path_prod . "/img/\n");
               fwrite($this->progress_fp, $this->progress_tot   . "\n");
               $lang_protect = $this->Ini->Nm_lang['lang_pdff_strt'];
               if (!NM_is_utf8($lang_protect))
               {
                   $lang_protect = sc_convert_encoding($lang_protect, "UTF-8", $_SESSION['scriptcase']['charset']);
               }
               grid_jdp_beneficiohogar_detalle_pdf_progress_call($this->progress_tot . "_#NM#_" . "1_#NM#_" . $lang_protect . "...\n", $this->Ini->Nm_lang);
               fwrite($this->progress_fp, "1_#NM#_" . $lang_protect . "...\n");
               flush();
           }
       }
       $nm_fundo_pagina = ""; 
       header("X-XSS-Protection: 1; mode=block");
       header("X-Frame-Options: SAMEORIGIN");
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['doc_word'])
       {
           $nm_saida->saida("  <html xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:o=\"urn:schemas-microsoft-com:office:office\" xmlns:w=\"urn:schemas-microsoft-com:office:word\" xmlns:m=\"http://schemas.microsoft.com/office/2004/12/omml\" xmlns=\"http://www.w3.org/TR/REC-html40\">\r\n");
       }
       $nm_saida->saida("<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\"\r\n");
       $nm_saida->saida("            \"http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd\">\r\n");
       $nm_saida->saida("  <HTML" . $_SESSION['scriptcase']['reg_conf']['html_dir'] . ">\r\n");
       $nm_saida->saida("  <HEAD>\r\n");
       $nm_saida->saida("   <TITLE>" . $this->Ini->Nm_lang['lang_othr_grid_title'] . " Actividades</TITLE>\r\n");
       $nm_saida->saida("   <META http-equiv=\"Content-Type\" content=\"text/html; charset=" . $_SESSION['scriptcase']['charset_html'] . "\" />\r\n");
       if ($_SESSION['scriptcase']['proc_mobile'])
       {
$nm_saida->saida("                        <meta name=\"viewport\" content=\"minimal-ui, width=300, initial-scale=1, maximum-scale=1, user-scalable=no\">\r\n");
$nm_saida->saida("                        <meta name=\"mobile-web-app-capable\" content=\"yes\">\r\n");
$nm_saida->saida("                        <meta name=\"apple-mobile-web-app-capable\" content=\"yes\">\r\n");
$nm_saida->saida("                        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\r\n");
$nm_saida->saida("                        <link rel=\"apple-touch-icon\" sizes=\"57x57\" href=\"\">\r\n");
$nm_saida->saida("                        <link rel=\"apple-touch-icon\" sizes=\"60x60\" href=\"\">\r\n");
$nm_saida->saida("                        <link rel=\"apple-touch-icon\" sizes=\"72x72\" href=\"\">\r\n");
$nm_saida->saida("                        <link rel=\"apple-touch-icon\" sizes=\"76x76\" href=\"\">\r\n");
$nm_saida->saida("                        <link rel=\"apple-touch-icon\" sizes=\"114x114\" href=\"\">\r\n");
$nm_saida->saida("                        <link rel=\"apple-touch-icon\" sizes=\"120x120\" href=\"\">\r\n");
$nm_saida->saida("                        <link rel=\"apple-touch-icon\" sizes=\"144x144\" href=\"\">\r\n");
$nm_saida->saida("                        <link rel=\"apple-touch-icon\" sizes=\"152x152\" href=\"\">\r\n");
$nm_saida->saida("                        <link rel=\"apple-touch-icon\" sizes=\"180x180\" href=\"\">\r\n");
$nm_saida->saida("                        <link rel=\"icon\" type=\"image/png\" sizes=\"192x192\"  href=\"\">\r\n");
$nm_saida->saida("                        <link rel=\"icon\" type=\"image/png\" sizes=\"32x32\" href=\"\">\r\n");
$nm_saida->saida("                        <link rel=\"icon\" type=\"image/png\" sizes=\"96x96\" href=\"\">\r\n");
$nm_saida->saida("                        <link rel=\"icon\" type=\"image/png\" sizes=\"16x16\" href=\"\">\r\n");
$nm_saida->saida("                        <meta name=\"msapplication-TileColor\" content=\"#727cf5\" >\r\n");
$nm_saida->saida("                        <meta name=\"msapplication-TileImage\" content=\"\">\r\n");
$nm_saida->saida("                        <meta name=\"theme-color\" content=\"#727cf5\">\r\n");
$nm_saida->saida("                        <meta name=\"apple-mobile-web-app-status-bar-style\" content=\"#727cf5\">\r\n");
$nm_saida->saida("                        <link rel=\"shortcut icon\" href=\"\">\r\n");
       }
       if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['doc_word'])
       {
           $nm_saida->saida("   <META http-equiv=\"Expires\" content=\"Fri, Jan 01 1900 00:00:00 GMT\"/>\r\n");
           $nm_saida->saida("   <META http-equiv=\"Last-Modified\" content=\"" . gmdate('D, d M Y H:i:s') . " GMT\"/>\r\n");
           $nm_saida->saida("   <META http-equiv=\"Cache-Control\" content=\"no-store, no-cache, must-revalidate\"/>\r\n");
           $nm_saida->saida("   <META http-equiv=\"Cache-Control\" content=\"post-check=0, pre-check=0\"/>\r\n");
           $nm_saida->saida("   <META http-equiv=\"Pragma\" content=\"no-cache\"/>\r\n");
       }
       $nm_saida->saida("   <link rel=\"shortcut icon\" href=\"../_lib/img/scriptcase__NM__ico__NM__favicon.ico\">\r\n");
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "pdf" && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'])
       { 
           $css_body = "";
       } 
       else 
       { 
           $css_body = "margin-left:0px;margin-right:0px;margin-top:0px;margin-bottom:0px;";
       } 
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "pdf" && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'] && !$this->Ini->sc_export_ajax)
       { 
           $nm_saida->saida("   <form name=\"form_ajax_redir_1\" method=\"post\" style=\"display: none\">\r\n");
           $nm_saida->saida("    <input type=\"hidden\" name=\"nmgp_parms\">\r\n");
           $nm_saida->saida("    <input type=\"hidden\" name=\"nmgp_outra_jan\">\r\n");
           $nm_saida->saida("   </form>\r\n");
           $nm_saida->saida("   <form name=\"form_ajax_redir_2\" method=\"post\" style=\"display: none\"> \r\n");
           $nm_saida->saida("    <input type=\"hidden\" name=\"nmgp_parms\">\r\n");
           $nm_saida->saida("    <input type=\"hidden\" name=\"nmgp_url_saida\">\r\n");
           $nm_saida->saida("    <input type=\"hidden\" name=\"script_case_init\">\r\n");
           $nm_saida->saida("   </form>\r\n");
           $confirmButtonClass = '';
           $cancelButtonClass  = '';
           $confirmButtonText  = $this->Ini->Nm_lang['lang_btns_cfrm'];
           $cancelButtonText   = $this->Ini->Nm_lang['lang_btns_cncl'];
           $confirmButtonFA    = '';
           $cancelButtonFA     = '';
           $confirmButtonFAPos = '';
           $cancelButtonFAPos  = '';
           if (isset($this->arr_buttons['bsweetalert_ok']) && isset($this->arr_buttons['bsweetalert_ok']['style']) && '' != $this->arr_buttons['bsweetalert_ok']['style']) {
               $confirmButtonClass = 'scButton_' . $this->arr_buttons['bsweetalert_ok']['style'];
           }
           if (isset($this->arr_buttons['bsweetalert_cancel']) && isset($this->arr_buttons['bsweetalert_cancel']['style']) && '' != $this->arr_buttons['bsweetalert_cancel']['style']) {
               $cancelButtonClass = 'scButton_' . $this->arr_buttons['bsweetalert_cancel']['style'];
           }
           if (isset($this->arr_buttons['bsweetalert_ok']) && isset($this->arr_buttons['bsweetalert_ok']['value']) && '' != $this->arr_buttons['bsweetalert_ok']['value']) {
               $confirmButtonText = $this->arr_buttons['bsweetalert_ok']['value'];
           }
           if (isset($this->arr_buttons['bsweetalert_cancel']) && isset($this->arr_buttons['bsweetalert_cancel']['value']) && '' != $this->arr_buttons['bsweetalert_cancel']['value']) {
               $cancelButtonText = $this->arr_buttons['bsweetalert_cancel']['value'];
           }
           if (isset($this->arr_buttons['bsweetalert_ok']) && isset($this->arr_buttons['bsweetalert_ok']['fontawesomeicon']) && '' != $this->arr_buttons['bsweetalert_ok']['fontawesomeicon']) {
               $confirmButtonFA = $this->arr_buttons['bsweetalert_ok']['fontawesomeicon'];
           }
           if (isset($this->arr_buttons['bsweetalert_cancel']) && isset($this->arr_buttons['bsweetalert_cancel']['fontawesomeicon']) && '' != $this->arr_buttons['bsweetalert_cancel']['fontawesomeicon']) {
               $cancelButtonFA = $this->arr_buttons['bsweetalert_cancel']['fontawesomeicon'];
           }
           if (isset($this->arr_buttons['bsweetalert_ok']) && isset($this->arr_buttons['bsweetalert_ok']['display_position']) && 'img_right' != $this->arr_buttons['bsweetalert_ok']['display_position']) {
               $confirmButtonFAPos = 'text_right';
           }
           if (isset($this->arr_buttons['bsweetalert_cancel']) && isset($this->arr_buttons['bsweetalert_cancel']['display_position']) && 'img_right' != $this->arr_buttons['bsweetalert_cancel']['display_position']) {
               $cancelButtonFAPos = 'text_right';
           }
           $nm_saida->saida("   <script type=\"text/javascript\">\r\n");
           $nm_saida->saida("     var scSweetAlertConfirmButton = \"" . $confirmButtonClass . "\";\r\n");
           $nm_saida->saida("     var scSweetAlertCancelButton = \"" . $cancelButtonClass . "\";\r\n");
           $nm_saida->saida("     var scSweetAlertConfirmButtonText = \"" . $confirmButtonText . "\";\r\n");
           $nm_saida->saida("     var scSweetAlertCancelButtonText = \"" . $cancelButtonText . "\";\r\n");
           $nm_saida->saida("     var scSweetAlertConfirmButtonFA = \"" . $confirmButtonFA . "\";\r\n");
           $nm_saida->saida("     var scSweetAlertCancelButtonFA = \"" . $cancelButtonFA . "\";\r\n");
           $nm_saida->saida("     var scSweetAlertConfirmButtonFAPos = \"" . $confirmButtonFAPos . "\";\r\n");
           $nm_saida->saida("     var scSweetAlertCancelButtonFAPos = \"" . $cancelButtonFAPos . "\";\r\n");
           $nm_saida->saida("   </script>\r\n");
           $nm_saida->saida("   <script type=\"text/javascript\" src=\"grid_jdp_beneficiohogar_detalle_jquery-3.6.0.min.js\"></script>\r\n");
           $nm_saida->saida("   <script type=\"text/javascript\" src=\"grid_jdp_beneficiohogar_detalle_ajax.js\"></script>\r\n");
           $nm_saida->saida("   <script type=\"text/javascript\" src=\"grid_jdp_beneficiohogar_detalle_message.js\"></script>\r\n");
           $nm_saida->saida("   <script type=\"text/javascript\">\r\n");
           $nm_saida->saida("     var sc_ajaxBg = '" . $this->Ini->Color_bg_ajax . "';\r\n");
           $nm_saida->saida("     var sc_ajaxBordC = '" . $this->Ini->Border_c_ajax . "';\r\n");
           $nm_saida->saida("     var sc_ajaxBordS = '" . $this->Ini->Border_s_ajax . "';\r\n");
           $nm_saida->saida("     var sc_ajaxBordW = '" . $this->Ini->Border_w_ajax . "';\r\n");
           $nm_saida->saida("   </script>\r\n");
           $nm_saida->saida("   <script type=\"text/javascript\" src=\"../_lib/lib/js/jquery-3.6.0.min.js\"></script>\r\n");
           $nm_saida->saida("   <link rel=\"stylesheet\" type=\"text/css\" href=\"../_lib/css/" . $this->Ini->str_schema_all . "_sweetalert.css\" />\r\n");
           $nm_saida->saida("   <script type=\"text/javascript\" src=\"" . $this->Ini->path_prod . "/third/sweetalert/sweetalert2.all.min.js\"></script>\r\n");
           $nm_saida->saida("   <script type=\"text/javascript\" src=\"" . $this->Ini->path_prod . "/third/sweetalert/polyfill.min.js\"></script>\r\n");
           $nm_saida->saida("<script type=\"text/javascript\" src=\"../_lib/lib/js/frameControl.js\"></script>\r\n");
           $nm_saida->saida("   <script type=\"text/javascript\">\r\n");
           $nm_saida->saida("      if (!window.Promise)\r\n");
           $nm_saida->saida("      {\r\n");
           $nm_saida->saida("          var head = document.getElementsByTagName('head')[0];\r\n");
           $nm_saida->saida("          var js = document.createElement(\"script\");\r\n");
           $nm_saida->saida("          js.src = \"../_lib/lib/js/bluebird.min.js\";\r\n");
           $nm_saida->saida("          head.appendChild(js);\r\n");
           $nm_saida->saida("      }\r\n");
           $nm_saida->saida("      $(\"#TB_iframeContent\").ready(function(){\r\n");
           $nm_saida->saida("         jQuery(document).bind('keydown.thickbox', function(e) {\r\n");
           $nm_saida->saida("            var keyPressed = e.charCode || e.keyCode || e.which;\r\n");
           $nm_saida->saida("            if (keyPressed == 27) { \r\n");
           $nm_saida->saida("                tb_remove();\r\n");
           $nm_saida->saida("            }\r\n");
           $nm_saida->saida("         })\r\n");
           $nm_saida->saida("      })\r\n");
           $nm_saida->saida("   </script>\r\n");
           $nm_saida->saida("   <script type=\"text/javascript\">\r\n");
           $nm_saida->saida("     var applicationKeys = '';\r\n");
           $nm_saida->saida("     applicationKeys += 'ctrl+shift+right';\r\n");
           $nm_saida->saida("     applicationKeys += ',';\r\n");
           $nm_saida->saida("     applicationKeys += 'ctrl+shift+left';\r\n");
           $nm_saida->saida("     applicationKeys += ',';\r\n");
           $nm_saida->saida("     applicationKeys += 'ctrl+right';\r\n");
           $nm_saida->saida("     applicationKeys += ',';\r\n");
           $nm_saida->saida("     applicationKeys += 'ctrl+left';\r\n");
           $nm_saida->saida("     applicationKeys += ',';\r\n");
           $nm_saida->saida("     applicationKeys += 'alt+q';\r\n");
           $nm_saida->saida("     applicationKeys += ',';\r\n");
           $nm_saida->saida("     applicationKeys += 'ctrl+f';\r\n");
           $nm_saida->saida("     applicationKeys += ',';\r\n");
           $nm_saida->saida("     applicationKeys += 'ctrl+s';\r\n");
           $nm_saida->saida("     applicationKeys += ',';\r\n");
           $nm_saida->saida("     applicationKeys += 'alt+enter';\r\n");
           $nm_saida->saida("     applicationKeys += ',';\r\n");
           $nm_saida->saida("     applicationKeys += 'f1';\r\n");
           $nm_saida->saida("     applicationKeys += ',';\r\n");
           $nm_saida->saida("     applicationKeys += 'ctrl+p';\r\n");
           $nm_saida->saida("     applicationKeys += ',';\r\n");
           $nm_saida->saida("     applicationKeys += 'alt+p';\r\n");
           $nm_saida->saida("     applicationKeys += ',';\r\n");
           $nm_saida->saida("     applicationKeys += 'alt+w';\r\n");
           $nm_saida->saida("     applicationKeys += ',';\r\n");
           $nm_saida->saida("     applicationKeys += 'alt+x';\r\n");
           $nm_saida->saida("     applicationKeys += ',';\r\n");
           $nm_saida->saida("     applicationKeys += 'alt+m';\r\n");
           $nm_saida->saida("     applicationKeys += ',';\r\n");
           $nm_saida->saida("     applicationKeys += 'alt+c';\r\n");
           $nm_saida->saida("     applicationKeys += ',';\r\n");
           $nm_saida->saida("     applicationKeys += 'alt+r';\r\n");
           $nm_saida->saida("     applicationKeys += ',';\r\n");
           $nm_saida->saida("     applicationKeys += 'alt+shift+p';\r\n");
           $nm_saida->saida("     applicationKeys += ',';\r\n");
           $nm_saida->saida("     applicationKeys += 'alt+shift+w';\r\n");
           $nm_saida->saida("     applicationKeys += ',';\r\n");
           $nm_saida->saida("     applicationKeys += 'alt+shift+x';\r\n");
           $nm_saida->saida("     applicationKeys += ',';\r\n");
           $nm_saida->saida("     applicationKeys += 'alt+shift+m';\r\n");
           $nm_saida->saida("     applicationKeys += ',';\r\n");
           $nm_saida->saida("     applicationKeys += 'alt+shift+c';\r\n");
           $nm_saida->saida("     applicationKeys += ',';\r\n");
           $nm_saida->saida("     applicationKeys += 'alt+shift+r';\r\n");
           $nm_saida->saida("     var hotkeyList = '';\r\n");
           $nm_saida->saida("     function execHotKey(e, h) {\r\n");
           $nm_saida->saida("         var hotkey_fired = false\r\n");
           $nm_saida->saida("         switch (true) {\r\n");
           $nm_saida->saida("             case (['ctrl+shift+right'].indexOf(h.key) > -1):\r\n");
           $nm_saida->saida("                 hotkey_fired = process_hotkeys('sys_format_fim');\r\n");
           $nm_saida->saida("                 break;\r\n");
           $nm_saida->saida("             case (['ctrl+shift+left'].indexOf(h.key) > -1):\r\n");
           $nm_saida->saida("                 hotkey_fired = process_hotkeys('sys_format_ini');\r\n");
           $nm_saida->saida("                 break;\r\n");
           $nm_saida->saida("             case (['ctrl+right'].indexOf(h.key) > -1):\r\n");
           $nm_saida->saida("                 hotkey_fired = process_hotkeys('sys_format_ava');\r\n");
           $nm_saida->saida("                 break;\r\n");
           $nm_saida->saida("             case (['ctrl+left'].indexOf(h.key) > -1):\r\n");
           $nm_saida->saida("                 hotkey_fired = process_hotkeys('sys_format_ret');\r\n");
           $nm_saida->saida("                 break;\r\n");
           $nm_saida->saida("             case (['alt+q'].indexOf(h.key) > -1):\r\n");
           $nm_saida->saida("                 hotkey_fired = process_hotkeys('sys_format_sai');\r\n");
           $nm_saida->saida("                 break;\r\n");
           $nm_saida->saida("             case (['ctrl+f'].indexOf(h.key) > -1):\r\n");
           $nm_saida->saida("                 hotkey_fired = process_hotkeys('sys_format_fil');\r\n");
           $nm_saida->saida("                 break;\r\n");
           $nm_saida->saida("             case (['ctrl+s'].indexOf(h.key) > -1):\r\n");
           $nm_saida->saida("                 hotkey_fired = process_hotkeys('sys_format_savegrid');\r\n");
           $nm_saida->saida("                 break;\r\n");
           $nm_saida->saida("             case (['alt+enter'].indexOf(h.key) > -1):\r\n");
           $nm_saida->saida("                 hotkey_fired = process_hotkeys('sys_format_res');\r\n");
           $nm_saida->saida("                 break;\r\n");
           $nm_saida->saida("             case (['f1'].indexOf(h.key) > -1):\r\n");
           $nm_saida->saida("                 hotkey_fired = process_hotkeys('sys_format_webh');\r\n");
           $nm_saida->saida("                 break;\r\n");
           $nm_saida->saida("             case (['ctrl+p'].indexOf(h.key) > -1):\r\n");
           $nm_saida->saida("                 hotkey_fired = process_hotkeys('sys_format_imp');\r\n");
           $nm_saida->saida("                 break;\r\n");
           $nm_saida->saida("             case (['alt+p'].indexOf(h.key) > -1):\r\n");
           $nm_saida->saida("                 hotkey_fired = process_hotkeys('sys_format_pdf');\r\n");
           $nm_saida->saida("                 break;\r\n");
           $nm_saida->saida("             case (['alt+w'].indexOf(h.key) > -1):\r\n");
           $nm_saida->saida("                 hotkey_fired = process_hotkeys('sys_format_word');\r\n");
           $nm_saida->saida("                 break;\r\n");
           $nm_saida->saida("             case (['alt+x'].indexOf(h.key) > -1):\r\n");
           $nm_saida->saida("                 hotkey_fired = process_hotkeys('sys_format_xls');\r\n");
           $nm_saida->saida("                 break;\r\n");
           $nm_saida->saida("             case (['alt+m'].indexOf(h.key) > -1):\r\n");
           $nm_saida->saida("                 hotkey_fired = process_hotkeys('sys_format_xml');\r\n");
           $nm_saida->saida("                 break;\r\n");
           $nm_saida->saida("             case (['alt+c'].indexOf(h.key) > -1):\r\n");
           $nm_saida->saida("                 hotkey_fired = process_hotkeys('sys_format_csv');\r\n");
           $nm_saida->saida("                 break;\r\n");
           $nm_saida->saida("             case (['alt+r'].indexOf(h.key) > -1):\r\n");
           $nm_saida->saida("                 hotkey_fired = process_hotkeys('sys_format_rtf');\r\n");
           $nm_saida->saida("                 break;\r\n");
           $nm_saida->saida("             case (['alt+shift+p'].indexOf(h.key) > -1):\r\n");
           $nm_saida->saida("                 hotkey_fired = process_hotkeys('sys_format_email_pdf');\r\n");
           $nm_saida->saida("                 break;\r\n");
           $nm_saida->saida("             case (['alt+shift+w'].indexOf(h.key) > -1):\r\n");
           $nm_saida->saida("                 hotkey_fired = process_hotkeys('sys_format_email_word');\r\n");
           $nm_saida->saida("                 break;\r\n");
           $nm_saida->saida("             case (['alt+shift+x'].indexOf(h.key) > -1):\r\n");
           $nm_saida->saida("                 hotkey_fired = process_hotkeys('sys_format_email_xls');\r\n");
           $nm_saida->saida("                 break;\r\n");
           $nm_saida->saida("             case (['alt+shift+m'].indexOf(h.key) > -1):\r\n");
           $nm_saida->saida("                 hotkey_fired = process_hotkeys('sys_format_email_xml');\r\n");
           $nm_saida->saida("                 break;\r\n");
           $nm_saida->saida("             case (['alt+shift+c'].indexOf(h.key) > -1):\r\n");
           $nm_saida->saida("                 hotkey_fired = process_hotkeys('sys_format_email_csv');\r\n");
           $nm_saida->saida("                 break;\r\n");
           $nm_saida->saida("             case (['alt+shift+r'].indexOf(h.key) > -1):\r\n");
           $nm_saida->saida("                 hotkey_fired = process_hotkeys('sys_format_email_rtf');\r\n");
           $nm_saida->saida("                 break;\r\n");
           $nm_saida->saida("         }\r\n");
           $nm_saida->saida("         if (hotkey_fired) {\r\n");
           $nm_saida->saida("             e.preventDefault();\r\n");
           $nm_saida->saida("             return false;\r\n");
           $nm_saida->saida("         } else {\r\n");
           $nm_saida->saida("             return true;\r\n");
           $nm_saida->saida("         }\r\n");
           $nm_saida->saida("     }\r\n");
           $nm_saida->saida("   </script>\r\n");
           $nm_saida->saida("   <script type=\"text/javascript\" src=\"../_lib/lib/js/hotkeys.inc.js\"></script>\r\n");
           $nm_saida->saida("   <script type=\"text/javascript\" src=\"../_lib/lib/js/hotkeys_setup.js\"></script>\r\n");
           $nm_saida->saida("   <script type=\"text/javascript\" src=\"" . $this->Ini->path_prod . "/third/jquery/js/jquery-ui.js\"></script>\r\n");
           $nm_saida->saida("   <link rel=\"stylesheet\" href=\"" . $this->Ini->path_prod . "/third/jquery/css/smoothness/jquery-ui.css\" type=\"text/css\" media=\"screen\" />\r\n");
           $nm_saida->saida("   <link rel=\"stylesheet\" href=\"" . $this->Ini->path_prod . "/third/font-awesome/css/all.min.css\" type=\"text/css\" media=\"screen\" />\r\n");
           $nm_saida->saida("   <script type=\"text/javascript\" src=\"" . $this->Ini->path_prod . "/third/jquery_plugin/touch_punch/jquery.ui.touch-punch.min.js\"></script>\r\n");
           $nm_saida->saida("   <script type=\"text/javascript\" src=\"" . $this->Ini->path_prod . "/third/jquery_plugin/malsup-blockui/jquery.blockUI.js\"></script>\r\n");
           $nm_saida->saida("   <link rel=\"stylesheet\" href=\"" . $this->Ini->path_prod . "/third/jquery_plugin/dropdown_check_list/css/ui.dropdownchecklist.standalone.css\" type=\"text/css\" />\r\n");
           $nm_saida->saida("   <script type=\"text/javascript\" src=\"" . $this->Ini->path_prod . "/third/jquery_plugin/dropdown_check_list/js/ui.dropdownchecklist.js\"></script>\r\n");
           $nm_saida->saida("        <script type=\"text/javascript\">\r\n");
           $nm_saida->saida("          var sc_pathToTB = '" . $this->Ini->path_prod . "/third/jquery_plugin/thickbox/';\r\n");
           $nm_saida->saida("          var sc_tbLangClose = \"" . html_entity_decode($this->Ini->Nm_lang['lang_tb_close'], ENT_COMPAT, $_SESSION['scriptcase']['charset']) . "\";\r\n");
           $nm_saida->saida("          var sc_tbLangEsc = \"" . html_entity_decode($this->Ini->Nm_lang['lang_tb_esc'], ENT_COMPAT, $_SESSION['scriptcase']['charset']) . "\";\r\n");
           $nm_saida->saida("        </script>\r\n");
           $nm_saida->saida("   <script type=\"text/javascript\" src=\"" . $this->Ini->path_prod . "/third/jquery_plugin/thickbox/thickbox-compressed.js\"></script>\r\n");
           $nm_saida->saida("   <script type=\"text/javascript\" src=\"../_lib/lib/js/scInput.js\"></script>\r\n");
           $nm_saida->saida("   <script type=\"text/javascript\" src=\"../_lib/lib/js/jquery.scInput.js\"></script>\r\n");
           $nm_saida->saida("   <script type=\"text/javascript\" src=\"../_lib/lib/js/jquery.scInput2.js\"></script>\r\n");
           $nm_saida->saida("   <script type=\"text/javascript\" src=\"../_lib/lib/js/bluebird.min.js\"></script>\r\n");
           $nm_saida->saida("   <link rel=\"stylesheet\" href=\"" . $this->Ini->path_prod . "/third/jquery_plugin/thickbox/thickbox.css\" type=\"text/css\" media=\"screen\" />\r\n");
           $nm_saida->saida("   <link rel=\"stylesheet\" type=\"text/css\" href=\"../_lib/buttons/" . $this->Ini->Str_btn_css . "\" /> \r\n");
           $nm_saida->saida("   <link rel=\"stylesheet\" type=\"text/css\" href=\"../_lib/css/" . $this->Ini->str_schema_all . "_form.css\" /> \r\n");
           $nm_saida->saida("   <link rel=\"stylesheet\" type=\"text/css\" href=\"../_lib/css/" . $this->Ini->str_schema_all . "_form" . $_SESSION['scriptcase']['reg_conf']['css_dir'] . ".css\" /> \r\n");
           $nm_saida->saida("   <link rel=\"stylesheet\" type=\"text/css\" href=\"../_lib/css/" . $this->Ini->str_schema_all . "_filter.css\" /> \r\n");
           $nm_saida->saida("   <link rel=\"stylesheet\" type=\"text/css\" href=\"../_lib/css/" . $this->Ini->str_schema_all . "_filter" . $_SESSION['scriptcase']['reg_conf']['css_dir'] . ".css\" /> \r\n");
           $nm_saida->saida("   <link rel=\"stylesheet\" type=\"text/css\" href=\"../_lib/css/" . $this->Ini->str_schema_all . "_appdiv.css\" /> \r\n");
           $nm_saida->saida("   <link rel=\"stylesheet\" type=\"text/css\" href=\"../_lib/css/" . $this->Ini->str_schema_all . "_appdiv" . $_SESSION['scriptcase']['reg_conf']['css_dir'] . ".css\" /> \r\n");
           $nm_saida->saida("   <style type=\"text/css\"> \r\n");
           $nm_saida->saida("     .scGridLabelVert a img[src\$='" . $this->Ini->Label_sort_desc . "'], \r\n");
           $nm_saida->saida("     .scGridLabelVert a img[src\$='" . $this->Ini->Label_sort_asc . "'], \r\n");
           $nm_saida->saida("     .scGridLabelVert a img[src\$='" . $this->arr_buttons['bgraf']['image'] . "'], \r\n");
           $nm_saida->saida("     .scGridLabelVert a img[src\$='" . $this->arr_buttons['bconf_graf']['image'] . "']{opacity:1!important;} \r\n");
           $nm_saida->saida("     .scGridLabelVert a img{opacity:0;transition:all .2s;} \r\n");
           $nm_saida->saida("     .scGridLabelVert:HOVER a img{opacity:1;transition:all .2s;} \r\n");
           $nm_saida->saida("   </style> \r\n");
           $nm_saida->saida("   <script type=\"text/javascript\"> \r\n");
           if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'])
           { 
               $nm_saida->saida("   function sc_session_redir(url_redir)\r\n");
               $nm_saida->saida("   {\r\n");
           $nm_saida->saida("       if (typeof(sc_session_redir_mobile) === typeof(function(){})) { sc_session_redir_mobile(url_redir); }\r\n");
               $nm_saida->saida("       if (window.parent && window.parent.document != window.document && typeof window.parent.sc_session_redir === 'function')\r\n");
               $nm_saida->saida("       {\r\n");
               $nm_saida->saida("           window.parent.sc_session_redir(url_redir);\r\n");
               $nm_saida->saida("       }\r\n");
               $nm_saida->saida("       else\r\n");
               $nm_saida->saida("       {\r\n");
               $nm_saida->saida("           if (window.opener && typeof window.opener.sc_session_redir === 'function')\r\n");
               $nm_saida->saida("           {\r\n");
               $nm_saida->saida("               window.close();\r\n");
               $nm_saida->saida("               window.opener.sc_session_redir(url_redir);\r\n");
               $nm_saida->saida("           }\r\n");
               $nm_saida->saida("           else\r\n");
               $nm_saida->saida("           {\r\n");
               $nm_saida->saida("               window.location = url_redir;\r\n");
               $nm_saida->saida("           }\r\n");
               $nm_saida->saida("       }\r\n");
               $nm_saida->saida("   }\r\n");
           }
           $nm_saida->saida("   var scBtnGrpStatus = {};\r\n");
           $nm_saida->saida("   var SC_Link_View = false;\r\n");
           if ($this->Ini->SC_Link_View)
           {
               $nm_saida->saida("   SC_Link_View = true;\r\n");
           }
           $nm_saida->saida("   var Qsearch_ok = true;\r\n");
           if (!$this->Ini->SC_Link_View && $this->nmgp_botoes['qsearch'] != "on")
           {
               $nm_saida->saida("   Qsearch_ok = false;\r\n");
           }
           $nm_saida->saida("   var scQSInit = true;\r\n");
           if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] || $this->Ini->Apl_paginacao == "FULL")
           {
               $nm_saida->saida("   var scQtReg  = " . NM_encode_input($this->count_ger) . ";\r\n");
           }
           else
           {
               $nm_saida->saida("   var scQtReg  = " . NM_encode_input($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_reg_grid']) . ";\r\n");
           }
           $nm_saida->saida("   var Dyn_Ini   = true;\r\n");
           $nm_saida->saida("   var nmdg_Form = \"Fdyn_search\";\r\n");
           if (is_file($this->Ini->root . $this->Ini->path_link . "_lib/js/tab_erro_" . $this->Ini->str_lang . ".js"))
           {
               $Tb_err_js = file($this->Ini->root . $this->Ini->path_link . "_lib/js/tab_erro_" . $this->Ini->str_lang . ".js");
               foreach ($Tb_err_js as $Lines)
               {
                   if (NM_is_utf8($Lines) && $_SESSION['scriptcase']['charset'] != "UTF-8")
                   {
                       $Lines = sc_convert_encoding($Lines, $_SESSION['scriptcase']['charset'], "UTF-8");
                   }
                   echo "   " . $Lines;
               }
           }
           $Msg_Inval = "Inv�lido";
           if (NM_is_utf8($Lines) && $_SESSION['scriptcase']['charset'] != "UTF-8")
           {
               $Msg_Inval = sc_convert_encoding($Msg_Inval, $_SESSION['scriptcase']['charset'], "UTF-8");
           }
           echo "   var SC_crit_inv = \"" . $Msg_Inval . "\";\r\n";
           $gridWidthCorrection = '';
           if (false !== strpos($this->Ini->grid_table_width, 'calc')) {
               $gridWidthCalc = substr($this->Ini->grid_table_width, strpos($this->Ini->grid_table_width, '(') + 1);
               $gridWidthCalc = substr($gridWidthCalc, 0, strpos($gridWidthCalc, ')'));
               $gridWidthParts = explode(' ', $gridWidthCalc);
               if (3 == count($gridWidthParts) && 'px' == substr($gridWidthParts[2], -2)) {
                   $gridWidthParts[2] = substr($gridWidthParts[2], 0, -2) / 2;
                   $gridWidthCorrection = $gridWidthParts[1] . ' ' . $gridWidthParts[2];
               }
           }
           $nm_saida->saida("    function scFixZindexCornerCells()\r\n");
           $nm_saida->saida("    {\r\n");
           $nm_saida->saida("        let cells = $(\".sc-ui-grid-header-row-grid_jdp_beneficiohogar_detalle-1\").find(\"td\");\r\n");
           $nm_saida->saida("        cells.filter(\".sc-col-is-fixed\").css(\"z-index\", 5);\r\n");
           $nm_saida->saida("        cells.filter(\".sc-col-is-fixed\").filter(\".sc-col-actions\").css(\"z-index\", 6);\r\n");
           $nm_saida->saida("    }\r\n");
           $nm_saida->saida("    function scSetFixedHeadersCss(baseTop)\r\n");
           $nm_saida->saida("    {\r\n");
           $nm_saida->saida("        let rows, cols, i, j, thisTop;\r\n");
           $nm_saida->saida("        rows = $(\".sc-ui-grid-header-row-grid_jdp_beneficiohogar_detalle-1\");\r\n");
           $nm_saida->saida("        thisTop = baseTop;\r\n");
           $nm_saida->saida("        for (i = 0; i < rows.length; i++) {\r\n");
           $nm_saida->saida("            cols = $(rows[i]).find(\"td\").filter(\".scGridLabelFont\");\r\n");
           $nm_saida->saida("            for (j = 0; j < cols.length; j++) {\r\n");
           $nm_saida->saida("                $(cols[j]).css({\r\n");
           $nm_saida->saida("                    \"position\": \"sticky\",\r\n");
           $nm_saida->saida("                    \"top\": thisTop + \"px\",\r\n");
           $nm_saida->saida("                    \"z-index\": 4\r\n");
           $nm_saida->saida("                }).addClass(\"sc-header-fixed\");\r\n");
           $nm_saida->saida("            }\r\n");
           $nm_saida->saida("            thisTop += $(rows[i]).height();\r\n");
           $nm_saida->saida("        }\r\n");
           $nm_saida->saida("        scFixZindexCornerCells();\r\n");
           $nm_saida->saida("    }\r\n");
           $nm_saida->saida("    $(function() {\r\n");
           $nm_saida->saida("        scSetFixedHeadersCss(0);\r\n");
           $nm_saida->saida("    });\r\n");
           $nm_saida->saida("  function scSetFixedHeaders() {\r\n");
           $nm_saida->saida("   return;alert(2);\r\n");
           $nm_saida->saida("   return;\r\n");
           $nm_saida->saida("  }\r\n");
           $nm_saida->saida("  function scSetFixedHeadersPosition(gridHeaders, headerPlaceholder) {\r\n");
           $nm_saida->saida("   if(gridHeaders)\r\n");
           $nm_saida->saida("   {\r\n");
           $nm_saida->saida("       headerPlaceholder.css({\"top\": 0" . $gridWidthCorrection . ", \"left\": (Math.floor(gridHeaders.offset().left) - $(document).scrollLeft()" . $gridWidthCorrection . ") + \"px\"});\r\n");
           $nm_saida->saida("   }\r\n");
           $nm_saida->saida("  }\r\n");
           $nm_saida->saida("  function scIsHeaderVisible(gridHeaders) {\r\n");
           $nm_saida->saida("   if (typeof(scIsHeaderVisibleMobile) === typeof(function(){})) { return scIsHeaderVisibleMobile(gridHeaders); }\r\n");
           $nm_saida->saida("   return gridHeaders.offset().top > $(document).scrollTop();\r\n");
           $nm_saida->saida("  }\r\n");
           $nm_saida->saida("  function scGetHeaderRow() {\r\n");
           $nm_saida->saida("   var gridHeaders = $(\".sc-ui-grid-header-row-grid_jdp_beneficiohogar_detalle-1\"), headerDisplayed = true;\r\n");
           $nm_saida->saida("   if (!gridHeaders.length) {\r\n");
           $nm_saida->saida("    headerDisplayed = false;\r\n");
           $nm_saida->saida("   }\r\n");
           $nm_saida->saida("   else {\r\n");
           $nm_saida->saida("    if (!gridHeaders.filter(\":visible\").length) {\r\n");
           $nm_saida->saida("     headerDisplayed = false;\r\n");
           $nm_saida->saida("    }\r\n");
           $nm_saida->saida("   }\r\n");
           $nm_saida->saida("   if (!headerDisplayed) {\r\n");
           $nm_saida->saida("    gridHeaders = $(\".sc-ui-grid-header-row\").filter(\":visible\");\r\n");
           $nm_saida->saida("    if (gridHeaders.length) {\r\n");
           $nm_saida->saida("     gridHeaders = $(gridHeaders[0]);\r\n");
           $nm_saida->saida("    }\r\n");
           $nm_saida->saida("    else {\r\n");
           $nm_saida->saida("     gridHeaders = false;\r\n");
           $nm_saida->saida("    }\r\n");
           $nm_saida->saida("   }\r\n");
           $nm_saida->saida("   return gridHeaders;\r\n");
           $nm_saida->saida("  }\r\n");
           $nm_saida->saida("  function scSetFixedHeadersContents(gridHeaders, headerPlaceholder) {\r\n");
           $nm_saida->saida("   var i, htmlContent;\r\n");
           $nm_saida->saida("   htmlContent = \"<table id=\\\"sc-id-fixed-headers\\\" class=\\\"scGridTabela\\\">\";\r\n");
           $nm_saida->saida("   for (i = 0; i < gridHeaders.length; i++) {\r\n");
           $nm_saida->saida("    htmlContent += \"<tr class=\\\"scGridLabel\\\" id=\\\"sc-id-fixed-headers-row-\" + i + \"\\\">\" + $(gridHeaders[i]).html() + \"</tr>\";\r\n");
           $nm_saida->saida("   }\r\n");
           $nm_saida->saida("   htmlContent += \"</table>\";\r\n");
           $nm_saida->saida("   headerPlaceholder.html(htmlContent);\r\n");
           $nm_saida->saida("  }\r\n");
           $nm_saida->saida("  function scSetFixedHeadersSize(gridHeaders) {\r\n");
           $nm_saida->saida("   var i, j, headerColumns, gridColumns, cellHeight, cellWidth, tableOriginal, tableHeaders;\r\n");
           $nm_saida->saida("   tableOriginal = document.getElementById(\"sc-ui-grid-body-deadf598\");\r\n");
           $nm_saida->saida("   tableHeaders = document.getElementById(\"sc-id-fixed-headers\");\r\n");
           $nm_saida->saida("    tableWidth = $(tableOriginal).outerWidth();\r\n");
           $nm_saida->saida("   $(tableHeaders).css(\"width\", tableWidth);\r\n");
           $nm_saida->saida("   for (i = 0; i < gridHeaders.length; i++) {\r\n");
           $nm_saida->saida("    headerColumns = $(\"#sc-id-fixed-headers-row-\" + i).find(\"td\");\r\n");
           $nm_saida->saida("    gridColumns = $(gridHeaders[i]).find(\"td\");\r\n");
           $nm_saida->saida("    for (j = 0; j < gridColumns.length; j++) {\r\n");
           $nm_saida->saida("     if (window.getComputedStyle(gridColumns[j])) {\r\n");
           $nm_saida->saida("      cellWidth = window.getComputedStyle(gridColumns[j]).width;\r\n");
           $nm_saida->saida("      cellHeight = window.getComputedStyle(gridColumns[j]).height;\r\n");
           $nm_saida->saida("     }\r\n");
           $nm_saida->saida("     else {\r\n");
           $nm_saida->saida("      cellWidth = $(gridColumns[j]).width() + \"px\";\r\n");
           $nm_saida->saida("      cellHeight = $(gridColumns[j]).height() + \"px\";\r\n");
           $nm_saida->saida("     }\r\n");
           $nm_saida->saida("     $(headerColumns[j]).css({\r\n");
           $nm_saida->saida("      \"width\": cellWidth,\r\n");
           $nm_saida->saida("      \"height\": cellHeight\r\n");
           $nm_saida->saida("     });\r\n");
           $nm_saida->saida("    }\r\n");
           $nm_saida->saida("   }\r\n");
           $nm_saida->saida("  }\r\n");
           $nm_saida->saida("  function SC_init_jquery(isScrollNav){ \r\n");
           $nm_saida->saida("   \$(function(){ \r\n");
           $nm_saida->saida("     NM_btn_disable();\r\n");
           $nm_saida->saida("     if (Dyn_Ini)\r\n");
           $nm_saida->saida("     {\r\n");
           $nm_saida->saida("         Dyn_Ini = false;\r\n");
           if ($nmgrp_apl_opcao != "pdf" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != 'print' && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['grid_pesq']))
           { 
           $nm_saida->saida("         SC_carga_evt_jquery_grid('all');\r\n");
           } 
           $nm_saida->saida("         scLoadScInput('input:text.sc-js-input');\r\n");
           $nm_saida->saida("     }\r\n");
           if (!$this->Ini->SC_Link_View && $this->nmgp_botoes['qsearch'] == "on")
           {
               $nm_saida->saida("     \$('#SC_fast_search_top').keyup(function(e) {\r\n");
               $nm_saida->saida("       scQuickSearchKeyUp('top', e);\r\n");
               $nm_saida->saida("     });\r\n");
           }
           $nm_saida->saida("     $('#id_F0_top').keyup(function(e) {\r\n");
           $nm_saida->saida("       var keyPressed = e.charCode || e.keyCode || e.which;\r\n");
           $nm_saida->saida("       if (13 == keyPressed) {\r\n");
           $nm_saida->saida("          return false; \r\n");
           $nm_saida->saida("       }\r\n");
           $nm_saida->saida("     });\r\n");
           $nm_saida->saida("     $('#id_F0_bot').keyup(function(e) {\r\n");
           $nm_saida->saida("       var keyPressed = e.charCode || e.keyCode || e.which;\r\n");
           $nm_saida->saida("       if (13 == keyPressed) {\r\n");
           $nm_saida->saida("          return false; \r\n");
           $nm_saida->saida("       }\r\n");
           $nm_saida->saida("     });\r\n");
           $nm_saida->saida("     $(\".scBtnGrpText\").mouseover(function() { $(this).addClass(\"scBtnGrpTextOver\"); }).mouseout(function() { $(this).removeClass(\"scBtnGrpTextOver\"); });\r\n");
           $nm_saida->saida("     $(\".scBtnGrpClick\").mouseup(function(event){\r\n");
           $nm_saida->saida("          event.preventDefault();\r\n");
           $nm_saida->saida("          if(event.target !== event.currentTarget) return;\r\n");
           $nm_saida->saida("          if($(this).find(\"a\").prop('href') != '')\r\n");
           $nm_saida->saida("          {\r\n");
           $nm_saida->saida("              $(this).find(\"a\").click();\r\n");
           $nm_saida->saida("          }\r\n");
           $nm_saida->saida("          else\r\n");
           $nm_saida->saida("          {\r\n");
           $nm_saida->saida("              eval($(this).find(\"a\").prop('onclick'));\r\n");
           $nm_saida->saida("          }\r\n");
           $nm_saida->saida("     });\r\n");
           $nm_saida->saida("   }); \r\n");
           $nm_saida->saida("  }\r\n");
           $nm_saida->saida("  SC_init_jquery(false);\r\n");
           $nm_saida->saida("   \$(window).on('load', function() {\r\n");
           if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ancor_save']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ancor_save']))
           {
               $nm_saida->saida("       var catTopPosition = jQuery('#SC_ancor" . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ancor_save'] . "').offset().top;\r\n");
               $nm_saida->saida("       jQuery('html, body').animate({scrollTop:catTopPosition}, 'fast');\r\n");
               unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ancor_save']);
           }
           if (!$this->Ini->SC_Link_View && $this->nmgp_botoes['qsearch'] == "on")
           {
               $nm_saida->saida("     scQuickSearchKeyUp('top', null);\r\n");
           }
           $nm_saida->saida("   });\r\n");
           $nm_saida->saida("   function scQuickSearchSubmit_top() {\r\n");
           $nm_saida->saida("     document.F0_top.nmgp_opcao.value = 'fast_search';\r\n");
           $nm_saida->saida("     document.F0_top.submit();\r\n");
           $nm_saida->saida("   }\r\n");
           $nm_saida->saida("   function scQuickSearchKeyUp(sPos, e) {\r\n");
           $nm_saida->saida("     if (null != e) {\r\n");
           $nm_saida->saida("       var keyPressed = e.charCode || e.keyCode || e.which;\r\n");
           $nm_saida->saida("       if (13 == keyPressed) {\r\n");
           $nm_saida->saida("         if ('top' == sPos) nm_gp_submit_qsearch('top');\r\n");
           $nm_saida->saida("       }\r\n");
           $nm_saida->saida("       else\r\n");
           $nm_saida->saida("       {\r\n");
           $nm_saida->saida("           $('#SC_fast_search_submit_top').show();\r\n");
           $nm_saida->saida("       }\r\n");
           $nm_saida->saida("     }\r\n");
           $nm_saida->saida("   }\r\n");
           $nm_saida->saida("   function scBtnGroupByShow(sUrl, sPos) {\r\n");
           $nm_saida->saida("     if ($(\"#sc_id_groupby_placeholder_\" + sPos).css('display') != 'none') {\r\n");
           if ($_SESSION['scriptcase']['proc_mobile']) { 
               $nm_saida->saida("         //return;\r\n");
           }
           else {
               $nm_saida->saida("         scBtnGroupByHide(sPos);\r\n");
               $nm_saida->saida("         $(\"#sel_groupby_\" + sPos).removeClass(\"selected\");\r\n");
               $nm_saida->saida("         return;\r\n");
           }
           $nm_saida->saida("     }\r\n");
           $nm_saida->saida("     $.ajax({\r\n");
           $nm_saida->saida("       type: \"GET\",\r\n");
           $nm_saida->saida("       dataType: \"html\",\r\n");
           $nm_saida->saida("       url: sUrl\r\n");
           $nm_saida->saida("     }).done(function(data) {\r\n");
           $nm_saida->saida("       $(\"#sc_id_groupby_placeholder_\" + sPos).find(\"td\").html(\"\");\r\n");
           $nm_saida->saida("       $(\"#sc_id_groupby_placeholder_\" + sPos).find(\"td\").html(data);\r\n");
           $nm_saida->saida("       $(\"#sc_id_groupby_placeholder_\" + sPos).show();\r\n");
           $nm_saida->saida("     });\r\n");
           $nm_saida->saida("   }\r\n");
           $nm_saida->saida("   function scBtnGroupByHide(sPos) {\r\n");
           $nm_saida->saida("     $(\"#sc_id_groupby_placeholder_\" + sPos).hide();\r\n");
           $nm_saida->saida("     $(\"#sc_id_groupby_placeholder_\" + sPos).find(\"td\").html(\"\");\r\n");
           $nm_saida->saida("   }\r\n");
           $nm_saida->saida("   function scBtnSelCamposShow(sUrl, sPos) {\r\n");
           $nm_saida->saida("     if ($(\"#sc_id_sel_campos_placeholder_\" + sPos).css('display') != 'none') {\r\n");
           if ($_SESSION['scriptcase']['proc_mobile']) { 
               $nm_saida->saida("         //return;\r\n");
           }
           else {
               $nm_saida->saida("         scBtnSelCamposHide(sPos);\r\n");
               $nm_saida->saida("         $(\"#selcmp_\" + sPos).removeClass(\"selected\");\r\n");
               $nm_saida->saida("         return;\r\n");
           }
           $nm_saida->saida("     }\r\n");
           $nm_saida->saida("     $.ajax({\r\n");
           $nm_saida->saida("       type: \"GET\",\r\n");
           $nm_saida->saida("       dataType: \"html\",\r\n");
           $nm_saida->saida("       url: sUrl\r\n");
           $nm_saida->saida("     }).done(function(data) {\r\n");
           $nm_saida->saida("       $(\"#sc_id_sel_campos_placeholder_\" + sPos).find(\"td\").html(\"\");\r\n");
           $nm_saida->saida("       $(\"#sc_id_sel_campos_placeholder_\" + sPos).find(\"td\").html(data);\r\n");
           $nm_saida->saida("       $(\"#sc_id_sel_campos_placeholder_\" + sPos).show();\r\n");
           $nm_saida->saida("     });\r\n");
           $nm_saida->saida("   }\r\n");
           $nm_saida->saida("   function scBtnSelCamposHide(sPos) {\r\n");
           $nm_saida->saida("     $(\"#sc_id_sel_campos_placeholder_\" + sPos).hide();\r\n");
           $nm_saida->saida("     $(\"#sc_id_sel_campos_placeholder_\" + sPos).find(\"td\").html(\"\");\r\n");
           $nm_saida->saida("   }\r\n");
$nm_saida->saida("function ajax_check_file(img_name, field , i , p, p_cache){\r\n");
$nm_saida->saida("    $(document).ready(function(){\r\n");
$nm_saida->saida("        $('#id_sc_field_'+ field +'_'+i+'> img').attr('src', '" . $this->Ini->path_icones . "/scriptcase__NM__ajax_load.gif');\r\n");
$nm_saida->saida("        $('#id_sc_field_'+ field +'_'+i+' > a > img').attr('src', '" . $this->Ini->path_icones . "/scriptcase__NM__ajax_load.gif');\r\n");
$nm_saida->saida("        $('#id_sc_field_'+ field +'_'+i+' > span > a > img').attr('src', '" . $this->Ini->path_icones . "/scriptcase__NM__ajax_load.gif');\r\n");
$nm_saida->saida("    var rs =$.ajax({\r\n");
$nm_saida->saida("                type: \"POST\",\r\n");
$nm_saida->saida("                url: 'index.php?script_case_init=" . $this->Ini->sc_page . "',\r\n");
$nm_saida->saida("                async: true,\r\n");
$nm_saida->saida("                data: 'nmgp_opcao=ajax_check_file&AjaxCheckImg=' + img_name +'&rsargs='+ field + '&p='+ p + '&p_cache='+ p_cache,\r\n");
$nm_saida->saida("            }).done(function (rs) {\r\n");
$nm_saida->saida("                    if(rs.indexOf('</span>') != -1){\r\n");
$nm_saida->saida("                        rs = rs.substr(rs.indexOf('</span>')  + 7);\r\n");
$nm_saida->saida("                    }\r\n");
$nm_saida->saida("                    if (rs != 0) {\r\n");
$nm_saida->saida("                        rs = rs.trim();\r\n");
$nm_saida->saida("                        rs_split = rs.split('_@@NM@@_');\r\n");
$nm_saida->saida("                        rs_orig = rs_split[0];\r\n");
$nm_saida->saida("                        rs = rs_split[1];\r\n");
$nm_saida->saida("                        if($('#id_sc_field_'+ field +'_'+i+'  > a > img').length != 0){\r\n");
$nm_saida->saida("                            $('#id_sc_field_'+ field +'_'+i+'  > a > img').attr('src', rs);\r\n");
$nm_saida->saida("                            $('#id_sc_field_'+ field +'_'+i+'> img').attr('src', rs);\r\n");
$nm_saida->saida("                            var __tmp = $('#id_sc_field_'+ field +'_'+i+'  > a').attr('href').split(\"',\")\r\n");
$nm_saida->saida("                            __tmp[0] = \"javascript:nm_mostra_img('\" + rs_orig;\r\n");
$nm_saida->saida("                            $('#id_sc_field_'+ field +'_'+i+'  > a').attr('href',__tmp.join(\"',\"));\r\n");
$nm_saida->saida("                        }else{\r\n");
$nm_saida->saida("                            if($('#id_sc_field_'+ field +'_'+i+' > a').length > 0 && ($('#id_sc_field_'+ field +'_'+i+' > a').attr('href')).indexOf('@SC_par@') != -1){\r\n");
$nm_saida->saida("                                var __file_doc = $('#id_sc_field_'+ field +'_'+i+' > a').attr('href').split('@SC_par@');\r\n");
$nm_saida->saida("                                var ___file_doc = __file_doc[3].split(\"'\");\r\n");
$nm_saida->saida("                                ___file_doc[0] = rs;\r\n");
$nm_saida->saida("                                __file_doc[3] = ___file_doc.join(\"'\");\r\n");
$nm_saida->saida("                                $('#id_sc_field_'+ field +'_'+i+'  > a').attr('href', __file_doc.join('@SC_par@') );\r\n");
$nm_saida->saida("                            }\r\n");
$nm_saida->saida("                            else{\r\n");
$nm_saida->saida("                                if($('#id_sc_field_'+field+'_'+i+' > span > a').length > 0){\r\n");
$nm_saida->saida("                                    var __tmp = $('#id_sc_field_'+field+'_'+i+' > span > a').attr('href').split(\"',\");\r\n");
$nm_saida->saida("                                    if(__tmp[0].indexOf('nm_mostra_img') != -1){\r\n");
$nm_saida->saida("                                        __tmp[0] = \"javascript:nm_mostra_img('\" + rs_orig;\r\n");
$nm_saida->saida("                                    } else{\r\n");
$nm_saida->saida("                                        var __file_doc = __tmp[0].split('@SC_par@');\r\n");
$nm_saida->saida("                                        var ___file_doc = __file_doc[3].split(\"'\");\r\n");
$nm_saida->saida("                                        ___file_doc[0] = rs;\r\n");
$nm_saida->saida("                                        __file_doc[3] = ___file_doc.join(\"'\");\r\n");
$nm_saida->saida("                                        __tmp[0] = __file_doc.join('@SC_par@');\r\n");
$nm_saida->saida("                                        $('#id_sc_field_'+field+'_'+i+' > span > a').attr('href', __tmp.join(\"',\"));\r\n");
$nm_saida->saida("                                        //__tmp[1] = \"'\"+rs_orig+\"')\";\r\n");
$nm_saida->saida("                                    }\r\n");
$nm_saida->saida("                                    $('#id_sc_field_'+field+'_'+i+' > span > a').attr('href',__tmp.join(\"',\"));\r\n");
$nm_saida->saida("                                }\r\n");
$nm_saida->saida("                                $('#id_sc_field_'+ field +'_'+i+' > img').attr('src', rs);\r\n");
$nm_saida->saida("                                $('#id_sc_field_'+ field +'_'+i+' > a > img').attr('src', rs);\r\n");
$nm_saida->saida("                                $('#id_sc_field_'+ field +'_'+i+' > span > a > img').attr('src', rs);\r\n");
$nm_saida->saida("                            }\r\n");
$nm_saida->saida("                        }\r\n");
$nm_saida->saida("                    }\r\n");
$nm_saida->saida("                });\r\n");
$nm_saida->saida("    });\r\n");
$nm_saida->saida("}\r\n");
           $nm_saida->saida("   function scBtnOrderCamposShow(sUrl, sPos) {\r\n");
           $nm_saida->saida("     if ($(\"#sc_id_order_campos_placeholder_\" + sPos).css('display') != 'none') {\r\n");
           if ($_SESSION['scriptcase']['proc_mobile']) { 
               $nm_saida->saida("         //return;\r\n");
           }
           else {
               $nm_saida->saida("         scBtnOrderCamposHide(sPos);\r\n");
               $nm_saida->saida("         $(\"#ordcmp_\" + sPos).removeClass(\"selected\");\r\n");
               $nm_saida->saida("         return;\r\n");
           }
           $nm_saida->saida("     }\r\n");
           $nm_saida->saida("     $.ajax({\r\n");
           $nm_saida->saida("       type: \"GET\",\r\n");
           $nm_saida->saida("       dataType: \"html\",\r\n");
           $nm_saida->saida("       url: sUrl\r\n");
           $nm_saida->saida("     }).done(function(data) {\r\n");
           $nm_saida->saida("       $(\"#sc_id_order_campos_placeholder_\" + sPos).find(\"td\").html(\"\");\r\n");
           $nm_saida->saida("       $(\"#sc_id_order_campos_placeholder_\" + sPos).find(\"td\").html(data);\r\n");
           $nm_saida->saida("       $(\"#sc_id_order_campos_placeholder_\" + sPos).show();\r\n");
           $nm_saida->saida("     });\r\n");
           $nm_saida->saida("   }\r\n");
           $nm_saida->saida("   function scBtnOrderCamposHide(sPos) {\r\n");
           $nm_saida->saida("     $(\"#sc_id_order_campos_placeholder_\" + sPos).hide();\r\n");
           $nm_saida->saida("     $(\"#sc_id_order_campos_placeholder_\" + sPos).find(\"td\").html(\"\");\r\n");
           $nm_saida->saida("   }\r\n");
           $nm_saida->saida("   function scBtnGrpShow(sGroup) {\r\n");
           $nm_saida->saida("     if (typeof(scBtnGrpShowMobile) === typeof(function(){})) { return scBtnGrpShowMobile(sGroup); };\r\n");
           $nm_saida->saida("     $('#sc_btgp_btn_' + sGroup).addClass('selected');\r\n");
           $nm_saida->saida("     var btnPos = $('#sc_btgp_btn_' + sGroup).offset();\r\n");
           $nm_saida->saida("     scBtnGrpStatus[sGroup] = 'open';\r\n");
           $nm_saida->saida("     $('#sc_btgp_btn_' + sGroup).mouseout(function() {\r\n");
           $nm_saida->saida("       scBtnGrpStatus[sGroup] = '';\r\n");
           $nm_saida->saida("       setTimeout(function() {\r\n");
           $nm_saida->saida("         scBtnGrpHide(sGroup, false);\r\n");
           $nm_saida->saida("       }, 1000);\r\n");
           $nm_saida->saida("     }).mouseover(function() {\r\n");
           $nm_saida->saida("       scBtnGrpStatus[sGroup] = 'over';\r\n");
           $nm_saida->saida("     });\r\n");
           $nm_saida->saida("     $('#sc_btgp_div_' + sGroup + ' span a').click(function() {\r\n");
           $nm_saida->saida("       scBtnGrpStatus[sGroup] = 'out';\r\n");
           $nm_saida->saida("       scBtnGrpHide(sGroup, false);\r\n");
           $nm_saida->saida("     });\r\n");
           $nm_saida->saida("     $('#sc_btgp_div_' + sGroup).css({\r\n");
           $nm_saida->saida("       'left': btnPos.left\r\n");
           $nm_saida->saida("     })\r\n");
           $nm_saida->saida("     .mouseover(function() {\r\n");
           $nm_saida->saida("       scBtnGrpStatus[sGroup] = 'over';\r\n");
           $nm_saida->saida("     })\r\n");
           $nm_saida->saida("     .mouseleave(function() {\r\n");
           $nm_saida->saida("       scBtnGrpStatus[sGroup] = 'out';\r\n");
           $nm_saida->saida("       setTimeout(function() {\r\n");
           $nm_saida->saida("         scBtnGrpHide(sGroup, false);\r\n");
           $nm_saida->saida("       }, 1000);\r\n");
           $nm_saida->saida("     })\r\n");
           $nm_saida->saida("     .show('fast');\r\n");
           $nm_saida->saida("   }\r\n");
           $nm_saida->saida("   function scBtnGrpHide(sGroup, bForce) {\r\n");
           $nm_saida->saida("     if (bForce || 'over' != scBtnGrpStatus[sGroup]) {\r\n");
           $nm_saida->saida("       $('#sc_btgp_div_' + sGroup).hide('fast');\r\n");
           $nm_saida->saida("       $('#sc_btgp_btn_' + sGroup).removeClass('selected');\r\n");
           $nm_saida->saida("     }\r\n");
           $nm_saida->saida("   }\r\n");
           $nm_saida->saida("   </script> \r\n");
       } 
       if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['num_css']))
       {
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['num_css'] = rand(0, 1000);
       }
       $write_css = true;
       if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida_pdf']) && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida_pdf'])
       {
           $write_css = true;
       }
       if ($write_css) {$NM_css = @fopen($this->Ini->root . $this->Ini->path_imag_temp . '/sc_css_grid_jdp_beneficiohogar_detalle_grid_' . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['num_css'] . '.css', 'w');}
       if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'])
       {
           $this->NM_field_over  = 0;
           $this->NM_field_click = 0;
           $Css_sub_cons = array();
           if (($this->NM_opcao == "print" && $GLOBALS['nmgp_cor_print'] == "PB") || ($this->NM_opcao == "pdf" &&  $GLOBALS['nmgp_tipo_pdf'] == "pb") || ($_SESSION['scriptcase']['contr_link_emb'] == "pdf" &&  $GLOBALS['nmgp_tipo_pdf'] == "pb")) 
           { 
               $NM_css_file = $this->Ini->str_schema_all . "_grid_bw.css";
               $NM_css_dir  = $this->Ini->str_schema_all . "_grid_bw" . $_SESSION['scriptcase']['reg_conf']['css_dir'] . ".css";
               if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['SC_sub_css_bw'])) 
               { 
                   foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['SC_sub_css_bw'] as $Apl => $Css_apl)
                   {
                       $Css_sub_cons[] = $Css_apl;
                       $Css_sub_cons[] = str_replace(".css", $_SESSION['scriptcase']['reg_conf']['css_dir'] . ".css", $Css_apl);
                   }
               } 
           } 
           else 
           { 
               $NM_css_file = $this->Ini->str_schema_all . "_grid.css";
               $NM_css_dir  = $this->Ini->str_schema_all . "_grid" . $_SESSION['scriptcase']['reg_conf']['css_dir'] . ".css";
               if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['SC_sub_css'])) 
               { 
                   foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['SC_sub_css'] as $Apl => $Css_apl)
                   {
                       $Css_sub_cons[] = $Css_apl;
                       $Css_sub_cons[] = str_replace(".css", $_SESSION['scriptcase']['reg_conf']['css_dir'] . ".css", $Css_apl);
                   }
               } 
           } 
           if (is_file($this->Ini->path_css . $NM_css_file))
           {
               $NM_css_attr = file($this->Ini->path_css . $NM_css_file);
               foreach ($NM_css_attr as $NM_line_css)
               {
                   if (substr(trim($NM_line_css), 0, 16) == ".scGridFieldOver" && strpos($NM_line_css, "background-color:") !== false)
                   {
                       $this->NM_field_over = 1;
                   }
                   if (substr(trim($NM_line_css), 0, 17) == ".scGridFieldClick" && strpos($NM_line_css, "background-color:") !== false)
                   {
                       $this->NM_field_click = 1;
                   }
                   $NM_line_css = str_replace("../../img", $this->Ini->path_imag_cab  , $NM_line_css);
                   if ($write_css) {@fwrite($NM_css, "    " .  $NM_line_css . "\r\n");}
               }
           }
           if (is_file($this->Ini->path_css . $NM_css_dir))
           {
               $NM_css_attr = file($this->Ini->path_css . $NM_css_dir);
               foreach ($NM_css_attr as $NM_line_css)
               {
                   if (substr(trim($NM_line_css), 0, 16) == ".scGridFieldOver" && strpos($NM_line_css, "background-color:") !== false)
                   {
                       $this->NM_field_over = 1;
                   }
                   if (substr(trim($NM_line_css), 0, 17) == ".scGridFieldClick" && strpos($NM_line_css, "background-color:") !== false)
                   {
                       $this->NM_field_click = 1;
                   }
                   $NM_line_css = str_replace("../../img", $this->Ini->path_imag_cab  , $NM_line_css);
                   if ($write_css) {@fwrite($NM_css, "    " .  $NM_line_css . "\r\n");}
               }
           }
           if (!empty($Css_sub_cons))
           {
               $Css_sub_cons = array_unique($Css_sub_cons);
               foreach ($Css_sub_cons as $Cada_css_sub)
               {
                   if (is_file($this->Ini->path_css . $Cada_css_sub))
                   {
                       $compl_css = str_replace(".", "_", $Cada_css_sub);
                       $temp_css  = explode("/", $compl_css);
                       if (isset($temp_css[1])) { $compl_css = $temp_css[1];}
                       $NM_css_attr = file($this->Ini->path_css . $Cada_css_sub);
                       foreach ($NM_css_attr as $NM_line_css)
                       {
                           $NM_line_css = str_replace("../../img", $this->Ini->path_imag_cab  , $NM_line_css);
                           if ($write_css) {@fwrite($NM_css, "    ." .  $compl_css . "_" . substr(trim($NM_line_css), 1) . "\r\n");}
                       }
                   }
               }
           }
       }
       if ($write_css) {@fclose($NM_css);}
           $this->NM_css_val_embed .= "win";
           $this->NM_css_ajx_embed .= "ult_set";
 if(isset($this->Ini->str_google_fonts) && !empty($this->Ini->str_google_fonts)) 
 { 
           $nm_saida->saida("   <link rel=\"stylesheet\" href=\"" . $this->Ini->str_google_fonts . "\" />\r\n");
 } 
       if (!$write_css)
       {
           $nm_saida->saida("   <link rel=\"stylesheet\" href=\"../_lib/css/" . $this->Ini->str_schema_all . "_grid.css\" type=\"text/css\" media=\"screen\" />\r\n");
           $nm_saida->saida("   <link rel=\"stylesheet\" href=\"../_lib/css/" . $this->Ini->str_schema_all . "_grid" . $_SESSION['scriptcase']['reg_conf']['css_dir'] . ".css\" type=\"text/css\" media=\"screen\" />\r\n");
           $nm_saida->saida("   <link rel=\"stylesheet\" href=\"../_lib/css/" . $_SESSION['scriptcase']['erro']['str_schema'] . "\" type=\"text/css\" media=\"screen\" />\r\n");
           $nm_saida->saida("   <link rel=\"stylesheet\" href=\"../_lib/css/" . $_SESSION['scriptcase']['erro']['str_schema_dir'] . "\" type=\"text/css\" media=\"screen\" />\r\n");
           $nm_saida->saida("   <link rel=\"stylesheet\" href=\"../_lib/css/" . $this->Ini->str_schema_all . "_tab.css\" type=\"text/css\" media=\"screen\" />\r\n");
           $nm_saida->saida("   <link rel=\"stylesheet\" href=\"../_lib/css/" . $this->Ini->str_schema_all . "_tab" . $_SESSION['scriptcase']['reg_conf']['css_dir'] . ".css\" type=\"text/css\" media=\"screen\" />\r\n");
       }
       elseif ($this->NM_opcao == "print" || $this->Print_All)
       {
           $nm_saida->saida("  <style type=\"text/css\">\r\n");
           $NM_css = file($this->Ini->root . $this->Ini->path_imag_temp . '/sc_css_grid_jdp_beneficiohogar_detalle_grid_' . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['num_css'] . '.css');
           foreach ($NM_css as $cada_css)
           {
              $nm_saida->saida("  " . str_replace("\r\n", "", $cada_css) . "\r\n");
           }
           $nm_saida->saida("   <link rel=\"stylesheet\" href=\"../_lib/css/" . $_SESSION['scriptcase']['erro']['str_schema'] . "\" type=\"text/css\" media=\"screen\" />\r\n");
           $nm_saida->saida("   <link rel=\"stylesheet\" href=\"../_lib/css/" . $_SESSION['scriptcase']['erro']['str_schema_dir'] . "\" type=\"text/css\" media=\"screen\" />\r\n");
           $nm_saida->saida("  </style>\r\n");
       }
       else
       {
           $nm_saida->saida("   <link rel=\"stylesheet\" href=\"" . $this->Ini->path_imag_temp . "/sc_css_grid_jdp_beneficiohogar_detalle_grid_" . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['num_css'] . ".css\" type=\"text/css\" media=\"screen\" />\r\n");
           $nm_saida->saida("   <link rel=\"stylesheet\" href=\"../_lib/css/" . $_SESSION['scriptcase']['erro']['str_schema'] . "\" type=\"text/css\" media=\"screen\" />\r\n");
           $nm_saida->saida("   <link rel=\"stylesheet\" href=\"../_lib/css/" . $_SESSION['scriptcase']['erro']['str_schema_dir'] . "\" type=\"text/css\" media=\"screen\" />\r\n");
       }
       $str_iframe_body = ($this->aba_iframe) ? 'marginwidth="0px" marginheight="0px" topmargin="0px" leftmargin="0px"' : '';
       $nm_saida->saida("  <style type=\"text/css\">\r\n");
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "pdf" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida_pdf'] != "pdf")
       {
           $nm_saida->saida("  .css_iframes   { margin-bottom: 0px; margin-left: 0px;  margin-right: 0px;  margin-top: 0px; }\r\n");
       }
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "pdf" && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'])
       { 
           $nm_saida->saida("       .ttip {border:1px solid black;font-size:12px;layer-background-color:lightyellow;background-color:lightyellow;color:black;}\r\n");
       } 
       $nm_saida->saida("  </style>\r\n");
           $nm_saida->saida("   <link rel=\"stylesheet\" href=\"../_lib/css/" . $this->Ini->str_schema_all . "_btngrp.css\" type=\"text/css\" media=\"screen\" />\r\n");
           $nm_saida->saida("   <link rel=\"stylesheet\" href=\"../_lib/css/" . $this->Ini->str_schema_all . "_btngrp" . $_SESSION['scriptcase']['reg_conf']['css_dir'] . ".css\" type=\"text/css\" media=\"screen\" />\r\n");
       if (!$write_css)
       {
           $nm_saida->saida("   <link rel=\"stylesheet\" type=\"text/css\" href=\"" . $this->Ini->path_link . "grid_jdp_beneficiohogar_detalle/grid_jdp_beneficiohogar_detalle_grid_" . strtolower($_SESSION['scriptcase']['reg_conf']['css_dir']) . ".css\" />\r\n");
       }
       else
       {
           $nm_saida->saida("  <style type=\"text/css\">\r\n");
           $NM_css = file($this->Ini->root . $this->Ini->path_link . "grid_jdp_beneficiohogar_detalle/grid_jdp_beneficiohogar_detalle_grid_" .strtolower($_SESSION['scriptcase']['reg_conf']['css_dir']) . ".css");
           foreach ($NM_css as $cada_css)
           {
              $nm_saida->saida("  " . str_replace("\r\n", "", $cada_css) . "\r\n");
           }
  if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf'] || $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf_vert'])
  {
   $nm_saida->saida("      thead { display: table-header-group !important; }\r\n");
   $nm_saida->saida("      tfoot { display: table-row-group !important; }\r\n");
   $nm_saida->saida("      table td, table tr, td, tr, table { page-break-inside: avoid !important; }\r\n");
   $nm_saida->saida("      #summary_body > td { padding: 0px !important; }\r\n");
  }
           $nm_saida->saida("  </style>\r\n");
       }
       $nm_saida->saida("  </HEAD>\r\n");
   } 
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $this->Ini->nm_ger_css_emb)
   {
       $this->Ini->nm_ger_css_emb = false;
           $nm_saida->saida("  <style type=\"text/css\">\r\n");
       $NM_css = file($this->Ini->root . $this->Ini->path_link . "grid_jdp_beneficiohogar_detalle/grid_jdp_beneficiohogar_detalle_grid_" .strtolower($_SESSION['scriptcase']['reg_conf']['css_dir']) . ".css");
       foreach ($NM_css as $cada_css)
       {
           $cada_css = ".grid_jdp_beneficiohogar_detalle_" . substr($cada_css, 1);
              $nm_saida->saida("  " . str_replace("\r\n", "", $cada_css) . "\r\n");
       }
           $nm_saida->saida("  </style>\r\n");
   }
   if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'])
   { 
       if (!$this->Ini->Export_html_zip && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['doc_word'] && ($this->Print_All || $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] == "print")) 
       {
           if ($this->Print_All) 
           {
               $nm_saida->saida(" <link rel=\"stylesheet\" type=\"text/css\" href=\"../_lib/buttons/" . $this->Ini->Str_btn_css . "\" /> \r\n");
           }
           $nm_saida->saida("  <body id=\"grid_slide\" class=\"" . $this->css_scGridPage . "\" " . $str_iframe_body . " style=\"-webkit-print-color-adjust: exact;" . $css_body . "\">\r\n");
           $nm_saida->saida("   <TABLE id=\"sc_table_print\" cellspacing=0 cellpadding=0 align=\"center\" valign=\"top\" " . $this->Tab_width . ">\r\n");
           $nm_saida->saida("     <TR>\r\n");
           $nm_saida->saida("       <TD>\r\n");
           $Cod_Btn = nmButtonOutput($this->arr_buttons, "bprint", "prit_web_page()", "prit_web_page()", "Bprint_print", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
           $nm_saida->saida("           $Cod_Btn \r\n");
           $nm_saida->saida("       </TD>\r\n");
           $nm_saida->saida("     </TR>\r\n");
           $nm_saida->saida("   </TABLE>\r\n");
           $nm_saida->saida("  <script type=\"text/javascript\" src=\"../_lib/lib/js/jquery-3.6.0.min.js\"></script>\r\n");
           $nm_saida->saida("  <script type=\"text/javascript\">\r\n");
           $nm_saida->saida("     $(\"#Bprint_print\").addClass(\"disabled\").prop(\"disabled\", true);\r\n");
           $nm_saida->saida("     $(function() {\r\n");
           $nm_saida->saida("         $(\"#Bprint_print\").removeClass(\"disabled\").prop(\"disabled\", false);\r\n");
           $nm_saida->saida("     });\r\n");
           $nm_saida->saida("     function prit_web_page()\r\n");
           $nm_saida->saida("     {\r\n");
           $nm_saida->saida("        if ($(\"#Bprint_print\").prop(\"disabled\")) {\r\n");
           $nm_saida->saida("            return;\r\n");
           $nm_saida->saida("        }\r\n");
           $nm_saida->saida("        document.getElementById('sc_table_print').style.display = 'none';\r\n");
           $nm_saida->saida("        var is_safari = navigator.userAgent.indexOf(\"Safari\") > -1;\r\n");
           $nm_saida->saida("        var is_chrome = navigator.userAgent.indexOf('Chrome') > -1\r\n");
           $nm_saida->saida("        if ((is_chrome) && (is_safari)) {is_safari=false;}\r\n");
           $nm_saida->saida("        window.print();\r\n");
           $nm_saida->saida("        if (is_safari) {setTimeout(\"window.close()\", 1000);} else {window.close();}\r\n");
           $nm_saida->saida("     }\r\n");
           $nm_saida->saida("  </script>\r\n");
       }
       else
       {
          $remove_margin = isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['dashboard_info']['remove_margin']) && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['dashboard_info']['remove_margin'] ? 'margin: 0; ' : '';
          $remove_border = isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['dashboard_info']['remove_border']) && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['dashboard_info']['remove_border'] ? 'border-width: 0; ' : '';
          $vertical_center = '';
           $nm_saida->saida("  <body id=\"grid_slide\" class=\"" . $this->css_scGridPage . "\" " . $str_iframe_body . " style=\"" . $remove_margin . $vertical_center . $css_body . "\">\r\n");
       }
       $nm_saida->saida("  " . $this->Ini->Ajax_result_set . "\r\n");
       if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "pdf" && !$this->Print_All)
       { 
           $Cod_Btn = nmButtonOutput($this->arr_buttons, "berrm_clse", "nmAjaxHideDebug()", "nmAjaxHideDebug()", "", "", "", "", "", "", "", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
           $nm_saida->saida("<div id=\"id_debug_window\" style=\"display: none;\" class='scDebugWindow'><table class=\"scFormMessageTable\">\r\n");
           $nm_saida->saida("<tr><td class=\"scFormMessageTitle\">" . $Cod_Btn . "&nbsp;&nbsp;Output</td></tr>\r\n");
           $nm_saida->saida("<tr><td class=\"scFormMessageMessage\" style=\"padding: 0px; vertical-align: top\"><div style=\"padding: 2px; height: 200px; width: 350px; overflow: auto\" id=\"id_debug_text\"></div></td></tr>\r\n");
           $nm_saida->saida("</table></div>\r\n");
       } 
       if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] == "pdf" && !$this->Print_All)
       { 
           if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Ind_Groupby'] == "sc_free_total")
           {
           $nm_saida->saida("          <div style=\"height:1px;overflow:hidden\"><H1 style=\"font-size:0;padding:1px\"></H1></div>\r\n");
           }
       } 
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "pdf" && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['doc_word'])
       { 
           $nm_saida->saida("      <div id=\"tooltip\" style=\"position:absolute;visibility:hidden;border:1px solid black;font-size:12px;layer-background-color:lightyellow;background-color:lightyellow;padding:1px;color:black;\"></div>\r\n");
       } 
       $this->Tab_align  = "center";
       $this->Tab_valign = "top";
       $this->Tab_width = " width=\"100%\"";
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['pdf_res'])
       {
           return;
       } 
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "pdf" && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'])
       { 
           $this->form_navegacao();
           if ($NM_run_iframe != 1) {$this->check_btns();}
       } 
       $nm_saida->saida("   <TABLE id=\"main_table_grid\" cellspacing=0 cellpadding=0 align=\"" . $this->Tab_align . "\" valign=\"" . $this->Tab_valign . "\" " . $this->Tab_width . ">\r\n");
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf'] || $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf_vert'])
   {
   }
   else
   {
       $nm_saida->saida("     <TR>\r\n");
       $nm_saida->saida("       <TD>\r\n");
       $nm_saida->saida("       <div class=\"scGridBorder\" style=\"" . (isset($remove_border) ? $remove_border : '') . "\">\r\n");
       if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['doc_word'])
       { 
           $nm_saida->saida("  <div id=\"id_div_process\" style=\"display: none; margin: 10px; whitespace: nowrap\" class=\"scFormProcessFixed\"><span class=\"scFormProcess\"><img border=\"0\" src=\"" . $this->Ini->path_icones . "/scriptcase__NM__ajax_load.gif\" align=\"absmiddle\" />&nbsp;" . $this->Ini->Nm_lang['lang_othr_prcs'] . "...</span></div>\r\n");
           $nm_saida->saida("  <div id=\"id_div_process_block\" style=\"display: none; margin: 10px; whitespace: nowrap\"><span class=\"scFormProcess\"><img border=\"0\" src=\"" . $this->Ini->path_icones . "/scriptcase__NM__ajax_load.gif\" align=\"absmiddle\" />&nbsp;" . $this->Ini->Nm_lang['lang_othr_prcs'] . "...</span></div>\r\n");
           $nm_saida->saida("  <div id=\"id_fatal_error\" class=\"" . $this->css_scGridLabel . "\" style=\"display: none; position: absolute\"></div>\r\n");
       } 
       $nm_saida->saida("       <TABLE width='100%' cellspacing=0 cellpadding=0>\r\n");
   }
       if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "pdf" && 
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "print" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != "print") 
       { 
           $nm_saida->saida("    <TR>\r\n");
           $nm_saida->saida("    <TD  colspan=3 style=\"padding: 0px; border-width: 0px; vertical-align: top;\">\r\n");
           $nm_saida->saida("     <iframe class=\"css_iframes\" id=\"nmsc_iframe_liga_A_grid_jdp_beneficiohogar_detalle\" marginWidth=\"0px\" marginHeight=\"0px\" frameborder=\"0\" valign=\"top\" height=\"0px\" width=\"0px\" name=\"nm_iframe_liga_A_grid_jdp_beneficiohogar_detalle\" scrolling=\"auto\" src=\"NM_Blank_Page.htm\"></iframe>\r\n");
           $nm_saida->saida("    </TD>\r\n");
           $nm_saida->saida("    </TR>\r\n");
           $nm_saida->saida("    <TR>\r\n");
           $nm_saida->saida("    <TD style=\"padding: 0px; border-width: 0px; vertical-align: top;\">\r\n");
           $nm_saida->saida("     <iframe class=\"css_iframes\" id=\"nmsc_iframe_liga_E_grid_jdp_beneficiohogar_detalle\" marginWidth=\"0px\" marginHeight=\"0px\" frameborder=\"0\" valign=\"top\" height=\"0px\" width=\"0px\" name=\"nm_iframe_liga_E_grid_jdp_beneficiohogar_detalle\" scrolling=\"auto\" src=\"NM_Blank_Page.htm\"></iframe>\r\n");
           $nm_saida->saida("    </TD>\r\n");
           $nm_saida->saida("    <td style=\"padding: 0px;  vertical-align: top;\"><table style=\"padding: 0px; border-spacing: 0px; border-width: 0px; vertical-align: top;\" width=\"100%\"><tr>\r\n");
           $nm_saida->saida("    <TD colspan=3 style=\"padding: 0px; border-width: 0px; vertical-align: top;\" width=1>\r\n");
      $nm_saida->saida("     <iframe class=\"css_iframes\" id=\"nmsc_iframe_liga_AL_grid_jdp_beneficiohogar_detalle\" marginWidth=\"0px\" marginHeight=\"0px\" frameborder=\"0\" valign=\"top\" height=\"0px\" width=\"0px\" name=\"nm_iframe_liga_AL_grid_jdp_beneficiohogar_detalle\" scrolling=\"auto\" src=\"NM_Blank_Page.htm\"></iframe>\r\n");
           $nm_saida->saida("    </TD>\r\n");
           $nm_saida->saida("    </TR>\r\n");
        } 
   }  
 }  
 function NM_cor_embutida()
 {  
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_beneficiohogar_avance']['cab_embutida'] = "N";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_beneficiohogar_avance']['SC_herda_css'] = "S"; 
   $compl_css = "";
   include($this->Ini->path_btn . $this->Ini->Str_btn_grid);
   if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'])
   {
       if (is_file($this->Ini->link_grid_beneficiohogar_avance_cons_emb)) {
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_beneficiohogar_avance']['SC_herda_css'] = "S"; 
           $GLOBALS["script_case_init"] = $this->Ini->sc_page;
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_beneficiohogar_avance']['embutida'] = true;
           $_SESSION['scriptcase']['grid_beneficiohogar_avance']['protect_modal'] = $this->Ini->sc_page;
           include_once ($this->Ini->link_grid_beneficiohogar_avance_cons_emb);
           $this->grid_beneficiohogar_avance = new grid_beneficiohogar_avance_sub_css ;
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_beneficiohogar_avance']['embutida'] = false;
           unset($_SESSION['scriptcase']['grid_beneficiohogar_avance']['protect_modal']);
       }
       $this->NM_css_val_embed = "sznmxizkjnvl";
       $this->NM_css_ajx_embed = "Ajax_res";
   }
   elseif ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_herda_css'] == "N")
   {
       if (($this->NM_opcao == "print" && $GLOBALS['nmgp_cor_print'] == "PB") || ($this->NM_opcao == "pdf" &&  $GLOBALS['nmgp_tipo_pdf'] == "pb") || ($_SESSION['scriptcase']['contr_link_emb'] == "pdf" &&  $GLOBALS['nmgp_tipo_pdf'] == "pb")) 
       { 
           if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['SC_sub_css_bw']['grid_jdp_beneficiohogar_detalle']))
           {
               $compl_css = str_replace(".", "_", $_SESSION['sc_session'][$this->Ini->sc_page]['SC_sub_css_bw']['grid_jdp_beneficiohogar_detalle']) . "_";
           } 
       } 
       else 
       { 
           if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['SC_sub_css']['grid_jdp_beneficiohogar_detalle']))
           {
               $compl_css = str_replace(".", "_", $_SESSION['sc_session'][$this->Ini->sc_page]['SC_sub_css']['grid_jdp_beneficiohogar_detalle']) . "_";
           } 
       }
   }
   $temp_css  = explode("/", $compl_css);
   if (isset($temp_css[1])) { $compl_css = $temp_css[1];}
   $this->css_scGridPage           = $compl_css . "scGridPage";
   $this->css_scGridPageLink       = $compl_css . "scGridPageLink";
   $this->css_scGridToolbar        = $compl_css . "scGridToolbar";
   $this->css_scGridToolbarPadd    = $compl_css . "scGridToolbarPadding";
   $this->css_css_toolbar_obj      = $compl_css . "css_toolbar_obj";
   $this->css_scGridHeader         = $compl_css . "scGridHeader";
   $this->css_scGridHeaderFont     = $compl_css . "scGridHeaderFont";
   $this->css_scGridFooter         = $compl_css . "scGridFooter";
   $this->css_scGridFooterFont     = $compl_css . "scGridFooterFont";
   $this->css_scGridBlock          = $compl_css . "scGridBlock";
   $this->css_scGridBlockFont      = $compl_css . "scGridBlockFont";
   $this->css_scGridBlockAlign     = $compl_css . "scGridBlockAlign";
   $this->css_scGridTotal          = $compl_css . "scGridTotal";
   $this->css_scGridTotalFont      = $compl_css . "scGridTotalFont";
   $this->css_scGridSubtotal       = $compl_css . "scGridSubtotal";
   $this->css_scGridSubtotalFont   = $compl_css . "scGridSubtotalFont";
   $this->css_scGridFieldEven      = $compl_css . "scGridFieldEven";
   $this->css_scGridFieldEvenFont  = $compl_css . "scGridFieldEvenFont";
   $this->css_scGridFieldEvenVert  = $compl_css . "scGridFieldEvenVert";
   $this->css_scGridFieldEvenLink  = $compl_css . "scGridFieldEvenLink";
   $this->css_scGridFieldOdd       = $compl_css . "scGridFieldOdd";
   $this->css_scGridFieldOddFont   = $compl_css . "scGridFieldOddFont";
   $this->css_scGridFieldOddVert   = $compl_css . "scGridFieldOddVert";
   $this->css_scGridFieldOddLink   = $compl_css . "scGridFieldOddLink";
   $this->css_scGridFieldClick     = $compl_css . "scGridFieldClick";
   $this->css_scGridFieldOver      = $compl_css . "scGridFieldOver";
   $this->css_scGridLabel          = $compl_css . "scGridLabel";
   $this->css_scGridLabelVert      = $compl_css . "scGridLabelVert";
   $this->css_scGridLabelFont      = $compl_css . "scGridLabelFont";
   $this->css_scGridLabelLink      = $compl_css . "scGridLabelLink";
   $this->css_scGridTabela         = $compl_css . "scGridTabela";
   $this->css_scGridTabelaTd       = $compl_css . "scGridTabelaTd";
   $this->css_scGridBlockBg        = $compl_css . "scGridBlockBg";
   $this->css_scGridBlockLineBg    = $compl_css . "scGridBlockLineBg";
   $this->css_scGridBlockSpaceBg   = $compl_css . "scGridBlockSpaceBg";
   $this->css_scGridLabelNowrap    = "";
   $this->css_scAppDivMoldura      = $compl_css . "scAppDivMoldura";
   $this->css_scAppDivHeader       = $compl_css . "scAppDivHeader";
   $this->css_scAppDivHeaderText   = $compl_css . "scAppDivHeaderText";
   $this->css_scAppDivContent      = $compl_css . "scAppDivContent";
   $this->css_scAppDivContentText  = $compl_css . "scAppDivContentText";
   $this->css_scAppDivToolbar      = $compl_css . "scAppDivToolbar";
   $this->css_scAppDivToolbarInput = $compl_css . "scAppDivToolbarInput";
   $this->css_inherit_bg           = "scInheritBg";

   $compl_css_emb = ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida']) ? "grid_jdp_beneficiohogar_detalle_" : "";
   $this->css_sep = " ";
   $this->css_sc_field_0_label = $compl_css_emb . "css_sc_field_0_label";
   $this->css_sc_field_0_grid_line = $compl_css_emb . "css_sc_field_0_grid_line";
   $this->css_pl_codsocio_label = $compl_css_emb . "css_pl_codsocio_label";
   $this->css_pl_codsocio_grid_line = $compl_css_emb . "css_pl_codsocio_grid_line";
   $this->css_ac_nombre_label = $compl_css_emb . "css_ac_nombre_label";
   $this->css_ac_nombre_grid_line = $compl_css_emb . "css_ac_nombre_grid_line";
   $this->css_suba_nombre_label = $compl_css_emb . "css_suba_nombre_label";
   $this->css_suba_nombre_grid_line = $compl_css_emb . "css_suba_nombre_grid_line";
   $this->css_pl_fechainicio_label = $compl_css_emb . "css_pl_fechainicio_label";
   $this->css_pl_fechainicio_grid_line = $compl_css_emb . "css_pl_fechainicio_grid_line";
   $this->css_pl_fechafin_label = $compl_css_emb . "css_pl_fechafin_label";
   $this->css_pl_fechafin_grid_line = $compl_css_emb . "css_pl_fechafin_grid_line";
   $this->css_pl_detalle_label = $compl_css_emb . "css_pl_detalle_label";
   $this->css_pl_detalle_grid_line = $compl_css_emb . "css_pl_detalle_grid_line";
   $this->css_unidad_label = $compl_css_emb . "css_unidad_label";
   $this->css_unidad_grid_line = $compl_css_emb . "css_unidad_grid_line";
   $this->css_sc_field_1_label = $compl_css_emb . "css_sc_field_1_label";
   $this->css_sc_field_1_grid_line = $compl_css_emb . "css_sc_field_1_grid_line";
   $this->css_sc_field_2_label = $compl_css_emb . "css_sc_field_2_label";
   $this->css_sc_field_2_grid_line = $compl_css_emb . "css_sc_field_2_grid_line";
   $this->css_emergencia_label = $compl_css_emb . "css_emergencia_label";
   $this->css_emergencia_grid_line = $compl_css_emb . "css_emergencia_grid_line";
   $this->css_sc_field_3_label = $compl_css_emb . "css_sc_field_3_label";
   $this->css_sc_field_3_grid_line = $compl_css_emb . "css_sc_field_3_grid_line";
   $this->css_indicador_label = $compl_css_emb . "css_indicador_label";
   $this->css_indicador_grid_line = $compl_css_emb . "css_indicador_grid_line";
   $this->css_departamento_label = $compl_css_emb . "css_departamento_label";
   $this->css_departamento_grid_line = $compl_css_emb . "css_departamento_grid_line";
   $this->css_municipio_label = $compl_css_emb . "css_municipio_label";
   $this->css_municipio_grid_line = $compl_css_emb . "css_municipio_grid_line";
   $this->css_comunidad_label = $compl_css_emb . "css_comunidad_label";
   $this->css_comunidad_grid_line = $compl_css_emb . "css_comunidad_grid_line";
   $this->css_pl_colonia_label = $compl_css_emb . "css_pl_colonia_label";
   $this->css_pl_colonia_grid_line = $compl_css_emb . "css_pl_colonia_grid_line";
   $this->css_estado_label = $compl_css_emb . "css_estado_label";
   $this->css_estado_grid_line = $compl_css_emb . "css_estado_grid_line";
   $this->css_sc_field_5_label = $compl_css_emb . "css_sc_field_5_label";
   $this->css_sc_field_5_grid_line = $compl_css_emb . "css_sc_field_5_grid_line";
   $this->css_sc_field_6_label = $compl_css_emb . "css_sc_field_6_label";
   $this->css_sc_field_6_grid_line = $compl_css_emb . "css_sc_field_6_grid_line";
   $this->css_pl_informacioncualitativa_label = $compl_css_emb . "css_pl_informacioncualitativa_label";
   $this->css_pl_informacioncualitativa_grid_line = $compl_css_emb . "css_pl_informacioncualitativa_grid_line";
   $this->css_pl_observacionesadicionales_label = $compl_css_emb . "css_pl_observacionesadicionales_label";
   $this->css_pl_observacionesadicionales_grid_line = $compl_css_emb . "css_pl_observacionesadicionales_grid_line";
   $this->css_sc_field_4_label = $compl_css_emb . "css_sc_field_4_label";
   $this->css_sc_field_4_grid_line = $compl_css_emb . "css_sc_field_4_grid_line";
   $this->css_mediosdeverificacion_label = $compl_css_emb . "css_mediosdeverificacion_label";
   $this->css_mediosdeverificacion_grid_line = $compl_css_emb . "css_mediosdeverificacion_grid_line";
   $this->css_sc_field_7_label = $compl_css_emb . "css_sc_field_7_label";
   $this->css_sc_field_7_grid_line = $compl_css_emb . "css_sc_field_7_grid_line";
   $this->css_avance_label = $compl_css_emb . "css_avance_label";
   $this->css_avance_grid_line = $compl_css_emb . "css_avance_grid_line";
   $this->css_beneficiarios_label = $compl_css_emb . "css_beneficiarios_label";
   $this->css_beneficiarios_grid_line = $compl_css_emb . "css_beneficiarios_grid_line";
 }  
 function cabecalho()
 {
     if($_SESSION['scriptcase']['proc_mobile'] && method_exists($this, 'cabecalho_mobile'))
     {
         $this->cabecalho_mobile();
     }
     else if(method_exists($this, 'cabecalho_normal'))
     {
         $this->cabecalho_normal();
     }
 }
// 
//----- 
 function cabecalho_normal()
 {
   global
          $nm_saida;
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['dashboard_info']['under_dashboard'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['dashboard_info']['compact_mode'] && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['dashboard_info']['maximized'])
   {
       return; 
   }
   if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_liga']['cab']))
   {
       return; 
   }
   $nm_cab_filtro   = ""; 
   $nm_cab_filtrobr = ""; 
   $Str_date = strtolower($_SESSION['scriptcase']['reg_conf']['date_format']);
   $Lim   = strlen($Str_date);
   $Ult   = "";
   $Arr_D = array();
   for ($I = 0; $I < $Lim; $I++)
   {
       $Char = substr($Str_date, $I, 1);
       if ($Char != $Ult)
       {
           $Arr_D[] = $Char;
       }
       $Ult = $Char;
   }
   $Prim = true;
   $Str  = "";
   foreach ($Arr_D as $Cada_d)
   {
       $Str .= (!$Prim) ? $_SESSION['scriptcase']['reg_conf']['date_sep'] : "";
       $Str .= $Cada_d;
       $Prim = false;
   }
   $Str = str_replace("a", "Y", $Str);
   $Str = str_replace("y", "Y", $Str);
   $nm_data_fixa = date($Str); 
   $this->sc_proc_grid = false; 
   $HTTP_REFERER = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : ""; 
   $this->sc_where_orig   = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['where_orig'];
   $this->sc_where_atual  = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['where_pesq'];
   $this->sc_where_filtro = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['where_pesq_filtro'];
   if (!empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['cond_pesq']))
   {  
       $pos       = 0;
       $trab_pos  = false;
       $pos_tmp   = true; 
       $tmp       = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['cond_pesq'];
       while ($pos_tmp)
       {
          $pos = strpos($tmp, "##*@@", $pos);
          if ($pos !== false)
          {
              $trab_pos = $pos;
              $pos += 4;
          }
          else
          {
              $pos_tmp = false;
          }
       }
       $nm_cond_filtro_or  = (substr($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['cond_pesq'], $trab_pos + 5) == "or")  ? " " . trim($this->Ini->Nm_lang['lang_srch_orr_cond']) . " " : "";
       $nm_cond_filtro_and = (substr($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['cond_pesq'], $trab_pos + 5) == "and") ? " " . trim($this->Ini->Nm_lang['lang_srch_and_cond']) . " " : "";
       $nm_cab_filtro   = substr($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['cond_pesq'], 0, $trab_pos);
       $nm_cab_filtrobr = str_replace("##*@@", ", " . $nm_cond_filtro_or . $nm_cond_filtro_and . "<br />", $nm_cab_filtro);
       $pos       = 0;
       $trab_pos  = false;
       $pos_tmp   = true; 
       $tmp       = $nm_cab_filtro;
       while ($pos_tmp)
       {
          $pos = strpos($tmp, "##*@@", $pos);
          if ($pos !== false)
          {
              $trab_pos = $pos;
              $pos += 4;
          }
          else
          {
              $pos_tmp = false;
          }
       }
       if ($trab_pos === false)
       {
       }
       else  
       {  
          $nm_cab_filtro = substr($nm_cab_filtro, 0, $trab_pos) . " " .  $nm_cond_filtro_or . $nm_cond_filtro_and . substr($nm_cab_filtro, $trab_pos + 5);
          $nm_cab_filtro = str_replace("##*@@", ", " . $nm_cond_filtro_or . $nm_cond_filtro_and, $nm_cab_filtro);
       }   
   }   
   $this->nm_data->SetaData(date("Y/m/d H:i:s"), "YYYY/MM/DD HH:II:SS"); 
   $nm_saida->saida(" <TR id=\"sc_grid_head\">\r\n");
   if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['sv_dt_head']))
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['sv_dt_head'] = array();
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['sv_dt_head']['fix'] = $nm_data_fixa;
       $nm_refresch_cab_rod = true;
   } 
   else 
   { 
       $nm_refresch_cab_rod = false;
   } 
   foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['sv_dt_head'] as $ind => $val)
   {
       $tmp_var = "sc_data_cab" . $ind;
       if ($$tmp_var != $val)
       {
           $nm_refresch_cab_rod = true;
           break;
       }
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['sv_dt_head']['fix'] != $nm_data_fixa)
   {
       $nm_refresch_cab_rod = true;
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'] && $nm_refresch_cab_rod)
   { 
       $_SESSION['scriptcase']['saida_html'] = "";
   } 
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['sv_dt_head']['fix'] = $nm_data_fixa;
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "pdf")
   { 
       $nm_saida->saida("  <TD class=\"" . $this->css_scGridTabelaTd . " " . $this->css_scGridPage . "\" colspan=3 style=\"vertical-align: top\">\r\n");
   } 
   else 
   { 
     if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf']) 
     { 
         $this->NM_calc_span();
           $nm_saida->saida("   <TD colspan=\"" . $this->NM_colspan . "\" class=\"" . $this->css_scGridTabelaTd . "\" style=\"vertical-align: top\">\r\n");
     } 
     else if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf_vert']) 
     {
         if($this->Tem_tab_vert)
         {
           $nm_saida->saida("   <TD colspan=\"2\" class=\"" . $this->css_scGridTabelaTd . "\" style=\"vertical-align: top\">\r\n");
         }
         else{
           $nm_saida->saida("   <TD class=\"" . $this->css_scGridTabelaTd . "\" style=\"vertical-align: top\">\r\n");
         }
     }
     else{
           $nm_saida->saida("  <TD class=\"" . $this->css_scGridTabelaTd . "\" style=\"vertical-align: top\">\r\n");
     }
   } 
   $nm_saida->saida("<style>\r\n");
   $nm_saida->saida("    .scMenuTHeaderFont img, .scGridHeaderFont img , .scFormHeaderFont img , .scTabHeaderFont img , .scContainerHeaderFont img , .scFilterHeaderFont img { height:23px;}\r\n");
   $nm_saida->saida("</style>\r\n");
   $nm_saida->saida("<div class=\"" . $this->css_scGridHeader . "\" style=\"height: 54px; padding: 17px 15px; box-sizing: border-box;margin: -1px 0px 0px 0px;width: 100%;\">\r\n");
   $nm_saida->saida("    <div class=\"" . $this->css_scGridHeaderFont . "\" style=\"float: left; text-transform: uppercase;\">" . $this->Ini->Nm_lang['lang_othr_grid_title'] . " Actividades</div>\r\n");
   $nm_saida->saida("    <div class=\"" . $this->css_scGridHeaderFont . "\" style=\"float: right;\">" . $nm_data_fixa . "</div>\r\n");
   $nm_saida->saida("</div>\r\n");
   $nm_saida->saida("  </TD>\r\n");
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'] && $nm_refresch_cab_rod)
   { 
       $this->Ini->Arr_result['setValue'][] = array('field' => 'sc_grid_head', 'value' => NM_charset_to_utf8($_SESSION['scriptcase']['saida_html']));
       $_SESSION['scriptcase']['saida_html'] = "";
   } 
   $nm_saida->saida(" </TR>\r\n");
 }
    function scGetColumnOrderRule($fieldName)
    {
        $sortRule = 'nosort';
        if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_cmp'] == $fieldName) {
            if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_label'] == 'desc') {
                $sortRule = 'desc';
            } else {
                $sortRule = 'asc';
            }
        }
        return $sortRule;
    }

    function scGetColumnOrderIcon($fieldName, $sortRule)
    {        if ('desc' == $sortRule) {
            return "<img src=\"" . $this->Ini->path_img_global . "/" . $this->Ini->Label_sort_desc . "\" />";
        } elseif ('asc' == $sortRule) {
            return "<img src=\"" . $this->Ini->path_img_global . "/" . $this->Ini->Label_sort_asc . "\" />";
        } elseif ('' != $this->Ini->Label_sort) {
            return "<img src=\"" . $this->Ini->path_img_global . "/" . $this->Ini->Label_sort . "\" />";
        } else {
            return '';
        }
    }

    function scIsFieldNumeric($fieldName)
    {
        switch ($fieldName) {
            case "sc_field_4":
                return true;
            case "sc_field_7":
                return true;
            case "pl_idplanificacion":
                return true;
            case "p_idproyecto":
                return true;
        }
        return false;
    }

    function scGetDefaultFieldOrder($fieldName)
    {
        switch ($fieldName) {
            case "pl_fechainicio":
                return 'desc';
            case "pl_fechafin":
                return 'desc';
            case "sc_field_5":
                return 'desc';
            case "sc_field_6":
                return 'desc';
            case "sc_field_4":
                return 'desc';
            case "sc_field_7":
                return 'desc';
            case "pl_idplanificacion":
                return 'desc';
            case "p_idproyecto":
                return 'desc';
        }
        return 'asc';
    }

// 
//----- 
 function grid($linhas = 0)
 {
    global 
           $nm_tem_quebra,
           $nm_saida;
   $fecha_tr               = "</tr>";
   $this->Ini->qual_linha  = "par";
   $HTTP_REFERER = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : ""; 
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['rows_emb'] = 0;
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'])
   {
       if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ini_cor_grid']) && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ini_cor_grid'] == "impar")
       {
           $this->Ini->qual_linha = "impar";
           unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ini_cor_grid']);
       }
   }
   static $nm_seq_execucoes = 0; 
   static $nm_seq_titulos   = 0; 
   $this->SC_ancora = "";
   $this->Rows_span = 1;
   $nm_seq_execucoes++; 
   $nm_seq_titulos++; 
   $this->nm_prim_linha  = true; 
   $this->Ini->nm_cont_lin = 0; 
   $this->sc_where_orig    = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['where_orig'];
   $this->sc_where_atual   = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['where_pesq'];
   $this->sc_where_filtro  = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['where_pesq_filtro'];
// 
   $SC_Label = (isset($this->New_label['sc_field_0'])) ? $this->New_label['sc_field_0'] : "Código de Proyecto";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['labels']['sc_field_0'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['pl_codsocio'])) ? $this->New_label['pl_codsocio'] : "Cod Socio";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['labels']['pl_codsocio'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['ac_nombre'])) ? $this->New_label['ac_nombre'] : "Actividad";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['labels']['ac_nombre'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['suba_nombre'])) ? $this->New_label['suba_nombre'] : "Sub Actividad";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['labels']['suba_nombre'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['pl_fechainicio'])) ? $this->New_label['pl_fechainicio'] : "Fecha Inicio";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['labels']['pl_fechainicio'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['pl_fechafin'])) ? $this->New_label['pl_fechafin'] : "Fecha Fin";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['labels']['pl_fechafin'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['pl_detalle'])) ? $this->New_label['pl_detalle'] : "Detalle";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['labels']['pl_detalle'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['unidad'])) ? $this->New_label['unidad'] : "Unidad";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['labels']['unidad'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['sc_field_1'])) ? $this->New_label['sc_field_1'] : "Frecuencia De Entrega";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['labels']['sc_field_1'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['sc_field_2'])) ? $this->New_label['sc_field_2'] : "Tipo De Entrega";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['labels']['sc_field_2'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['emergencia'])) ? $this->New_label['emergencia'] : "Emergencia";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['labels']['emergencia'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['sc_field_3'])) ? $this->New_label['sc_field_3'] : "Grupo De Beneficiarios";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['labels']['sc_field_3'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['indicador'])) ? $this->New_label['indicador'] : "Indicador";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['labels']['indicador'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['departamento'])) ? $this->New_label['departamento'] : "Departamento";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['labels']['departamento'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['municipio'])) ? $this->New_label['municipio'] : "Municipio";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['labels']['municipio'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['comunidad'])) ? $this->New_label['comunidad'] : "Comunidad";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['labels']['comunidad'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['pl_colonia'])) ? $this->New_label['pl_colonia'] : "Colonia";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['labels']['pl_colonia'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['estado'])) ? $this->New_label['estado'] : "Estado";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['labels']['estado'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['sc_field_5'])) ? $this->New_label['sc_field_5'] : "Fecha Inicio Actividad";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['labels']['sc_field_5'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['sc_field_6'])) ? $this->New_label['sc_field_6'] : "Fecha Fin Actividad";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['labels']['sc_field_6'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['pl_informacioncualitativa'])) ? $this->New_label['pl_informacioncualitativa'] : "Informacion Cualitativa";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['labels']['pl_informacioncualitativa'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['pl_observacionesadicionales'])) ? $this->New_label['pl_observacionesadicionales'] : "Observaciones Adicionales";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['labels']['pl_observacionesadicionales'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['sc_field_4'])) ? $this->New_label['sc_field_4'] : "Cantidad Estimada Beneficiarios Idirectos";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['labels']['sc_field_4'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['mediosdeverificacion'])) ? $this->New_label['mediosdeverificacion'] : "VER MEDIOS DE VERIFICACIÓN";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['labels']['mediosdeverificacion'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['sc_field_7'])) ? $this->New_label['sc_field_7'] : "Valor APR";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['labels']['sc_field_7'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['avance'])) ? $this->New_label['avance'] : "AVANCE";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['labels']['avance'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['beneficiarios'])) ? $this->New_label['beneficiarios'] : "VER INGRESOS";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['labels']['beneficiarios'] = $SC_Label; 
   if (!$this->grid_emb_form && isset($_SESSION['scriptcase']['sc_apl_conf']['grid_jdp_beneficiohogar_detalle']['lig_edit']) && $_SESSION['scriptcase']['sc_apl_conf']['grid_jdp_beneficiohogar_detalle']['lig_edit'] != '')
   {
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['mostra_edit'] = $_SESSION['scriptcase']['sc_apl_conf']['grid_jdp_beneficiohogar_detalle']['lig_edit'];
   }
   if (!empty($this->nm_grid_sem_reg))
   {
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'])
       {
           $this->Lin_impressas++;
           if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida_grid'])
           {
               if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['cols_emb']) || empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['cols_emb']))
               {
                   $cont_col = 0;
                   foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['field_order'] as $cada_field)
                   {
                       $cont_col++;
                   }
                   $NM_span_sem_reg = $cont_col - 1;
               }
               else
               {
                   $NM_span_sem_reg  = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['cols_emb'];
               }
               $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['rows_emb']++;
               $nm_saida->saida("  <TR> <TD class=\"" . $this->css_scGridTabelaTd . " " . "\" colspan = \"$NM_span_sem_reg\" align=\"center\" style=\"vertical-align: top;font-family:" . $this->Ini->texto_fonte_tipo_impar . ";font-size:12px;\">\r\n");
               $nm_saida->saida("     " . $this->nm_grid_sem_reg . "</TD> </TR>\r\n");
               $nm_saida->saida("##NM@@\r\n");
               $this->rs_grid->Close();
           }
           else
           {
               $nm_saida->saida("<table id=\"apl_grid_jdp_beneficiohogar_detalle#?#$nm_seq_execucoes\" width=\"100%\" style=\"padding: 0px; border-spacing: 0px; border-width: 0px; vertical-align: top;\">\r\n");
               $nm_saida->saida("  <tr><td class=\"" . $this->css_scGridTabelaTd . " " . "\" style=\"font-family:" . $this->Ini->texto_fonte_tipo_impar . ";font-size:12px;\"><table style=\"padding: 0px; border-spacing: 0px; border-width: 0px; vertical-align: top;\" width=\"100%\">\r\n");
               $nm_id_aplicacao = "";
               $nm_saida->saida("  <tr><td class=\"" . $this->css_scGridFieldOdd . "\"  style=\"padding: 0px; font-family:" . $this->Ini->texto_fonte_tipo_impar . ";font-size:12px;\" colspan = \"27\" align=\"center\">\r\n");
               $nm_saida->saida("     " . $this->nm_grid_sem_reg . "\r\n");
               $nm_saida->saida("  </td></tr>\r\n");
               $nm_saida->saida("  </table></td></tr></table>\r\n");
               $this->Lin_final = $this->rs_grid->EOF;
               if ($this->Lin_final)
               {
                   $this->rs_grid->Close();
               }
           }
       }
       else
       {
           $nm_saida->saida(" <TR> \r\n");
           if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "pdf" && 
               $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "print" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != "print") 
           { 
           $nm_saida->saida("    <TD >\r\n");
           $nm_saida->saida("    <TABLE cellspacing=0 cellpadding=0 width='100%'>\r\n");
               $nm_saida->saida("    <TD style=\"padding: 0px; border-width: 0px; vertical-align: top;\" width=1>\r\n");
      $nm_saida->saida("     <iframe class=\"css_iframes\" id=\"nmsc_iframe_liga_EL_grid_jdp_beneficiohogar_detalle\" marginWidth=\"0px\" marginHeight=\"0px\" frameborder=\"0\" valign=\"top\" height=\"0px\" width=\"0px\" name=\"nm_iframe_liga_EL_grid_jdp_beneficiohogar_detalle\" scrolling=\"auto\" src=\"NM_Blank_Page.htm\"></iframe>\r\n");
               $nm_saida->saida("    </TD>\r\n");
               $nm_saida->saida("    <TD style=\"padding: 0px; border-width: 0px; vertical-align: top;\"><TABLE style=\"padding: 0px; border-spacing: 0px; border-width: 0px;\" width=\"100%\"><TR>\r\n");
           } 
           $nm_saida->saida("  <td " . $this->Grid_body . " class=\"" . $this->css_scGridTabelaTd . " " . $this->css_scGridFieldOdd . "\" align=\"center\" style=\"vertical-align: top;font-family:" . $this->Ini->texto_fonte_tipo_impar . ";font-size:12px;\">\r\n");
           if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['force_toolbar']))
           { 
               $this->force_toolbar = true;
               $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['force_toolbar'] = true;
           } 
           if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
           { 
               $_SESSION['scriptcase']['saida_html'] = "";
           } 
           $nm_saida->saida("  " . $this->nm_grid_sem_reg . "\r\n");
           if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
           { 
               $this->Ini->Arr_result['setValue'][] = array('field' => 'sc_grid_body', 'value' => NM_charset_to_utf8($_SESSION['scriptcase']['saida_html']));
               $this->Ini->Arr_result['setSrc'][] = array('field' => 'nmsc_iframe_liga_A_grid_jdp_beneficiohogar_detalle', 'value' => 'NM_Blank_Page.htm');
               $this->Ini->Arr_result['setSrc'][] = array('field' => 'nmsc_iframe_liga_D_grid_jdp_beneficiohogar_detalle', 'value' => 'NM_Blank_Page.htm');
               $this->Ini->Arr_result['setSrc'][] = array('field' => 'nmsc_iframe_liga_E_grid_jdp_beneficiohogar_detalle', 'value' => 'NM_Blank_Page.htm');
               $_SESSION['scriptcase']['saida_html'] = "";
           } 
           $nm_saida->saida("  </td></tr>\r\n");
           if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "pdf" &&
               $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "print" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != "print") 
           { 
               $nm_saida->saida("</TABLE></TD>\r\n");
               $nm_saida->saida("<TD style=\"padding: 0px; border-width: 0px;\" valign=\"top\" width=1>\r\n");
      $nm_saida->saida("     <iframe class=\"css_iframes\" id=\"nmsc_iframe_liga_DL_grid_jdp_beneficiohogar_detalle\" marginWidth=\"0px\" marginHeight=\"0px\" frameborder=\"0\" valign=\"top\" height=\"0px\" width=\"0px\" name=\"nm_iframe_liga_DL_grid_jdp_beneficiohogar_detalle\" scrolling=\"auto\" src=\"NM_Blank_Page.htm\"></iframe>\r\n");
               $nm_saida->saida("</TD>\r\n");
               $nm_saida->saida("    <TD style=\"padding: 0px; border-width: 0px; vertical-align: top;\">\r\n");
               $nm_saida->saida("     <iframe class=\"css_iframes\" id=\"nmsc_iframe_liga_D_grid_jdp_beneficiohogar_detalle\" marginWidth=\"0px\" marginHeight=\"0px\" frameborder=\"0\" valign=\"top\" height=\"0px\" width=\"0px\" name=\"nm_iframe_liga_D_grid_jdp_beneficiohogar_detalle\" scrolling=\"auto\" src=\"NM_Blank_Page.htm\"></iframe>\r\n");
               $nm_saida->saida("    </TD>\r\n");
               $nm_saida->saida("    </TR>\r\n");
           } 
       $nm_saida->saida("</TABLE>\r\n");
       }
       return;
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'])
   { 
       $nm_saida->saida("<table id=\"apl_grid_jdp_beneficiohogar_detalle#?#$nm_seq_execucoes\" width=\"100%\" style=\"padding: 0px; border-spacing: 0px; border-width: 0px; vertical-align: top;\">\r\n");
       $nm_saida->saida(" <TR> \r\n");
       $nm_id_aplicacao = "";
   } 
   else 
   { 
if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf'])
{
}
else
{
       $nm_saida->saida("    <TR> \r\n");
}
       if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "pdf" && 
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "print" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != "print") 
       { 
           $nm_saida->saida("    <TD  colspan=3>\r\n");
           $nm_saida->saida("    <TABLE cellspacing=0 cellpadding=0 width='100%'>\r\n");
           $nm_saida->saida("    <TD style=\"padding: 0px; border-width: 0px; vertical-align: top;\" width=1>\r\n");
      $nm_saida->saida("     <iframe class=\"css_iframes\" id=\"nmsc_iframe_liga_EL_grid_jdp_beneficiohogar_detalle\" marginWidth=\"0px\" marginHeight=\"0px\" frameborder=\"0\" valign=\"top\" height=\"0px\" width=\"0px\" name=\"nm_iframe_liga_EL_grid_jdp_beneficiohogar_detalle\" scrolling=\"auto\" src=\"NM_Blank_Page.htm\"></iframe>\r\n");
           $nm_saida->saida("    </TD>\r\n");
           $nm_saida->saida("    <TD style=\"padding: 0px; border-width: 0px; vertical-align: top;\"><TABLE style=\"padding: 0px; border-spacing: 0px; border-width: 0px;\" width=\"100%\"><TR>\r\n");
       } 
       $nm_id_aplicacao = " id=\"apl_grid_jdp_beneficiohogar_detalle#?#1\"";
   } 
   $TD_padding = (!$this->Print_All && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] == "pdf") ? "padding: 0px !important;" : "";
if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf'] || $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf_vert'])
{
}
else
{
   $nm_saida->saida("  <TD " . $this->Grid_body . " class=\"" . $this->css_scGridTabelaTd . "\" style=\"vertical-align: top;text-align: center;" . $TD_padding . "\" width=\"100%\">\r\n");
}
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
   { 
       $_SESSION['scriptcase']['saida_html'] = "";
   } 
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_psq'])
   { 
       $nm_saida->saida("        <div id=\"div_FBtn_Run\" style=\"display: none\"> \r\n");
       $nm_saida->saida("        <form name=\"Fpesq\" method=post>\r\n");
       $nm_saida->saida("         <input type=hidden name=\"nm_ret_psq\"> \r\n");
       $nm_saida->saida("        </div> \r\n");
   } 
if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf'] || $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf_vert'] )
{
}
else
{
   $nm_saida->saida("    <TABLE class=\"" . $this->css_scGridTabela . "\" id=\"sc-ui-grid-body-deadf598\" align=\"center\" width=\"100%\">\r\n");
}
if (($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf'] || $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf_vert']) && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] )
{
    if ($this->pdf_all_cab == "S") {
    $nm_saida->saida("              <thead>\r\n");
        $this->cabecalho();
    $nm_saida->saida("              </thead>\r\n");
    }
    else {
        $this->cabecalho();
    }
}
// 
   $nm_quant_linhas = 0 ;
   $this->nm_inicio_pag = 0;
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] == "pdf")
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['final'] = 0;
   } 
   $this->nmgp_prim_pag_pdf = true;
   $this->Break_pag_pdf = array();
   $this->Break_pag_prt = array();
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['Config_Page_break_PDF'] = "S";
   if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['Page_break_PDF']))
   {
       if (isset($this->Break_pag_pdf[$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Ind_Groupby']]))
       {
           if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Ind_Groupby'] == "sc_free_group_by")
           {
               foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Gb_Free_cmp'] as $Cmp_gb => $resto)
               {
                   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['Page_break_PDF'][$Cmp_gb] = $this->Break_pag_pdf['sc_free_group_by'][$Cmp_gb];
               }
           }
           else
           {
               $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['Page_break_PDF'] = $this->Break_pag_pdf[$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Ind_Groupby']];
           }
       }
       else
       {
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['Page_break_PDF'] = array();
       }
   }
   $this->Ini->cor_link_dados = $this->css_scGridFieldEvenLink;
   $this->NM_flag_antigo = FALSE;
   $nm_prog_barr = 0;
   $PB_tot       = "/" . $this->count_ger;;
   $this->nm_contr_album = 0;
   while (!$this->rs_grid->EOF && $nm_quant_linhas < $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_reg_grid'] && ($linhas == 0 || $linhas > $this->Lin_impressas)) 
   {  
          $this->NM_field_color = array();
          $this->NM_field_style = array();
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['doc_word'] && !$this->Ini->sc_export_ajax)
          {
              $nm_prog_barr++;
              $Mens_bar = $this->Ini->Nm_lang['lang_othr_prcs'];
              if ($_SESSION['scriptcase']['charset'] != "UTF-8") {
                  $Mens_bar = sc_convert_encoding($Mens_bar, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $this->pb->setProgressbarMessage($Mens_bar . ": " . $nm_prog_barr . $PB_tot);
              $this->pb->addSteps(1);
          }
          if ($this->Ini->Proc_print && $this->Ini->Export_html_zip  && !$this->Ini->sc_export_ajax)
          {
              $nm_prog_barr++;
              $Mens_bar = $this->Ini->Nm_lang['lang_othr_prcs'];
              if ($_SESSION['scriptcase']['charset'] != "UTF-8") {
                  $Mens_bar = sc_convert_encoding($Mens_bar, "UTF-8", $_SESSION['scriptcase']['charset']);
              }
              $this->pb->setProgressbarMessage($Mens_bar . ": " . $nm_prog_barr . $PB_tot);
              $this->pb->addSteps(1);
          }
          //---------- Gauge ----------
          if (!$this->Ini->sc_export_ajax && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] == "pdf" && -1 < $this->progress_grid)
          {
              $this->progress_now++;
              if (0 == $this->progress_lim_now)
              {
               $lang_protect = $this->Ini->Nm_lang['lang_pdff_rows'];
               if (!NM_is_utf8($lang_protect))
               {
                   $lang_protect = sc_convert_encoding($lang_protect, "UTF-8", $_SESSION['scriptcase']['charset']);
               }
                  grid_jdp_beneficiohogar_detalle_pdf_progress_call($this->progress_tot . "_#NM#_" . $this->progress_now . "_#NM#_" . $lang_protect . " " . $this->progress_now . "...\n", $this->Ini->Nm_lang);
                  fwrite($this->progress_fp, $this->progress_now . "_#NM#_" . $lang_protect . " " . $this->progress_now . "...\n");
              }
              $this->progress_lim_now++;
              if ($this->progress_lim_tot == $this->progress_lim_now)
              {
                  $this->progress_lim_now = 0;
              }
          }
          $this->Lin_impressas++;
          $this->sc_field_0 = $this->rs_grid->fields[0] ;  
          $this->pl_codsocio = $this->rs_grid->fields[1] ;  
          $this->ac_nombre = $this->rs_grid->fields[2] ;  
          $this->suba_nombre = $this->rs_grid->fields[3] ;  
          $this->pl_fechainicio = $this->rs_grid->fields[4] ;  
          $this->pl_fechafin = $this->rs_grid->fields[5] ;  
          $this->pl_detalle = $this->rs_grid->fields[6] ;  
          $this->unidad = $this->rs_grid->fields[7] ;  
          $this->sc_field_1 = $this->rs_grid->fields[8] ;  
          $this->sc_field_2 = $this->rs_grid->fields[9] ;  
          $this->emergencia = $this->rs_grid->fields[10] ;  
          $this->sc_field_3 = $this->rs_grid->fields[11] ;  
          $this->indicador = $this->rs_grid->fields[12] ;  
          $this->departamento = $this->rs_grid->fields[13] ;  
          $this->municipio = $this->rs_grid->fields[14] ;  
          $this->comunidad = $this->rs_grid->fields[15] ;  
          $this->pl_colonia = $this->rs_grid->fields[16] ;  
          $this->estado = $this->rs_grid->fields[17] ;  
          $this->sc_field_5 = $this->rs_grid->fields[18] ;  
          $this->sc_field_6 = $this->rs_grid->fields[19] ;  
          $this->pl_informacioncualitativa = $this->rs_grid->fields[20] ;  
          $this->pl_observacionesadicionales = $this->rs_grid->fields[21] ;  
          $this->sc_field_4 = $this->rs_grid->fields[22] ;  
          $this->sc_field_4 = (string)$this->sc_field_4;
          $this->sc_field_7 = $this->rs_grid->fields[23] ;  
          $this->sc_field_7 = (string)$this->sc_field_7;
          $this->pl_idplanificacion = $this->rs_grid->fields[24] ;  
          $this->pl_idplanificacion = (string)$this->pl_idplanificacion;
         if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Ind_Groupby'] != "sc_free_total")
         {
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] == "pdf")
          {
              $this->Res->nm_acum_res_unit($this->rs_grid);
          }
         }
          $this->SC_seq_page++; 
          $this->SC_seq_register = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['final'] + 1; 
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['rows_emb']++;
          $this->sc_proc_grid = true;
          $this->nm_inicio_pag++;
          if (!$this->NM_flag_antigo)
          {
             $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['final']++ ; 
          }
          $seq_det =  $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['final']; 
          $this->Ini->cor_link_dados = ($this->Ini->cor_link_dados == $this->css_scGridFieldOddLink) ? $this->css_scGridFieldEvenLink : $this->css_scGridFieldOddLink; 
          $this->Ini->qual_linha   = ($this->Ini->qual_linha == "par") ? "impar" : "par";
          if ("impar" == $this->Ini->qual_linha)
          {
              $this->css_line_back = $this->css_scGridFieldOddVert;
          }
          else
          {
              $this->css_line_back = $this->css_scGridFieldEvenVert;
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_psq'])
          {
              $temp = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['dado_psq_ret'];
              eval("\$teste = \$this->$temp;");
              if ($temp == "pl_fechainicio")
              {
                  $conteudo_x = $teste;
                  nm_conv_limpa_dado($conteudo_x, "YYYY-MM-DD");
                  if (is_numeric($conteudo_x) && $conteudo_x > 0) 
                  { 
                      $this->nm_data->SetaData($teste, "YYYY-MM-DD");
                      $teste = $this->nm_data->FormataSaida($this->nm_data->FormatRegion("DT", "ddmmaaaa"));
                  } 
              }
              if ($temp == "pl_fechafin")
              {
                  $conteudo_x = $teste;
                  nm_conv_limpa_dado($conteudo_x, "YYYY-MM-DD");
                  if (is_numeric($conteudo_x) && $conteudo_x > 0) 
                  { 
                      $this->nm_data->SetaData($teste, "YYYY-MM-DD");
                      $teste = $this->nm_data->FormataSaida($this->nm_data->FormatRegion("DT", "ddmmaaaa"));
                  } 
              }
              if ($temp == "sc_field_5")
              {
                  $conteudo_x = $teste;
                  nm_conv_limpa_dado($conteudo_x, "YYYY-MM-DD");
                  if (is_numeric($conteudo_x) && $conteudo_x > 0) 
                  { 
                      $this->nm_data->SetaData($teste, "YYYY-MM-DD");
                      $teste = $this->nm_data->FormataSaida($this->nm_data->FormatRegion("DT", "ddmmaaaa"));
                  } 
              }
              if ($temp == "sc_field_6")
              {
                  $conteudo_x = $teste;
                  nm_conv_limpa_dado($conteudo_x, "YYYY-MM-DD");
                  if (is_numeric($conteudo_x) && $conteudo_x > 0) 
                  { 
                      $this->nm_data->SetaData($teste, "YYYY-MM-DD");
                      $teste = $this->nm_data->FormataSaida($this->nm_data->FormatRegion("DT", "ddmmaaaa"));
                  } 
              }
          }
   if (!$this->NM_flag_antigo)
   {
       $nm_contr_percentual = 100 / $this->nm_grid_slides_linha; 
       if ($this->nm_contr_album != 0 && $this->nm_contr_album % $this->nm_grid_slides_linha == 0)
       {
           $this->SC_ancora = $this->SC_seq_page;
$nm_saida->saida("      </tr></table></td></tr>\r\n");
$nm_saida->saida("<tr><td class=\"" . $this->css_scGridBlockBg . "\" style=\"width: " . $this->width_tabula_quebra . "; display:" . $this->width_tabula_display . ";\">&nbsp;</td><td style=\"padding: 0px\"><table align=\"center\" width=\"100%\" style=\"padding: 0px; border-spacing: 0px; border-width: 0px;\">\r\n");
$nm_saida->saida("<tr id=\"SC_ancor" . $this->SC_ancora . "\">\r\n");
       }
       elseif ($this->nm_contr_album == 0)
       {
           $this->SC_ancora = $this->SC_seq_page;
$nm_saida->saida("      <tr><td class=\"" . $this->css_scGridBlockBg . "\" style=\"width: " . $this->width_tabula_quebra . "; display:" . $this->width_tabula_display . ";\">&nbsp;</td><td style=\"padding: 0px\"><table align=\"center\" width=\"100%\" style=\"padding: 0px; border-spacing: 0px; border-width: 0px;\">\r\n");
$nm_saida->saida("<tr id=\"SC_ancor" . $this->SC_ancora . "\">\r\n");
       }
       $this->nm_contr_album++; 
       $this->Nm_bloco_aberto = true; 
   } 
$nm_saida->saida("   <td style=\"padding: 0px; vertical-align: top;\" width=\"" . $nm_contr_percentual . "%\">\r\n");
 if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_psq']) { 
$nm_saida->saida("     &nbsp;\r\n");
 } 
 if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_psq']) { 
$nm_saida->saida("     \r\n");
 $Cod_Btn = nmButtonOutput($this->arr_buttons, "bcapture", "document.Fpesq.nm_ret_psq.value='" . str_replace(array("'", '"'), array("\'", '\"'), $teste) . "'; nm_escreve_window();", "document.Fpesq.nm_ret_psq.value='" . str_replace(array("'", '"'), array("\'", '\"'), $teste) . "'; nm_escreve_window();", "", "Rad_psq", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
$nm_saida->saida(" $Cod_Btn\r\n");
 } 
$nm_saida->saida("    <table width=\"100%\" style=\"padding: 0px; border-spacing: 0px; border-width: 0px;\"><tr valign=\"top\"><td style=\"padding: 0px\" width=\"100%\" height=\"\">\r\n");
 if(!isset($this->Ini->nm_hidden_blocos[0]) || $this->Ini->nm_hidden_blocos[0] != "off")
 {
     $Img_tit_blk_i = "";
     $Img_tit_blk_f = "";
     $Collapse_blk  = "";
     if ('' != $this->Ini->Block_img_exp && '' != $this->Ini->Block_img_col && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "pdf")
     {
         $Img_tit_blk_i = "<table style=\"border-collapse: collapse; height: 100%; width: 100%\"><tr><td style=\"vertical-align: middle; border-width: 0px; padding: 0px 2px 0px 0px\"><img src=\"" . $this->Ini->path_icones . "/" . $this->Ini->Block_img_col . "\" style=\"border: 0px; float: left\" class=\"sc-ui-block-control\"></td><td class=\"" . $this->css_scGridBlockAlign . " css_blk_0\" style=\"border-width: 0px; padding: 0px; width: 100%;@STYBLK@\">";
         $Img_tit_blk_f = "</td></tr></table>";
     }
$nm_saida->saida("  <TABLE class=\"" . $this->css_scGridTabela . "\"  style=\"border-collapse:collapse;\" cellspacing=0px cellpadding=0px align=\"center\" id=\"grid_jdp_beneficiohogar_detalle_hidden_bloco_0_" . $this->nm_contr_album . "\" width=\"100%\" style=\"height: 100%\">\r\n");
$nm_saida->saida("   <TR>\r\n");
$nm_saida->saida("    <TD  style=\"border-width: 0px; border-style: none; \" height=\"\" valign=\"top\" width=\"100%\">\r\n");
$nm_saida->saida("     <TABLE style=\"padding: 0px; spacing: 0px; border-width: 0px; border-collapse:collapse;\" width=\"100%\">\r\n");
$nm_saida->saida("      <TR>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_sc_field_0_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['sc_field_0']) && $this->NM_cmp_hidden['sc_field_0'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['sc_field_0'])) ? $this->New_label['sc_field_0'] : "Código de Proyecto";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_sc_field_0_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_sc_field_0_grid_line . "\"  style=\"" . $this->Css_Cmp['css_sc_field_0_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = sc_strip_script($this->sc_field_0); 
          $conteudo_original = sc_strip_script($this->sc_field_0); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['sc_field_0']) && $this->NM_cmp_hidden['sc_field_0'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_sc_field_0_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_pl_codsocio_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['pl_codsocio']) && $this->NM_cmp_hidden['pl_codsocio'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['pl_codsocio'])) ? $this->New_label['pl_codsocio'] : "Cod Socio";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_pl_codsocio_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_pl_codsocio_grid_line . "\"  style=\"" . $this->Css_Cmp['css_pl_codsocio_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = sc_strip_script($this->pl_codsocio); 
          $conteudo_original = sc_strip_script($this->pl_codsocio); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['pl_codsocio']) && $this->NM_cmp_hidden['pl_codsocio'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_pl_codsocio_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("   </tr><tr>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_ac_nombre_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['ac_nombre']) && $this->NM_cmp_hidden['ac_nombre'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['ac_nombre'])) ? $this->New_label['ac_nombre'] : "Actividad";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     \r\n");
   if (isset($this->NM_cmp_hidden['ac_nombre']) && $this->NM_cmp_hidden['ac_nombre'] == "off")
   {
   
$nm_saida->saida("&nbsp;\r\n");
   }
   else
   {
      if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "pdf") 
      {
          $NM_cmp_class =  "ac_nombre";
      $link_img = "";
      $nome_img = $this->Ini->Label_sort;
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_cmp'] == $NM_cmp_class)
      {
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_desc'] == " desc")
          {
              $nome_img = $this->Ini->Label_sort_desc;
          }
          else
          {
              $nome_img = $this->Ini->Label_sort_asc;
          }
      }
      if (empty($this->Ini->Label_sort_pos) || $this->Ini->Label_sort_pos == "right")
      {
          $this->Ini->Label_sort_pos = "right_field";
      }
      if (empty($nome_img))
      {
          $link_img = nl2br($SC_Label);
      }
      elseif ($this->Ini->Label_sort_pos == "right_field")
      {
          $link_img = "<span style='display: inline-block; white-space: normal; word-break: normal;white-space: nowrap;'>" . nl2br($SC_Label) . "</span><IMG SRC=\"" . $this->Ini->path_img_global . "/" . $nome_img . "\" BORDER=\"0\"/>";
      }
      elseif ($this->Ini->Label_sort_pos == "left_field")
      {
          $link_img = "<IMG SRC=\"" . $this->Ini->path_img_global . "/" . $nome_img . "\" BORDER=\"0\"/><span style='display: inline-block; white-space: normal; word-break: normal;'>" . nl2br($SC_Label) . "</span>";
      }
      elseif ($this->Ini->Label_sort_pos == "right_cell")
      {
          $link_img = "<span style='display: inline-block; flex-grow: 1; white-space: normal; word-break: normal;white-space: nowrap;'>" . nl2br($SC_Label) . "</span><IMG SRC=\"" . $this->Ini->path_img_global . "/" . $nome_img . "\" BORDER=\"0\"/>";
      }
      elseif ($this->Ini->Label_sort_pos == "left_cell")
      {
          $link_img = "<IMG SRC=\"" . $this->Ini->path_img_global . "/" . $nome_img . "\" BORDER=\"0\"/><span style='display: inline-block; flex-grow: 1; white-space: normal; word-break: normal;'>" . nl2br($SC_Label) . "</span>";
      }
$nm_saida->saida("<a href=\"javascript:nm_gp_submit2('" . $NM_cmp_class . "')\" class=\"" . $this->css_scGridLabelLink . "\" style='white-space: nowrap'>" . $link_img . "</a>\r\n");
      }
      else
   {
$nm_saida->saida("" . nl2br($SC_Label) . "\r\n");
   }
   }
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_ac_nombre_grid_line . "\"  style=\"" . $this->Css_Cmp['css_ac_nombre_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = sc_strip_script($this->ac_nombre); 
          $conteudo_original = sc_strip_script($this->ac_nombre); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['ac_nombre']) && $this->NM_cmp_hidden['ac_nombre'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_ac_nombre_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_suba_nombre_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['suba_nombre']) && $this->NM_cmp_hidden['suba_nombre'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['suba_nombre'])) ? $this->New_label['suba_nombre'] : "Sub Actividad";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     \r\n");
   if (isset($this->NM_cmp_hidden['suba_nombre']) && $this->NM_cmp_hidden['suba_nombre'] == "off")
   {
   
$nm_saida->saida("&nbsp;\r\n");
   }
   else
   {
      if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "pdf") 
      {
          $NM_cmp_class =  "suba_nombre";
      $link_img = "";
      $nome_img = $this->Ini->Label_sort;
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_cmp'] == $NM_cmp_class)
      {
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ordem_desc'] == " desc")
          {
              $nome_img = $this->Ini->Label_sort_desc;
          }
          else
          {
              $nome_img = $this->Ini->Label_sort_asc;
          }
      }
      if (empty($this->Ini->Label_sort_pos) || $this->Ini->Label_sort_pos == "right")
      {
          $this->Ini->Label_sort_pos = "right_field";
      }
      if (empty($nome_img))
      {
          $link_img = nl2br($SC_Label);
      }
      elseif ($this->Ini->Label_sort_pos == "right_field")
      {
          $link_img = "<span style='display: inline-block; white-space: normal; word-break: normal;white-space: nowrap;'>" . nl2br($SC_Label) . "</span><IMG SRC=\"" . $this->Ini->path_img_global . "/" . $nome_img . "\" BORDER=\"0\"/>";
      }
      elseif ($this->Ini->Label_sort_pos == "left_field")
      {
          $link_img = "<IMG SRC=\"" . $this->Ini->path_img_global . "/" . $nome_img . "\" BORDER=\"0\"/><span style='display: inline-block; white-space: normal; word-break: normal;'>" . nl2br($SC_Label) . "</span>";
      }
      elseif ($this->Ini->Label_sort_pos == "right_cell")
      {
          $link_img = "<span style='display: inline-block; flex-grow: 1; white-space: normal; word-break: normal;white-space: nowrap;'>" . nl2br($SC_Label) . "</span><IMG SRC=\"" . $this->Ini->path_img_global . "/" . $nome_img . "\" BORDER=\"0\"/>";
      }
      elseif ($this->Ini->Label_sort_pos == "left_cell")
      {
          $link_img = "<IMG SRC=\"" . $this->Ini->path_img_global . "/" . $nome_img . "\" BORDER=\"0\"/><span style='display: inline-block; flex-grow: 1; white-space: normal; word-break: normal;'>" . nl2br($SC_Label) . "</span>";
      }
$nm_saida->saida("<a href=\"javascript:nm_gp_submit2('" . $NM_cmp_class . "')\" class=\"" . $this->css_scGridLabelLink . "\" style='white-space: nowrap'>" . $link_img . "</a>\r\n");
      }
      else
   {
$nm_saida->saida("" . nl2br($SC_Label) . "\r\n");
   }
   }
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_suba_nombre_grid_line . "\"  style=\"" . $this->Css_Cmp['css_suba_nombre_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = sc_strip_script($this->suba_nombre); 
          $conteudo_original = sc_strip_script($this->suba_nombre); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['suba_nombre']) && $this->NM_cmp_hidden['suba_nombre'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_suba_nombre_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("   </tr><tr>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_pl_fechainicio_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['pl_fechainicio']) && $this->NM_cmp_hidden['pl_fechainicio'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['pl_fechainicio'])) ? $this->New_label['pl_fechainicio'] : "Fecha Inicio";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_pl_fechainicio_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_pl_fechainicio_grid_line . "\"  style=\"" . $this->Css_Cmp['css_pl_fechainicio_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = NM_encode_input(sc_strip_script($this->pl_fechainicio)); 
          $conteudo_original = NM_encode_input(sc_strip_script($this->pl_fechainicio)); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          else    
          { 
               $conteudo_x =  $conteudo;
               nm_conv_limpa_dado($conteudo_x, "YYYY-MM-DD");
               if (is_numeric($conteudo_x) && $conteudo_x > 0) 
               { 
                   $this->nm_data->SetaData($conteudo, "YYYY-MM-DD");
                   $conteudo = $this->nm_data->FormataSaida($this->nm_data->FormatRegion("DT", "ddmmaaaa"));
               } 
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['pl_fechainicio']) && $this->NM_cmp_hidden['pl_fechainicio'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_pl_fechainicio_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_pl_fechafin_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['pl_fechafin']) && $this->NM_cmp_hidden['pl_fechafin'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['pl_fechafin'])) ? $this->New_label['pl_fechafin'] : "Fecha Fin";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_pl_fechafin_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_pl_fechafin_grid_line . "\"  style=\"" . $this->Css_Cmp['css_pl_fechafin_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = NM_encode_input(sc_strip_script($this->pl_fechafin)); 
          $conteudo_original = NM_encode_input(sc_strip_script($this->pl_fechafin)); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          else    
          { 
               $conteudo_x =  $conteudo;
               nm_conv_limpa_dado($conteudo_x, "YYYY-MM-DD");
               if (is_numeric($conteudo_x) && $conteudo_x > 0) 
               { 
                   $this->nm_data->SetaData($conteudo, "YYYY-MM-DD");
                   $conteudo = $this->nm_data->FormataSaida($this->nm_data->FormatRegion("DT", "ddmmaaaa"));
               } 
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['pl_fechafin']) && $this->NM_cmp_hidden['pl_fechafin'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_pl_fechafin_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("   </tr><tr>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_pl_detalle_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['pl_detalle']) && $this->NM_cmp_hidden['pl_detalle'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['pl_detalle'])) ? $this->New_label['pl_detalle'] : "Detalle";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_pl_detalle_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_pl_detalle_grid_line . "\"  style=\"" . $this->Css_Cmp['css_pl_detalle_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = sc_strip_script($this->pl_detalle); 
          $conteudo_original = sc_strip_script($this->pl_detalle); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['pl_detalle']) && $this->NM_cmp_hidden['pl_detalle'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_pl_detalle_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_unidad_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['unidad']) && $this->NM_cmp_hidden['unidad'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['unidad'])) ? $this->New_label['unidad'] : "Unidad";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_unidad_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_unidad_grid_line . "\"  style=\"" . $this->Css_Cmp['css_unidad_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = sc_strip_script($this->unidad); 
          $conteudo_original = sc_strip_script($this->unidad); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['unidad']) && $this->NM_cmp_hidden['unidad'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_unidad_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("   </tr><tr>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_sc_field_1_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['sc_field_1']) && $this->NM_cmp_hidden['sc_field_1'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['sc_field_1'])) ? $this->New_label['sc_field_1'] : "Frecuencia De Entrega";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_sc_field_1_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_sc_field_1_grid_line . "\"  style=\"" . $this->Css_Cmp['css_sc_field_1_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = sc_strip_script($this->sc_field_1); 
          $conteudo_original = sc_strip_script($this->sc_field_1); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['sc_field_1']) && $this->NM_cmp_hidden['sc_field_1'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_sc_field_1_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_sc_field_2_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['sc_field_2']) && $this->NM_cmp_hidden['sc_field_2'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['sc_field_2'])) ? $this->New_label['sc_field_2'] : "Tipo De Entrega";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_sc_field_2_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_sc_field_2_grid_line . "\"  style=\"" . $this->Css_Cmp['css_sc_field_2_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = sc_strip_script($this->sc_field_2); 
          $conteudo_original = sc_strip_script($this->sc_field_2); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['sc_field_2']) && $this->NM_cmp_hidden['sc_field_2'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_sc_field_2_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("   </tr><tr>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_emergencia_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['emergencia']) && $this->NM_cmp_hidden['emergencia'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['emergencia'])) ? $this->New_label['emergencia'] : "Emergencia";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_emergencia_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_emergencia_grid_line . "\"  style=\"" . $this->Css_Cmp['css_emergencia_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = sc_strip_script($this->emergencia); 
          $conteudo_original = sc_strip_script($this->emergencia); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['emergencia']) && $this->NM_cmp_hidden['emergencia'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_emergencia_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_sc_field_3_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['sc_field_3']) && $this->NM_cmp_hidden['sc_field_3'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['sc_field_3'])) ? $this->New_label['sc_field_3'] : "Grupo De Beneficiarios";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_sc_field_3_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_sc_field_3_grid_line . "\"  style=\"" . $this->Css_Cmp['css_sc_field_3_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = sc_strip_script($this->sc_field_3); 
          $conteudo_original = sc_strip_script($this->sc_field_3); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['sc_field_3']) && $this->NM_cmp_hidden['sc_field_3'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_sc_field_3_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("   </tr><tr>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_indicador_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['indicador']) && $this->NM_cmp_hidden['indicador'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['indicador'])) ? $this->New_label['indicador'] : "Indicador";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_indicador_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_indicador_grid_line . "\"  style=\"" . $this->Css_Cmp['css_indicador_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = sc_strip_script($this->indicador); 
          $conteudo_original = sc_strip_script($this->indicador); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['indicador']) && $this->NM_cmp_hidden['indicador'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_indicador_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_departamento_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['departamento']) && $this->NM_cmp_hidden['departamento'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['departamento'])) ? $this->New_label['departamento'] : "Departamento";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_departamento_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_departamento_grid_line . "\"  style=\"" . $this->Css_Cmp['css_departamento_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = sc_strip_script($this->departamento); 
          $conteudo_original = sc_strip_script($this->departamento); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['departamento']) && $this->NM_cmp_hidden['departamento'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_departamento_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("   </tr><tr>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_municipio_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['municipio']) && $this->NM_cmp_hidden['municipio'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['municipio'])) ? $this->New_label['municipio'] : "Municipio";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_municipio_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_municipio_grid_line . "\"  style=\"" . $this->Css_Cmp['css_municipio_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = sc_strip_script($this->municipio); 
          $conteudo_original = sc_strip_script($this->municipio); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['municipio']) && $this->NM_cmp_hidden['municipio'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_municipio_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_comunidad_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['comunidad']) && $this->NM_cmp_hidden['comunidad'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['comunidad'])) ? $this->New_label['comunidad'] : "Comunidad";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_comunidad_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_comunidad_grid_line . "\"  style=\"" . $this->Css_Cmp['css_comunidad_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = sc_strip_script($this->comunidad); 
          $conteudo_original = sc_strip_script($this->comunidad); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['comunidad']) && $this->NM_cmp_hidden['comunidad'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_comunidad_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("   </tr><tr>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_pl_colonia_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['pl_colonia']) && $this->NM_cmp_hidden['pl_colonia'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['pl_colonia'])) ? $this->New_label['pl_colonia'] : "Colonia";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_pl_colonia_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_pl_colonia_grid_line . "\"  style=\"" . $this->Css_Cmp['css_pl_colonia_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = sc_strip_script($this->pl_colonia); 
          $conteudo_original = sc_strip_script($this->pl_colonia); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['pl_colonia']) && $this->NM_cmp_hidden['pl_colonia'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_pl_colonia_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_estado_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['estado']) && $this->NM_cmp_hidden['estado'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['estado'])) ? $this->New_label['estado'] : "Estado";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_estado_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_estado_grid_line . "\"  style=\"" . $this->Css_Cmp['css_estado_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = sc_strip_script($this->estado); 
          $conteudo_original = sc_strip_script($this->estado); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['estado']) && $this->NM_cmp_hidden['estado'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_estado_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("   </tr></table></td>\r\n");
$nm_saida->saida("   </tr></table>\r\n");
 }
$nm_saida->saida("   </td></tr></table>\r\n");
$nm_saida->saida("    <table width=\"100%\" style=\"padding: 0px; border-spacing: 0px; border-width: 0px;\"><tr valign=\"top\"><td style=\"padding: 0px\" width=\"100%\" height=\"\">\r\n");
 if(!isset($this->Ini->nm_hidden_blocos[1]) || $this->Ini->nm_hidden_blocos[1] != "off")
 {
     $Img_tit_blk_i = "";
     $Img_tit_blk_f = "";
     $Collapse_blk  = "";
     if ('' != $this->Ini->Block_img_exp && '' != $this->Ini->Block_img_col && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "pdf")
     {
         $Img_tit_blk_i = "<table style=\"border-collapse: collapse; height: 100%; width: 100%\"><tr><td style=\"vertical-align: middle; border-width: 0px; padding: 0px 2px 0px 0px\"><img src=\"" . $this->Ini->path_icones . "/" . $this->Ini->Block_img_col . "\" style=\"border: 0px; float: left\" class=\"sc-ui-block-control\"></td><td class=\"" . $this->css_scGridBlockAlign . " css_blk_1\" style=\"border-width: 0px; padding: 0px; width: 100%;@STYBLK@\">";
         $Img_tit_blk_f = "</td></tr></table>";
     }
$nm_saida->saida("  <TABLE class=\"" . $this->css_scGridTabela . "\"  style=\"border-collapse:collapse;\" cellspacing=0px cellpadding=0px align=\"center\" id=\"grid_jdp_beneficiohogar_detalle_hidden_bloco_1_" . $this->nm_contr_album . "\" width=\"100%\" style=\"height: 100%\">\r\n");
$nm_saida->saida("   <TR>\r\n");
$nm_saida->saida("    <TD  style=\"border-width: 0px; border-style: none; \" height=\"\" valign=\"top\" width=\"100%\">\r\n");
$nm_saida->saida("     <TABLE style=\"padding: 0px; spacing: 0px; border-width: 0px; border-collapse:collapse;\" width=\"100%\">\r\n");
$nm_saida->saida("      <TR>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_sc_field_5_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['sc_field_5']) && $this->NM_cmp_hidden['sc_field_5'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['sc_field_5'])) ? $this->New_label['sc_field_5'] : "Fecha Inicio Actividad";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_sc_field_5_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_sc_field_5_grid_line . "\"  style=\"" . $this->Css_Cmp['css_sc_field_5_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = NM_encode_input(sc_strip_script($this->sc_field_5)); 
          $conteudo_original = NM_encode_input(sc_strip_script($this->sc_field_5)); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          else    
          { 
               $conteudo_x =  $conteudo;
               nm_conv_limpa_dado($conteudo_x, "YYYY-MM-DD");
               if (is_numeric($conteudo_x) && $conteudo_x > 0) 
               { 
                   $this->nm_data->SetaData($conteudo, "YYYY-MM-DD");
                   $conteudo = $this->nm_data->FormataSaida($this->nm_data->FormatRegion("DT", "ddmmaaaa"));
               } 
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['sc_field_5']) && $this->NM_cmp_hidden['sc_field_5'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_sc_field_5_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_sc_field_6_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['sc_field_6']) && $this->NM_cmp_hidden['sc_field_6'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['sc_field_6'])) ? $this->New_label['sc_field_6'] : "Fecha Fin Actividad";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_sc_field_6_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_sc_field_6_grid_line . "\"  style=\"" . $this->Css_Cmp['css_sc_field_6_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = NM_encode_input(sc_strip_script($this->sc_field_6)); 
          $conteudo_original = NM_encode_input(sc_strip_script($this->sc_field_6)); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          else    
          { 
               $conteudo_x =  $conteudo;
               nm_conv_limpa_dado($conteudo_x, "YYYY-MM-DD");
               if (is_numeric($conteudo_x) && $conteudo_x > 0) 
               { 
                   $this->nm_data->SetaData($conteudo, "YYYY-MM-DD");
                   $conteudo = $this->nm_data->FormataSaida($this->nm_data->FormatRegion("DT", "ddmmaaaa"));
               } 
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['sc_field_6']) && $this->NM_cmp_hidden['sc_field_6'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_sc_field_6_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("   </tr><tr>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_pl_informacioncualitativa_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['pl_informacioncualitativa']) && $this->NM_cmp_hidden['pl_informacioncualitativa'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['pl_informacioncualitativa'])) ? $this->New_label['pl_informacioncualitativa'] : "Informacion Cualitativa";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_pl_informacioncualitativa_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_pl_informacioncualitativa_grid_line . "\"  style=\"" . $this->Css_Cmp['css_pl_informacioncualitativa_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = sc_strip_script($this->pl_informacioncualitativa); 
          $conteudo_original = sc_strip_script($this->pl_informacioncualitativa); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['pl_informacioncualitativa']) && $this->NM_cmp_hidden['pl_informacioncualitativa'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_pl_informacioncualitativa_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_pl_observacionesadicionales_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['pl_observacionesadicionales']) && $this->NM_cmp_hidden['pl_observacionesadicionales'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['pl_observacionesadicionales'])) ? $this->New_label['pl_observacionesadicionales'] : "Observaciones Adicionales";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_pl_observacionesadicionales_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_pl_observacionesadicionales_grid_line . "\"  style=\"" . $this->Css_Cmp['css_pl_observacionesadicionales_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = sc_strip_script($this->pl_observacionesadicionales); 
          $conteudo_original = sc_strip_script($this->pl_observacionesadicionales); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['pl_observacionesadicionales']) && $this->NM_cmp_hidden['pl_observacionesadicionales'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_pl_observacionesadicionales_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("   </tr><tr>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_sc_field_4_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['sc_field_4']) && $this->NM_cmp_hidden['sc_field_4'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['sc_field_4'])) ? $this->New_label['sc_field_4'] : "Cantidad Estimada Beneficiarios Idirectos";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_sc_field_4_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_sc_field_4_grid_line . "\"  style=\"" . $this->Css_Cmp['css_sc_field_4_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = NM_encode_input(sc_strip_script($this->sc_field_4)); 
          $conteudo_original = NM_encode_input(sc_strip_script($this->sc_field_4)); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          else    
          { 
              nmgp_Form_Num_Val($conteudo, $_SESSION['scriptcase']['reg_conf']['grup_num'], $_SESSION['scriptcase']['reg_conf']['dec_num'], "0", "S", "2", "", "N:" . $_SESSION['scriptcase']['reg_conf']['neg_num'] , $_SESSION['scriptcase']['reg_conf']['simb_neg'], $_SESSION['scriptcase']['reg_conf']['num_group_digit']) ; 
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['sc_field_4']) && $this->NM_cmp_hidden['sc_field_4'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_sc_field_4_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_mediosdeverificacion_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['mediosdeverificacion']) && $this->NM_cmp_hidden['mediosdeverificacion'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['mediosdeverificacion'])) ? $this->New_label['mediosdeverificacion'] : "VER MEDIOS DE VERIFICACIÓN";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_mediosdeverificacion_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_mediosdeverificacion_grid_line . "\"  style=\"" . $this->Css_Cmp['css_mediosdeverificacion_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = $this->mediosdeverificacion; 
          $conteudo_original = $this->mediosdeverificacion; 
          if (!is_file($this->Ini->root  . $this->Ini->path_imag_cab . "/scriptcase__NM__ico__NM__briefcase_document_24.png"))
          { 
              $conteudo = "&nbsp;" ;  
          } 
          else 
          { 
              if ($this->Ini->Export_img_zip)
              {
                  $this->Ini->Img_export_zip[] = $this->Ini->root . "/" . $this->Ini->path_imag_cab . "/scriptcase__NM__ico__NM__briefcase_document_24.png";
                  $conteudo = "<img border=\"\" src=\"scriptcase__NM__ico__NM__briefcase_document_24.png\"/>"; 
              }
              elseif ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['doc_word'] || $this->Img_embbed || $this->Ini->sc_export_ajax_img) 
              { 
                  $loc_img_word = $this->Ini->root . $this->Ini->path_imag_cab . "/scriptcase__NM__ico__NM__briefcase_document_24.png";
                  $tmp_mediosdeverificacion = fopen($loc_img_word, "rb"); 
                  $reg_mediosdeverificacion = fread($tmp_mediosdeverificacion, filesize($loc_img_word)); 
                  fclose($tmp_mediosdeverificacion);  
                  $conteudo = "<img border=\"0\" src=\"data:image/jpeg;base64," . base64_encode($reg_mediosdeverificacion) . "\"/>" ; 
              } 
              else 
              { 
                  $conteudo = "<img border=\"0\" src=\"" . $this->NM_raiz_img  . $this->Ini->path_imag_cab . "/scriptcase__NM__ico__NM__briefcase_document_24.png\"/>" ; 
              } 
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['mediosdeverificacion']) && $this->NM_cmp_hidden['mediosdeverificacion'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     \r\n");
 if (!$this->Ini->Proc_print && !$this->Ini->SC_Link_View && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "pdf" && $_SESSION['scriptcase']['contr_link_emb'] != "pdf" && $conteudo != "&nbsp;"){ $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['Ind_lig_mult']++;
       $linkTarget = isset($this->Ini->sc_lig_target['C_@scinf_mediosdeverificacion_@scinf_grid_mediosdeverificacion']) ? $this->Ini->sc_lig_target['C_@scinf_mediosdeverificacion_@scinf_grid_mediosdeverificacion'] : (isset($this->Ini->sc_lig_target['C_@scinf_mediosdeverificacion']) ? $this->Ini->sc_lig_target['C_@scinf_mediosdeverificacion'] : null);
       if (isset($this->Ini->sc_lig_md5["grid_mediosdeverificacion"]) && $this->Ini->sc_lig_md5["grid_mediosdeverificacion"] == "S") {
           $Parms_Lig = "nmgp_lig_edit_lapis?#?S?@?gloplanificacion?#?" . str_replace("'", "@aspass@", $this->pl_idplanificacion) . "?@?";
           if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['dashboard_info']['under_dashboard'] && isset($linkTarget))
           {
               if ('' != $Parms_Lig)
               {
                   $Parms_Lig .= '*scout';
               }
               $Parms_Lig .= 'under_dashboard*scin1*scoutdashboard_app*scin' . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['dashboard_info']['dashboard_app'] . '*scoutown_widget*scin' . $linkTarget . '*scoutparent_widget*scin' . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['dashboard_info']['own_widget'] . '*scoutcompact_mode*scin' . ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['dashboard_info']['compact_mode'] ? '1' : '0') . '*scoutremove_margin*scin' . ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['dashboard_info']['remove_margin'] ? '1' : '0') . '*scoutremove_border*scin' . ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['dashboard_info']['remove_border'] ? '1' : '0');
           }
           $Md5_Lig    = "@SC_par@" . NM_encode_input($this->Ini->sc_page) . "@SC_par@grid_jdp_beneficiohogar_detalle@SC_par@" . md5($Parms_Lig);
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['Lig_Md5'][md5($Parms_Lig)] = $Parms_Lig;
       } else {
           $Md5_Lig = "nmgp_lig_edit_lapis?#?S?@?gloplanificacion?#?" . str_replace("'", "@aspass@", $this->pl_idplanificacion) . "?@?";
       }
$nm_saida->saida("<a id=\"id_sc_field_mediosdeverificacion_" . $this->SC_seq_page . "\" href=\"javascript:nm_gp_submit5('" . $this->Ini->link_grid_mediosdeverificacion_cons . "', '$this->nm_location', '$Md5_Lig', '" . (isset($linkTarget) ? $linkTarget : '_self') . "', 'inicio', '0', '0', '', 'grid_mediosdeverificacion', '" . $this->SC_ancora . "')\" onMouseover=\"nm_mostra_hint(this, event, 'Ver Medios Cargados')\" onMouseOut=\"nm_apaga_hint()\" class=\"" . $this->Ini->cor_link_dados . $this->css_sep . $this->css_mediosdeverificacion_grid_line . "\">" . $conteudo . "</a>\r\n");
} else {
$nm_saida->saida(" <span id=\"id_sc_field_mediosdeverificacion_" . $this->SC_seq_page . "\">$conteudo </span>\r\n");
       } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("   </tr><tr>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_sc_field_7_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['sc_field_7']) && $this->NM_cmp_hidden['sc_field_7'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['sc_field_7'])) ? $this->New_label['sc_field_7'] : "Valor APR";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_sc_field_7_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_sc_field_7_grid_line . "\"  style=\"" . $this->Css_Cmp['css_sc_field_7_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = NM_encode_input(sc_strip_script($this->sc_field_7)); 
          $conteudo_original = NM_encode_input(sc_strip_script($this->sc_field_7)); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          else    
          { 
              nmgp_Form_Num_Val($conteudo, $_SESSION['scriptcase']['reg_conf']['grup_num'], $_SESSION['scriptcase']['reg_conf']['dec_num'], "0", "S", "2", "", "N:" . $_SESSION['scriptcase']['reg_conf']['neg_num'] , $_SESSION['scriptcase']['reg_conf']['simb_neg'], $_SESSION['scriptcase']['reg_conf']['num_group_digit']) ; 
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['sc_field_7']) && $this->NM_cmp_hidden['sc_field_7'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_sc_field_7_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("    <TD class=\"" . $this->css_line_back . "\"  colspan=\"2\">&nbsp;</TD>\r\n");
$nm_saida->saida("   </tr></table></td>\r\n");
$nm_saida->saida("   </tr></table>\r\n");
 }
$nm_saida->saida("   </td></tr></table>\r\n");
$nm_saida->saida("    <table width=\"100%\" style=\"padding: 0px; border-spacing: 0px; border-width: 0px;\"><tr valign=\"top\"><td style=\"padding: 0px\" width=\"100%\" height=\"\">\r\n");
 if(!isset($this->Ini->nm_hidden_blocos[2]) || $this->Ini->nm_hidden_blocos[2] != "off")
 {
     $Img_tit_blk_i = "";
     $Img_tit_blk_f = "";
     $Collapse_blk  = "";
     if ('' != $this->Ini->Block_img_exp && '' != $this->Ini->Block_img_col && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "pdf")
     {
         $Img_tit_blk_i = "<table style=\"border-collapse: collapse; height: 100%; width: 100%\"><tr><td style=\"vertical-align: middle; border-width: 0px; padding: 0px 2px 0px 0px\"><img src=\"" . $this->Ini->path_icones . "/" . $this->Ini->Block_img_col . "\" style=\"border: 0px; float: left\" class=\"sc-ui-block-control\"></td><td class=\"" . $this->css_scGridBlockAlign . " css_blk_2\" style=\"border-width: 0px; padding: 0px; width: 100%;@STYBLK@\">";
         $Img_tit_blk_f = "</td></tr></table>";
     }
$nm_saida->saida("  <TABLE class=\"" . $this->css_scGridTabela . "\"  style=\"border-collapse:collapse;\" cellspacing=0px cellpadding=0px align=\"center\" id=\"grid_jdp_beneficiohogar_detalle_hidden_bloco_2_" . $this->nm_contr_album . "\" width=\"100%\" style=\"height: 100%\">\r\n");
$nm_saida->saida("   <TR>\r\n");
$nm_saida->saida("    <TD  style=\"border-width: 0px; border-style: none; \" height=\"\" valign=\"top\" width=\"100%\">\r\n");
$nm_saida->saida("     <TABLE style=\"padding: 0px; spacing: 0px; border-width: 0px; border-collapse:collapse;\" width=\"100%\">\r\n");
$nm_saida->saida("      <TR>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_avance_label . "\"  NOWRAP align=\"\" valign=\"\" width=\"50%\" >\r\n");
   if (isset($this->NM_cmp_hidden['avance']) && $this->NM_cmp_hidden['avance'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['avance'])) ? $this->New_label['avance'] : "AVANCE";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_avance_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_avance_grid_line . "\"  style=\"" . $this->Css_Cmp['css_avance_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"50%\" >\r\n");
          $conteudo = NM_encode_input(sc_strip_script($this->avance)); 
          $conteudo_original = NM_encode_input(sc_strip_script($this->avance)); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['avance']) && $this->NM_cmp_hidden['avance'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          else
          {
          $this->SC_nowrap = "";
$nm_saida->saida("     \r\n");
          if (!$this->Ini->Proc_print && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_beneficiohogar_avance']['embutida_treeview'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "pdf" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida_pdf'] != "pdf")
          { 
              $link_div = "";
              $_SESSION['sc_session'][$this->Ini->sc_page]['grid_beneficiohogar_avance']['ind_tree']++;
              $this->NM_cont_body = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_beneficiohogar_avance']['ind_tree'];
              $_SESSION['sc_session'][$this->Ini->sc_page]['NM_arr_tree']['grid_beneficiohogar_avance'][$this->NM_cont_body][1] = 'top';
              if ('' != $this->Ini->Tree_img_col && '' != $this->Ini->Tree_img_exp)
              { 
                  $link_div  = "<img id=\"b_open_grid_beneficiohogar_avance_" . $this->NM_cont_body . "\" style=\"display:''\" onclick=\"document.getElementById('b_open_grid_beneficiohogar_avance_" . $this->NM_cont_body . "').style.display = 'none'; document.getElementById('b_close_grid_beneficiohogar_avance_" . $this->NM_cont_body . "').style.display = ''; NM_liga_tbody(" . $this->NM_cont_body . ", NM_tab_grid_beneficiohogar_avance, 'grid_beneficiohogar_avance'); return false;\" src=\"" . $this->Ini->path_img_global . "/" . $this->Ini->Tree_img_exp . "\">";
                  $link_div .= "<img id=\"b_close_grid_beneficiohogar_avance_" . $this->NM_cont_body . "\" style=\"display:none\" onclick=\"document.getElementById('b_close_grid_beneficiohogar_avance_" . $this->NM_cont_body . "').style.display = 'none'; document.getElementById('b_open_grid_beneficiohogar_avance_" . $this->NM_cont_body . "').style.display = ''; NM_apaga_tbody(" . $this->NM_cont_body . ", NM_tab_grid_beneficiohogar_avance, 'grid_beneficiohogar_avance'); return false;\" src=\"" . $this->Ini->path_img_global . "/" . $this->Ini->Tree_img_col . "\">";
              }
              $nm_saida->saida("<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">");
              $nm_saida->saida("<TR> <TD align=\"left\">");
              $nm_saida->saida("<DIV id=\"tbody_grid_beneficiohogar_avance_" . $this->NM_cont_body . "_top\" style=\"display:''\">");
              $nm_saida->saida($link_div . "</DIV></TD></TR>");
              $_SESSION['sc_session'][$this->Ini->sc_page]['grid_beneficiohogar_avance']['ind_tree']++;
              $this->NM_cont_body = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_beneficiohogar_avance']['ind_tree'];
              $_SESSION['sc_session'][$this->Ini->sc_page]['NM_arr_tree']['grid_beneficiohogar_avance'][$this->NM_cont_body][1] = 'bot';
              $nm_saida->saida("<tr><td>");
              if ('' != $this->Ini->Tree_img_col && '' != $this->Ini->Tree_img_exp)
              { 
                  $nm_saida->saida("<DIV id=\"tbody_grid_beneficiohogar_avance_" . $this->NM_cont_body . "_bot\" style=\"display:none\">");
              }
              else
              { 
                  $nm_saida->saida("<DIV id=\"tbody_grid_beneficiohogar_avance_" . $this->NM_cont_body . "_bot\" style=\"display:''\">");
              }
          }
          $GLOBALS["script_case_init"] = $this->Ini->sc_page;
          $GLOBALS["nmgp_parms"] = "nmgp_lig_edit_lapis?#?S?@?gloplanificacion?#?" . str_replace("'", "@aspass@", $this->pl_idplanificacion) . "?@?";
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_beneficiohogar_avance']['embutida'] = true;
          if (method_exists($this->grid_beneficiohogar_avance, "controle"))
          {
              $this->grid_beneficiohogar_avance->controle();
          }
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_beneficiohogar_avance']['embutida'] = false;
          if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_beneficiohogar_avance']['emb_lig_aba']))
          { 
              if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'])
              { 
                 $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['emb_lig_aba'] = array_merge($this->Ini->Init_apl_lig, $_SESSION['sc_session'][$this->Ini->sc_page]['grid_beneficiohogar_avance']['emb_lig_aba']);
              }
              else 
              { 
                 $this->Ini->Init_apl_lig = array_merge($this->Ini->Init_apl_lig, $_SESSION['sc_session'][$this->Ini->sc_page]['grid_beneficiohogar_avance']['emb_lig_aba']);
              }
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_beneficiohogar_avance']['embutida_treeview'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "pdf" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida_pdf'] != "pdf")
          { 
              $nm_saida->saida("</DIV></td></tr>");
              $nm_saida->saida("</table>");
          }
          }
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("   </tr><tr>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_beneficiarios_label . "\"  NOWRAP align=\"\" valign=\"\" width=\"50%\" >\r\n");
   if (isset($this->NM_cmp_hidden['beneficiarios']) && $this->NM_cmp_hidden['beneficiarios'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['beneficiarios'])) ? $this->New_label['beneficiarios'] : "VER INGRESOS";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_beneficiarios_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_beneficiarios_grid_line . "\"  style=\"" . $this->Css_Cmp['css_beneficiarios_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"50%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = $this->beneficiarios; 
          $conteudo_original = $this->beneficiarios; 
          if (!is_file($this->Ini->root  . $this->Ini->path_imag_cab . "/scriptcase__NM__ico__NM__book_blue_open_24.png"))
          { 
              $conteudo = "&nbsp;" ;  
          } 
          else 
          { 
              if ($this->Ini->Export_img_zip)
              {
                  $this->Ini->Img_export_zip[] = $this->Ini->root . "/" . $this->Ini->path_imag_cab . "/scriptcase__NM__ico__NM__book_blue_open_24.png";
                  $conteudo = "<img border=\"\" src=\"scriptcase__NM__ico__NM__book_blue_open_24.png\"/>"; 
              }
              elseif ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['doc_word'] || $this->Img_embbed || $this->Ini->sc_export_ajax_img) 
              { 
                  $loc_img_word = $this->Ini->root . $this->Ini->path_imag_cab . "/scriptcase__NM__ico__NM__book_blue_open_24.png";
                  $tmp_beneficiarios = fopen($loc_img_word, "rb"); 
                  $reg_beneficiarios = fread($tmp_beneficiarios, filesize($loc_img_word)); 
                  fclose($tmp_beneficiarios);  
                  $conteudo = "<img border=\"0\" src=\"data:image/jpeg;base64," . base64_encode($reg_beneficiarios) . "\"/>" ; 
              } 
              else 
              { 
                  $conteudo = "<img border=\"0\" src=\"" . $this->NM_raiz_img  . $this->Ini->path_imag_cab . "/scriptcase__NM__ico__NM__book_blue_open_24.png\"/>" ; 
              } 
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['beneficiarios']) && $this->NM_cmp_hidden['beneficiarios'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf'])
          {
              $this->SC_nowrap = "NOWRAP";
          }
          else
          {
              $this->SC_nowrap = "NOWRAP";
          }
$nm_saida->saida("     \r\n");
 if (!$this->Ini->Proc_print && !$this->Ini->SC_Link_View && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "pdf" && $_SESSION['scriptcase']['contr_link_emb'] != "pdf" && $conteudo != "&nbsp;"){ $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['Ind_lig_mult']++;
       $linkTarget = isset($this->Ini->sc_lig_target['C_@scinf_beneficiarios_@scinf_grid_beneficiohogar_por_mes']) ? $this->Ini->sc_lig_target['C_@scinf_beneficiarios_@scinf_grid_beneficiohogar_por_mes'] : (isset($this->Ini->sc_lig_target['C_@scinf_beneficiarios']) ? $this->Ini->sc_lig_target['C_@scinf_beneficiarios'] : null);
       if (isset($this->Ini->sc_lig_md5["grid_beneficiohogar_por_mes"]) && $this->Ini->sc_lig_md5["grid_beneficiohogar_por_mes"] == "S") {
           $Parms_Lig = "nmgp_lig_edit_lapis?#?S?@?gloplanificacion?#?" . str_replace("'", "@aspass@", $this->pl_idplanificacion) . "?@?NM_run_iframe?#?1?@?";
           if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['dashboard_info']['under_dashboard'] && isset($linkTarget))
           {
               if ('' != $Parms_Lig)
               {
                   $Parms_Lig .= '*scout';
               }
               $Parms_Lig .= 'under_dashboard*scin1*scoutdashboard_app*scin' . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['dashboard_info']['dashboard_app'] . '*scoutown_widget*scin' . $linkTarget . '*scoutparent_widget*scin' . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['dashboard_info']['own_widget'] . '*scoutcompact_mode*scin' . ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['dashboard_info']['compact_mode'] ? '1' : '0') . '*scoutremove_margin*scin' . ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['dashboard_info']['remove_margin'] ? '1' : '0') . '*scoutremove_border*scin' . ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['dashboard_info']['remove_border'] ? '1' : '0');
           }
           $Md5_Lig    = "@SC_par@" . NM_encode_input($this->Ini->sc_page) . "@SC_par@grid_jdp_beneficiohogar_detalle@SC_par@" . md5($Parms_Lig);
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['Lig_Md5'][md5($Parms_Lig)] = $Parms_Lig;
       } else {
           $Md5_Lig = "nmgp_lig_edit_lapis?#?S?@?gloplanificacion?#?" . str_replace("'", "@aspass@", $this->pl_idplanificacion) . "?@?NM_run_iframe?#?1?@?";
       }
$nm_saida->saida("<a id=\"id_sc_field_beneficiarios_" . $this->SC_seq_page . "\" href=\"javascript:nm_gp_submit6('" . $this->Ini->link_grid_beneficiohogar_por_mes_cons . "', '$this->nm_location', '$Md5_Lig', '" . (isset($linkTarget) ? $linkTarget : 'nm_iframe_liga_B_grid_jdp_beneficiohogar_detalle') . "', 'B', '700px', '100%', 'inicio', '0', '0', '', 'grid_beneficiohogar_por_mes', '" . $this->SC_ancora . "')\" onMouseover=\"nm_mostra_hint(this, event, '')\" onMouseOut=\"nm_apaga_hint()\" class=\"" . $this->Ini->cor_link_dados . $this->css_sep . $this->css_beneficiarios_grid_line . "\">" . $conteudo . "</a>\r\n");
} else {
$nm_saida->saida(" <span id=\"id_sc_field_beneficiarios_" . $this->SC_seq_page . "\">$conteudo </span>\r\n");
       } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("   </tr></table></td>\r\n");
$nm_saida->saida("    </tr></table>\r\n");
 }
$nm_saida->saida("    </td></tr></table></td>\r\n");
          $this->rs_grid->MoveNext();
          $this->sc_proc_grid = false;
          $nm_quant_linhas++ ;
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] || $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] == "pdf" || $this->Ini->Apl_paginacao == "FULL")
          { 
              $nm_quant_linhas = 0; 
          } 
   }  
   $this->NM_Fecha_bloco("fim");
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'])
   { 
      $this->Lin_final = $this->rs_grid->EOF;
      if ($this->Lin_final)
      {
         $this->rs_grid->Close();
      }
   } 
   else
   {
      $this->rs_grid->Close();
   }
   if (method_exists($this->grid_beneficiohogar_avance, "close_emb")) 
   {
       $this->grid_beneficiohogar_avance->close_emb();
   }
   if (!$this->rs_grid->EOF) 
   { 
       if (isset($this->NM_tbody_open) && $this->NM_tbody_open)
       {
           $nm_saida->saida("    </TBODY>");
       }
   } 
   if ($this->rs_grid->EOF) 
   { 
  
       if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] || $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['exibe_total'] == "S")
       { 
           $Gb_geral = "quebra_geral_" . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Ind_Groupby'] . "_top";
           $this->$Gb_geral() ;
       } 
   }  
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida_grid'])
   {
       $nm_saida->saida("X##NM@@X");
   }
   $nm_saida->saida("</TABLE>");
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_psq'])
   { 
          $nm_saida->saida("       </form>\r\n");
   } 
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
   { 
       $this->Ini->Arr_result['setValue'][] = array('field' => 'sc_grid_body', 'value' => NM_charset_to_utf8($_SESSION['scriptcase']['saida_html']));
       $_SESSION['scriptcase']['saida_html'] = "";
   } 
   $nm_saida->saida("</TD>");
   $nm_saida->saida($fecha_tr);
   if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'])
   { 
       $_SESSION['scriptcase']['contr_link_emb'] = "";   
   } 
   if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "pdf" && empty($this->nm_grid_sem_reg) && 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "print" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != "print") 
   { 
       $nm_saida->saida("</TABLE></TD>\r\n");
       $nm_saida->saida("<TD style=\"padding: 0px; border-width: 0px;\" valign=\"top\" width=1>\r\n");
      $nm_saida->saida("     <iframe class=\"css_iframes\" id=\"nmsc_iframe_liga_DL_grid_jdp_beneficiohogar_detalle\" marginWidth=\"0px\" marginHeight=\"0px\" frameborder=\"0\" valign=\"top\" height=\"0px\" width=\"0px\" name=\"nm_iframe_liga_DL_grid_jdp_beneficiohogar_detalle\" scrolling=\"auto\" src=\"NM_Blank_Page.htm\"></iframe>\r\n");
       $nm_saida->saida("</TD>\r\n");
           $nm_saida->saida("    <TD style=\"padding: 0px; border-width: 0px; vertical-align: top;\">\r\n");
           $nm_saida->saida("     <iframe class=\"css_iframes\" id=\"nmsc_iframe_liga_D_grid_jdp_beneficiohogar_detalle\" marginWidth=\"0px\" marginHeight=\"0px\" frameborder=\"0\" valign=\"top\" height=\"0px\" width=\"0px\" name=\"nm_iframe_liga_D_grid_jdp_beneficiohogar_detalle\" scrolling=\"auto\" src=\"NM_Blank_Page.htm\"></iframe>\r\n");
           $nm_saida->saida("    </TD>\r\n");
           $nm_saida->saida("    </TR>\r\n");
           $nm_saida->saida("    </TABLE>\r\n");
           $nm_saida->saida("    </TD>\r\n");
   } 
           $nm_saida->saida("    </TR>\r\n");
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'])
   {
       $nm_saida->saida("</TABLE>\r\n");
   }
   if ($this->Print_All) 
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao']       = "igual" ; 
   } 
 }
 function NM_Fecha_bloco($opc="ok")
 {
   global $nm_saida;
   $nm_contr_percentual = 100 / $this->nm_grid_slides_linha; 
   $this->nm_contr_album = $this->nm_contr_album % $this->nm_grid_slides_linha;
   if ($this->nm_contr_album != 0 && $this->nm_contr_album != $this->nm_grid_slides_linha)
   {
       while ($this->nm_contr_album < $this->nm_grid_slides_linha)
       {
          $nm_saida->saida("  <td style=\"padding: 0px; vertical-align: top;\" width=\"" .  $nm_contr_percentual . "%\">\r\n");
          $nm_saida->saida("    <TABLE style=\"padding: 0px; border-spacing: 0px; border-width: 0px;\"  align=\"center\"  width=\"100%\">\r\n");
          $nm_saida->saida("      <TR>\r\n");
          $nm_saida->saida("        <TD>&nbsp;\r\n");
          $nm_saida->saida("        </TD>\r\n");
          $nm_saida->saida("      </TR>\r\n");
          $nm_saida->saida("    </TABLE>\r\n");
          $nm_saida->saida("  </td>\r\n");
          $this->nm_contr_album++;
       }
   }
   $this->nm_contr_album = 0;
   if ($this->Nm_bloco_aberto)
   {
       $this->Nm_bloco_aberto = false;
       if ($opc != "fim")
       {
           $nm_saida->saida("     </tr></table></td></tr>\r\n");
       }
       else
       {
           $nm_saida->saida("     </tr></table></td>\r\n");
       }
   }
 }
 function nm_quebra_pagina($nm_parms)
 {
    global $nm_saida;
    if ($this->nmgp_prim_pag_pdf && $nm_parms == "pagina")
    {
        $this->nmgp_prim_pag_pdf = false;
        return;
    }
    $this->Ini->nm_cont_lin++;
    if (($this->Ini->nm_limite_lin > 0 && $this->Ini->nm_cont_lin > $this->Ini->nm_limite_lin) || $nm_parms == "pagina" || $nm_parms == "resumo" || $nm_parms == "total")
    {
        $this->NM_Fecha_bloco();
        $this->Ini->nm_cont_lin = ($nm_parms == "pagina") ? 0 : 1;
        if ($this->Print_All)
        {
            if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['print_navigator']) && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['print_navigator'] == "Netscape")
            {
                $nm_saida->saida("</TABLE></TD></TR>\r\n");
                $nm_saida->saida("</TABLE><TABLE id=\"main_table_grid\" style=\"page-break-before:always;\" align=\"" . $this->Tab_align . "\" valign=\"" . $this->Tab_valign . "\" " . $this->Tab_width . ">\r\n");
                $nm_saida->saida("<TR><TD style=\"padding: 0px\"><TABLE width=\"100%\" style=\"padding: 0px; border-spacing: 0px; border-width: 0px;\">\r\n");
            }
            else
            {
                $nm_saida->saida("</TABLE><TABLE id=\"main_table_grid\" class=\"scGridBorder\" style=\"page-break-before:always;\" align=\"" . $this->Tab_align . "\" valign=\"" . $this->Tab_valign . "\" " . $this->Tab_width . ">\r\n");
            }
        }
        else
        {
            $nm_saida->saida("</table><div style=\"page-break-after: always;\"><span style=\"display: none;\">&nbsp;</span></div><table width='100%' cellspacing=0 cellpadding=0>\r\n");
        }
        if ($nm_parms != "resumo" && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'])
        {
           if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf']) { 
           }
           else
           {
               if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf_vert']) { 
                $nm_saida->saida("     <thead>\r\n");
               }
               $this->cabecalho();
               if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['proc_pdf_vert']) { 
                $nm_saida->saida("     </thead>\r\n");
               }
           }
        }
   $nm_saida->saida("    <TABLE align=\"center\" width=\"100%\" style=\"padding: 0px; border-spacing: 0px; border-width: 0px;\">\r\n");
   $nm_saida->saida("     <TR> \r\n");
    }
 }
 function quebra_geral_sc_free_total_top() 
 {
   global $nm_saida; 
   if (isset($this->NM_tbody_open) && $this->NM_tbody_open)
   {
       $nm_saida->saida("    </TBODY>");
   }
 }
 function quebra_geral_sc_free_total_bot() 
 {
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
   function nmgp_barra_top_normal()
   {
      global 
             $nm_saida, $nm_url_saida, $nm_apl_dependente;
      $NM_btn  = false;
      $NM_Gbtn = false;
      $nm_saida->saida("      <tr style=\"display: none\">\r\n");
      $nm_saida->saida("      <td>\r\n");
      $nm_saida->saida("      <form id=\"id_F0_top\" name=\"F0_top\" method=\"post\" action=\"./\" target=\"_self\"> \r\n");
      $nm_saida->saida("      <input type=\"text\" id=\"id_sc_truta_f0_top\" name=\"sc_truta_f0_top\" value=\"\"/> \r\n");
      $nm_saida->saida("      <input type=\"hidden\" id=\"script_init_f0_top\" name=\"script_case_init\" value=\"" . NM_encode_input($this->Ini->sc_page) . "\"/> \r\n");
      $nm_saida->saida("      <input type=\"hidden\" id=\"opcao_f0_top\" name=\"nmgp_opcao\" value=\"muda_qt_linhas\"/> \r\n");
      $nm_saida->saida("      </td></tr><tr id=\"sc_grid_toobar_top_tr\">\r\n");
      $nm_saida->saida("       <td id=\"sc_grid_toobar_top\"  colspan=3 class=\"" . $this->css_scGridTabelaTd . "\" valign=\"top\"> \r\n");
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
      { 
          $_SESSION['scriptcase']['saida_html'] = "";
      } 
      $nm_saida->saida("        <table id=\"sc_grid_toobar_top_table\" class=\"" . $this->css_scGridToolbar . "\" style=\"padding: 0px; border-spacing: 0px; border-width: 0px; vertical-align: top;\" width=\"100%\" valign=\"top\">\r\n");
      $nm_saida->saida("         <tr class=\"" . $this->css_scGridToolbarPadd . "_tr\"> \r\n");
      $nm_saida->saida("          <td class=\"" . $this->css_scGridToolbarPadd . "\" nowrap valign=\"middle\" align=\"left\" width=\"33%\"> \r\n");
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != "print") 
      {
      if (!$this->Ini->SC_Link_View && $this->nmgp_botoes['qsearch'] == "on")
      {
          $nm_saida->saida("           <script type=\"text/javascript\">var change_fast_top = \"\";</script>\r\n");
          $OPC_cmp = (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['fast_search'])) ? $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['fast_search'][0] : "";
          $OPC_arg = (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['fast_search'])) ? $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['fast_search'][1] : "";
          $OPC_dat = (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['fast_search'])) ? $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['fast_search'][2] : "";
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
          {
              $this->Ini->Arr_result['setVar'][] = array('var' => 'change_fast_top', 'value' => "");
          }
          if ($_SESSION['scriptcase']['charset'] != "UTF-8" && NM_is_utf8($OPC_cmp))
          {
              $OPC_cmp = NM_conv_charset($OPC_cmp, $_SESSION['scriptcase']['charset'], "UTF-8");
          }
          if ($_SESSION['scriptcase']['charset'] != "UTF-8" && NM_is_utf8($OPC_arg))
          {
              $OPC_arg = NM_conv_charset($OPC_arg, $_SESSION['scriptcase']['charset'], "UTF-8");
          }
          if ($_SESSION['scriptcase']['charset'] != "UTF-8" && NM_is_utf8($OPC_dat))
          {
              $OPC_dat = NM_conv_charset($OPC_dat, $_SESSION['scriptcase']['charset'], "UTF-8");
          }
          $stateSearchIconClose  = 'none';
          $stateSearchIconSearch = '';
          if(!empty($OPC_dat))
          {
              $stateSearchIconClose  = '';
              $stateSearchIconSearch = 'none';
          }
          $nm_saida->saida("          <input type=\"hidden\"  id=\"fast_search_f0_top\" name=\"nmgp_fast_search\" value=\"SC_all_Cmp\">\r\n");
          $nm_saida->saida("          <select id=\"cond_fast_search_f0_top\" class=\"" . $this->css_css_toolbar_obj . "\" style=\"vertical-align: middle;display:none;\" name=\"nmgp_cond_fast_search\" onChange=\"change_fast_top = 'CH';\">\r\n");
          $OPC_sel = " selected='selected'";
          $nm_saida->saida("           <option value=\"qp\"$OPC_sel>" . $this->Ini->Nm_lang['lang_srch_like'] . "</option>\r\n");
          $nm_saida->saida("          </select>\r\n");
          $nm_saida->saida("          <span id=\"quicksearchph_top\" class=\"" . $this->css_css_toolbar_obj . "\" style='display: inline-block; vertical-align: inherit;'>\r\n");
          $nm_saida->saida("           <span>\r\n");
          $nm_saida->saida("             <input type=\"text\" id=\"SC_fast_search_top\" class=\"" . $this->css_css_toolbar_obj . "_text\" style=\"border-width: 0px;\" name=\"nmgp_arg_fast_search\" value=\"" . NM_encode_input($OPC_dat) . "\" size=\"10\" onChange=\"change_fast_top = 'CH';\" alt=\"{maxLength: 255}\" placeholder=\"" . $this->Ini->Nm_lang['lang_othr_qk_watermark'] . "\">&nbsp;\r\n");
          $nm_saida->saida("             <img style=\"display: " . $stateSearchIconSearch . "\" id=\"SC_fast_search_submit_top\" class='css_toolbar_obj_qs_search_img' src=\"" . $this->Ini->path_botoes . "/" . $this->Ini->Img_qs_search . "\" onclick=\"nm_gp_submit_qsearch('top');\">\r\n");
          $nm_saida->saida("             <img style=\"display: " . $stateSearchIconClose . "\" class='css_toolbar_obj_qs_search_img' id=\"SC_fast_search_close_top\" src=\"" . $this->Ini->path_botoes . "/" . $this->Ini->Img_qs_clean . "\" onclick=\"document.getElementById('SC_fast_search_top').value = '__Clear_Fast__'; nm_gp_submit_qsearch('top');\">\r\n");
          $nm_saida->saida("            </span>\r\n");
          $nm_saida->saida("          </span>");
          $NM_btn = true;
      }
          $nm_saida->saida("         </td> \r\n");
          $nm_saida->saida("          <td class=\"" . $this->css_scGridToolbarPadd . "\" nowrap valign=\"middle\" align=\"center\" width=\"33%\"> \r\n");
      if ($this->nmgp_botoes['group_2'] == "on" && !$this->grid_emb_form)
      {
          $nm_saida->saida("           <script type=\"text/javascript\">var sc_itens_btgp_group_2_top = false;</script>\r\n");
          $Cod_Btn = nmButtonOutput($this->arr_buttons, "group_group_2", "scBtnGrpShow('group_2_top')", "scBtnGrpShow('group_2_top')", "sc_btgp_btn_group_2_top", "", "" . $this->Ini->Nm_lang['lang_btns_expt_email_title'] . "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "" . $this->Ini->Nm_lang['lang_btns_expt_email'] . "", "", "", "__sc_grp__", "text_fontawesomeicon", "text_right", "", "", "", "", "", "", "");
          $nm_saida->saida("           $Cod_Btn\r\n");
          $NM_btn  = true;
          $NM_Gbtn = false;
          $Cod_Btn = nmButtonGroupTableOutput($this->arr_buttons, "group_group_2", 'group_2', 'top', 'list', 'ini');
          $nm_saida->saida("           $Cod_Btn\r\n");
          $Cod_Btn = nmButtonGroupTableOutput($this->arr_buttons, "group_group_2", 'group_2', 'top', 'list', 'fim');
          $nm_saida->saida("           $Cod_Btn\r\n");
          $nm_saida->saida("           <script type=\"text/javascript\">\r\n");
          $nm_saida->saida("             if (!sc_itens_btgp_group_2_top) {\r\n");
          $nm_saida->saida("                 document.getElementById('sc_btgp_btn_group_2_top').style.display='none'; }\r\n");
          $nm_saida->saida("           </script>\r\n");
      }
      if ($this->nmgp_botoes['group_1'] == "on" && !$this->grid_emb_form)
      {
          $nm_saida->saida("           <script type=\"text/javascript\">var sc_itens_btgp_group_1_top = false;</script>\r\n");
          $Cod_Btn = nmButtonOutput($this->arr_buttons, "group_group_1", "scBtnGrpShow('group_1_top')", "scBtnGrpShow('group_1_top')", "sc_btgp_btn_group_1_top", "", "" . $this->Ini->Nm_lang['lang_btns_expt'] . "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "" . $this->Ini->Nm_lang['lang_btns_expt'] . "", "", "", "__sc_grp__", "text_fontawesomeicon", "text_right", "", "", "", "", "", "", "");
          $nm_saida->saida("           $Cod_Btn\r\n");
          $NM_btn  = true;
          $NM_Gbtn = false;
          $Cod_Btn = nmButtonGroupTableOutput($this->arr_buttons, "group_group_1", 'group_1', 'top', 'list', 'ini');
          $nm_saida->saida("           $Cod_Btn\r\n");
      if ($this->nmgp_botoes['pdf'] == "on" && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_psq'] && empty($this->nm_grid_sem_reg) && !$this->grid_emb_form)
      {
          $nm_saida->saida("           <script type=\"text/javascript\">sc_itens_btgp_group_1_top = true;</script>\r\n");
      $Tem_gb_pdf  = "s";
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Ind_Groupby'] == "sc_free_total")
      {
          $Tem_gb_pdf = "n";
      }
      $Tem_pdf_res = "n";
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Ind_Groupby'] != "sc_free_total")
      {
          $Tem_pdf_res = "s";
      }
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Ind_Groupby'] == "sc_free_group_by" && empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Gb_Free_cmp']))
      {
          $Tem_pdf_res = "n";
      }
              $this->nm_btn_exist['pdf'][] = "pdf_top";
          $nm_saida->saida("            <div id=\"div_pdf_top\" class=\"scBtnGrpText scBtnGrpClick\">\r\n");
              $Cod_Btn = nmButtonOutput($this->arr_buttons, "bpdf", "", "", "pdf_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "thickbox", "" . $this->Ini->path_link . "grid_jdp_beneficiohogar_detalle/grid_jdp_beneficiohogar_detalle_config_pdf.php?nm_opc=pdf&nm_target=0&nm_cor=cor&papel=8&lpapel=279&apapel=216&orientacao=1&bookmarks=1&largura=1200&conf_larg=S&conf_fonte=10&grafico=XX&sc_ver_93=s&nm_tem_gb=" . $Tem_gb_pdf . "&nm_res_cons=" . $Tem_pdf_res . "&nm_ini_pdf_res=grid,resume&nm_all_modules=grid,resume,chart&nm_label_group=N&nm_all_cab=S&nm_all_label=S&nm_orient_grid=4&password=n&summary_export_columns=N&pdf_zip=N&origem=cons&language=es&conf_socor=N&script_case_init=" . $this->Ini->sc_page . "&app_name=grid_jdp_beneficiohogar_detalle&KeepThis=true&TB_iframe=true&modal=true", "group_1", "only_text", "text_right", "", "", "", "", "", "", "");
              $nm_saida->saida("           $Cod_Btn \r\n");
          $nm_saida->saida("            </div>\r\n");
              $NM_Gbtn = true;
      }
      if ($this->nmgp_botoes['word'] == "on" && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_psq'] && empty($this->nm_grid_sem_reg) && !$this->grid_emb_form)
      {
          $nm_saida->saida("           <script type=\"text/javascript\">sc_itens_btgp_group_1_top = true;</script>\r\n");
          $Tem_word_res = "n";
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Ind_Groupby'] != "sc_free_total")
          {
              $Tem_word_res = "s";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Ind_Groupby'] == "sc_free_group_by" && empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Gb_Free_cmp']))
          {
              $Tem_word_res = "n";
          }
          $nm_saida->saida("            <div id=\"div_word_top\" class=\"scBtnGrpText scBtnGrpClick\">\r\n");
              $this->nm_btn_exist['word'][] = "word_top";
              $Cod_Btn = nmButtonOutput($this->arr_buttons, "bword", "", "", "word_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "thickbox", "" . $this->Ini->path_link . "grid_jdp_beneficiohogar_detalle/grid_jdp_beneficiohogar_detalle_config_word.php?script_case_init=" . $this->Ini->sc_page . "&summary_export_columns=N&nm_cor=CO&nm_res_cons=" . $Tem_word_res . "&nm_ini_word_res=grid,resume&nm_all_modules=grid,resume,chart&password=n&origem=cons&language=es&KeepThis=true&TB_iframe=true&modal=true", "group_1", "only_text", "text_right", "", "", "", "", "", "", "");
              $nm_saida->saida("           $Cod_Btn \r\n");
          $nm_saida->saida("            </div>\r\n");
              $NM_Gbtn = true;
      }
      if ($this->nmgp_botoes['xls'] == "on" && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_psq'] && empty($this->nm_grid_sem_reg) && !$this->grid_emb_form)
      {
          $nm_saida->saida("           <script type=\"text/javascript\">sc_itens_btgp_group_1_top = true;</script>\r\n");
          $Tem_xls_res = "n";
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Ind_Groupby'] != "sc_free_total")
          {
              $Tem_xls_res = "s";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Ind_Groupby'] == "sc_free_group_by" && empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Gb_Free_cmp']))
          {
              $Tem_xls_res = "n";
          }
          $nm_saida->saida("            <div id=\"div_xls_top\" class=\"scBtnGrpText scBtnGrpClick\">\r\n");
              $this->nm_btn_exist['xls'][] = "xls_top";
              $Cod_Btn = nmButtonOutput($this->arr_buttons, "bexcel", "", "", "xls_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "thickbox", "" . $this->Ini->path_link . "grid_jdp_beneficiohogar_detalle/grid_jdp_beneficiohogar_detalle_config_xls.php?script_case_init=" . $this->Ini->sc_page . "&app_name=grid_jdp_beneficiohogar_detalle&nm_tp_xls=xlsx&nm_tot_xls=S&nm_res_cons=" . $Tem_xls_res . "&nm_ini_xls_res=grid,resume&nm_all_modules=grid,resume,chart&password=n&summary_export_columns=N&origem=cons&language=es&KeepThis=true&TB_iframe=true&modal=true", "group_1", "only_text", "text_right", "", "", "", "", "", "", "");
              $nm_saida->saida("           $Cod_Btn \r\n");
          $nm_saida->saida("            </div>\r\n");
              $NM_Gbtn = true;
      }
      if ($this->nmgp_botoes['csv'] == "on" && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_psq'] && empty($this->nm_grid_sem_reg) && !$this->grid_emb_form)
      {
          $nm_saida->saida("           <script type=\"text/javascript\">sc_itens_btgp_group_1_top = true;</script>\r\n");
          $Tem_csv_res = "n";
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Ind_Groupby'] != "sc_free_total")
          {
              $Tem_csv_res = "s";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Ind_Groupby'] == "sc_free_group_by" && empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Gb_Free_cmp']))
          {
              $Tem_csv_res = "n";
          }
          $nm_saida->saida("            <div id=\"div_csv_top\" class=\"scBtnGrpText scBtnGrpClick\">\r\n");
              $this->nm_btn_exist['csv'][] = "csv_top";
              $Cod_Btn = nmButtonOutput($this->arr_buttons, "bcsv", "", "", "csv_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "thickbox", "" . $this->Ini->path_link . "grid_jdp_beneficiohogar_detalle/grid_jdp_beneficiohogar_detalle_config_csv.php?script_case_init=" . $this->Ini->sc_page . "&summary_export_columns=N&password=n&nm_res_cons=" . $Tem_csv_res . "&nm_ini_csv_res=grid,resume&nm_all_modules=grid,resume,chart&nm_delim_line=1&nm_delim_col=1&nm_delim_dados=1&nm_label_csv=N&language=&origem=cons&KeepThis=true&TB_iframe=true&modal=true", "group_1", "only_text", "text_right", "", "", "", "", "", "", "");
              $nm_saida->saida("           $Cod_Btn \r\n");
          $nm_saida->saida("            </div>\r\n");
              $NM_Gbtn = true;
      }
          if ($NM_Gbtn)
          {
                  $nm_saida->saida("           </td></tr><tr><td class=\"scBtnGrpBackground\">\r\n");
              $NM_Gbtn = false;
          }
      if ($this->nmgp_botoes['print'] == "on" && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_psq'] && empty($this->nm_grid_sem_reg) && !$this->grid_emb_form)
      {
          $Tem_pdf_res = "n";
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Ind_Groupby'] != "sc_free_total")
          {
              $Tem_pdf_res = "s";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Ind_Groupby'] == "sc_free_group_by" && empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Gb_Free_cmp']))
          {
              $Tem_pdf_res = "n";
          }
          $nm_saida->saida("           <script type=\"text/javascript\">sc_itens_btgp_group_1_top = true;</script>\r\n");
          $nm_saida->saida("            <div id=\"div_print_top\" class=\"scBtnGrpText scBtnGrpClick\">\r\n");
              $this->nm_btn_exist['print'][] = "print_top";
              $Cod_Btn = nmButtonOutput($this->arr_buttons, "bprint", "", "", "print_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "thickbox", "" . $this->Ini->path_link . "grid_jdp_beneficiohogar_detalle/grid_jdp_beneficiohogar_detalle_config_print.php?script_case_init=" . $this->Ini->sc_page . "&summary_export_columns=N&nm_opc=RC&nm_cor=CO&password=n&language=es&nm_page=" . NM_encode_input($this->Ini->sc_page) . "&nm_res_cons=" . $Tem_pdf_res . "&nm_ini_prt_res=grid,resume&nm_all_modules=grid,resume,chart&origem=cons&KeepThis=true&TB_iframe=true&modal=true", "group_1", "only_text", "text_right", "", "", "", "", "", "", "");
              $nm_saida->saida("           $Cod_Btn \r\n");
          $nm_saida->saida("            </div>\r\n");
              $NM_Gbtn = true;
      }
          $Cod_Btn = nmButtonGroupTableOutput($this->arr_buttons, "group_group_1", 'group_1', 'top', 'list', 'fim');
          $nm_saida->saida("           $Cod_Btn\r\n");
          $nm_saida->saida("           <script type=\"text/javascript\">\r\n");
          $nm_saida->saida("             if (!sc_itens_btgp_group_1_top) {\r\n");
          $nm_saida->saida("                 document.getElementById('sc_btgp_btn_group_1_top').style.display='none'; }\r\n");
          $nm_saida->saida("           </script>\r\n");
      }
      if (is_file($this->Ini->root . $this->Ini->path_img_global . $this->Ini->Img_sep_grid))
      {
          if ($NM_btn)
          {
              $NM_btn = false;
              $NM_ult_sep = "NM_sep_1";
              $nm_saida->saida("          <img id=\"NM_sep_1\" class=\"NM_toolbar_sep\" src=\"" . $this->Ini->path_img_global . $this->Ini->Img_sep_grid . "\" align=\"absmiddle\" style=\"vertical-align: middle;\">\r\n");
          }
      }
      if (!$this->Ini->SC_Link_View && $this->nmgp_botoes['filter'] == "on"  && !$this->grid_emb_form)
      {
           $this->nm_btn_exist['filter'][] = "pesq_top";
           $Cod_Btn = nmButtonOutput($this->arr_buttons, "bpesquisa", "nm_gp_move('busca', '0', 'grid');", "nm_gp_move('busca', '0', 'grid');", "pesq_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
           $nm_saida->saida("           $Cod_Btn \r\n");
           $NM_btn = true;
      }
          $nm_saida->saida("         </td> \r\n");
          $nm_saida->saida("          <td class=\"" . $this->css_scGridToolbarPadd . "\" nowrap valign=\"middle\" align=\"right\" width=\"33%\"> \r\n");
        if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Ind_Groupby'] != "sc_free_total")
        {
          if ($this->nmgp_botoes['summary'] == "on" && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_psq'] && empty($this->nm_grid_sem_reg) && !$this->grid_emb_form)
          {
              $this->nm_btn_exist['summary'][] = "res_top";
              if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['where_resumo']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['where_resumo'])) {
                  $Cod_Btn = nmButtonOutput($this->arr_buttons, "bvoltar", "nm_gp_move('resumo', '0');", "nm_gp_move('resumo', '0');", "res_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
              } 
              else { 
                  $Cod_Btn = nmButtonOutput($this->arr_buttons, "bresumo", "nm_gp_move('resumo', '0');", "nm_gp_move('resumo', '0');", "res_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
              } 
              $nm_saida->saida("           $Cod_Btn \r\n");
                  $NM_btn = true;
          }
        }
          if (is_file("grid_jdp_beneficiohogar_detalle_help.txt") && !$this->grid_emb_form)
          {
             $Arq_WebHelp = file("grid_jdp_beneficiohogar_detalle_help.txt"); 
             if (isset($Arq_WebHelp[0]) && !empty($Arq_WebHelp[0]))
             {
                 $Arq_WebHelp[0] = str_replace("\r\n" , "", trim($Arq_WebHelp[0]));
                 $Tmp = explode(";", $Arq_WebHelp[0]); 
                 foreach ($Tmp as $Cada_help)
                 {
                     $Tmp1 = explode(":", $Cada_help); 
                     if (!empty($Tmp1[0]) && isset($Tmp1[1]) && !empty($Tmp1[1]) && $Tmp1[0] == "cons" && is_file($this->Ini->root . $this->Ini->path_help . $Tmp1[1]))
                     {
                        $Cod_Btn = nmButtonOutput($this->arr_buttons, "bhelp", "nm_open_popup('" . $this->Ini->path_help . $Tmp1[1] . "');", "nm_open_popup('" . $this->Ini->path_help . $Tmp1[1] . "');", "help_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
                        $nm_saida->saida("           $Cod_Btn \r\n");
                        $NM_btn = true;
                     }
                 }
             }
          }
      if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['b_sair'] || $this->grid_emb_form || $this->grid_emb_form_full || (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['dashboard_info']['under_dashboard']) && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['dashboard_info']['under_dashboard']))
      {
         $this->nmgp_botoes['exit'] = "off"; 
      }
      if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_psq'])
      {
          $this->nm_btn_exist['exit'][] = "sai_top";
         if ($nm_apl_dependente == 1 && $this->nmgp_botoes['exit'] == "on") 
         { 
            $Cod_Btn = nmButtonOutput($this->arr_buttons, "bvoltar", "document.F5.action='$nm_url_saida'; document.F5.submit();", "document.F5.action='$nm_url_saida'; document.F5.submit();", "sai_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
            $nm_saida->saida("           $Cod_Btn \r\n");
            $NM_btn = true;
         } 
         elseif (!$this->Ini->SC_Link_View && !$this->aba_iframe && $this->nmgp_botoes['exit'] == "on") 
         { 
            $Cod_Btn = nmButtonOutput($this->arr_buttons, "bsair", "document.F5.action='$nm_url_saida'; document.F5.submit();", "document.F5.action='$nm_url_saida'; document.F5.submit();", "sai_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
            $nm_saida->saida("           $Cod_Btn \r\n");
            $NM_btn = true;
         } 
      }
      elseif ($this->nmgp_botoes['exit'] == "on")
      {
        if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['sc_modal']) && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['sc_modal'])
        {
           $Cod_Btn = nmButtonOutput($this->arr_buttons, "bvoltar", "self.parent.tb_remove()", "self.parent.tb_remove()", "sai_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
        }
        else
        {
           $Cod_Btn = nmButtonOutput($this->arr_buttons, "bvoltar", "window.close();", "window.close();", "sai_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
        }
         $nm_saida->saida("           $Cod_Btn \r\n");
         $NM_btn = true;
      }
      }
      $nm_saida->saida("         </td> \r\n");
      $nm_saida->saida("        </tr> \r\n");
      $nm_saida->saida("       </table> \r\n");
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
      { 
          $this->Ini->Arr_result['setValue'][] = array('field' => 'sc_grid_toobar_top', 'value' => NM_charset_to_utf8($_SESSION['scriptcase']['saida_html']));
          $_SESSION['scriptcase']['saida_html'] = "";
      } 
      $nm_saida->saida("      </td> \r\n");
      $nm_saida->saida("     </tr> \r\n");
      $nm_saida->saida("      <tr style=\"display: none\">\r\n");
      $nm_saida->saida("      <td> \r\n");
      $nm_saida->saida("     </form> \r\n");
      $nm_saida->saida("      </td> \r\n");
      $nm_saida->saida("     </tr> \r\n");
      if (!$NM_btn && isset($NM_ult_sep))
      {
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
          { 
              $this->Ini->Arr_result['setDisplay'][] = array('field' => $NM_ult_sep, 'value' => 'none');
          } 
          $nm_saida->saida("     <script language=\"javascript\">\r\n");
          $nm_saida->saida("        document.getElementById('" . $NM_ult_sep . "').style.display='none';\r\n");
          $nm_saida->saida("     </script>\r\n");
      }
   }
   function nmgp_barra_bot_normal()
   {
      global 
             $nm_saida, $nm_url_saida, $nm_apl_dependente;
      $NM_btn  = false;
      $NM_Gbtn = false;
      $nm_saida->saida("      <tr style=\"display: none\">\r\n");
      $nm_saida->saida("      <td>\r\n");
      $nm_saida->saida("      <form id=\"id_F0_bot\" name=\"F0_bot\" method=\"post\" action=\"./\" target=\"_self\"> \r\n");
      $nm_saida->saida("      <input type=\"text\" id=\"id_sc_truta_f0_bot\" name=\"sc_truta_f0_bot\" value=\"\"/> \r\n");
      $nm_saida->saida("      <input type=\"hidden\" id=\"script_init_f0_bot\" name=\"script_case_init\" value=\"" . NM_encode_input($this->Ini->sc_page) . "\"/> \r\n");
      $nm_saida->saida("      <input type=\"hidden\" id=\"opcao_f0_bot\" name=\"nmgp_opcao\" value=\"muda_qt_linhas\"/> \r\n");
      $nm_saida->saida("      </td></tr><tr id=\"sc_grid_toobar_bot_tr\">\r\n");
      $nm_saida->saida("       <td id=\"sc_grid_toobar_bot\"  colspan=3 class=\"" . $this->css_scGridTabelaTd . "\" valign=\"top\"> \r\n");
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
      { 
          $_SESSION['scriptcase']['saida_html'] = "";
      } 
      $nm_saida->saida("        <table id=\"sc_grid_toobar_bot_table\" class=\"" . $this->css_scGridToolbar . "\" style=\"padding: 0px; border-spacing: 0px; border-width: 0px; vertical-align: top;\" width=\"100%\" valign=\"top\">\r\n");
      $nm_saida->saida("         <tr class=\"" . $this->css_scGridToolbarPadd . "_tr\"> \r\n");
      $nm_saida->saida("          <td class=\"" . $this->css_scGridToolbarPadd . "\" nowrap valign=\"middle\" align=\"left\" width=\"33%\"> \r\n");
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != "print") 
      {
          if (empty($this->nm_grid_sem_reg) && $this->nmgp_botoes['goto'] == "on" && $this->Ini->Apl_paginacao != "FULL" )
          {
              $Reg_Page  = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_lin_grid'];
              $this->nm_btn_exist['goto'][] = "brec_bot";
              $Cod_Btn = nmButtonOutput($this->arr_buttons, "birpara", "var rec_nav = ((document.getElementById('rec_f0_bot').value - 1) * " . NM_encode_input($Reg_Page) . ") + 1; nm_gp_submit_ajax('muda_rec_linhas', rec_nav);", "var rec_nav = ((document.getElementById('rec_f0_bot').value - 1) * " . NM_encode_input($Reg_Page) . ") + 1; nm_gp_submit_ajax('muda_rec_linhas', rec_nav);", "brec_bot", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
              $nm_saida->saida("           $Cod_Btn \r\n");
              $Page_Atu   = ceil($this->nmgp_reg_inicial / $Reg_Page);
              $nm_saida->saida("          <input id=\"rec_f0_bot\" type=\"text\" class=\"" . $this->css_css_toolbar_obj . "\" name=\"rec\" value=\"" . NM_encode_input($Page_Atu) . "\" style=\"width:25px;vertical-align: middle;\"/> \r\n");
              $NM_btn = true;
          }
          if (empty($this->nm_grid_sem_reg) && $this->nmgp_botoes['qtline'] == "on" && $this->Ini->Apl_paginacao != "FULL")
          {
              $nm_saida->saida("          <span class=\"" . $this->css_css_toolbar_obj . "\" style=\"border: 0px;vertical-align: middle;\">" . $this->Ini->Nm_lang['lang_btns_rows'] . "</span>\r\n");
              $nm_saida->saida("          <select class=\"" . $this->css_css_toolbar_obj . "\" style=\"vertical-align: middle;\" id=\"quant_linhas_f0_bot\" name=\"nmgp_quant_linhas\" onchange=\"sc_ind = document.getElementById('quant_linhas_f0_bot').selectedIndex; nm_gp_submit_ajax('muda_qt_linhas', document.getElementById('quant_linhas_f0_bot').options[sc_ind].value + ';' + document.getElementById('quant_colunas_f0_bot').value);\"> \r\n");
              $obj_sel = ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_lin_grid'] == 1) ? " selected" : "";
              $nm_saida->saida("           <option value=\"1\" " . $obj_sel . ">1</option>\r\n");
              $obj_sel = ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_lin_grid'] == 10) ? " selected" : "";
              $nm_saida->saida("           <option value=\"10\" " . $obj_sel . ">10</option>\r\n");
              $obj_sel = ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_lin_grid'] == 20) ? " selected" : "";
              $nm_saida->saida("           <option value=\"20\" " . $obj_sel . ">20</option>\r\n");
              $obj_sel = ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_lin_grid'] == 50) ? " selected" : "";
              $nm_saida->saida("           <option value=\"50\" " . $obj_sel . ">50</option>\r\n");
              $nm_saida->saida("          </select>\r\n");
              $nm_saida->saida("          <input type=\"text\" class=\"" . $this->css_css_toolbar_obj . "\" id=\"quant_colunas_f0_bot\" name=\"nmgp_quant_colunas\" value=\"" . NM_encode_input($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_col_grid']) . "\" onchange=\"sc_ind = document.getElementById('quant_linhas_f0_bot').selectedIndex; nm_gp_submit_ajax('muda_qt_linhas', document.getElementById('quant_linhas_f0_bot').options[sc_ind].value + ';' + document.getElementById('quant_colunas_f0_bot').value);\" style=\"width:25px;vertical-align: middle;\"/> \r\n");
              $NM_btn = true;
          }
          $nm_saida->saida("         </td> \r\n");
          $nm_saida->saida("          <td class=\"" . $this->css_scGridToolbarPadd . "\" nowrap valign=\"middle\" align=\"center\" width=\"33%\"> \r\n");
          if ($this->nmgp_botoes['first'] == "on" && empty($this->nm_grid_sem_reg) && $this->Ini->Apl_paginacao != "FULL" && !isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_liga']['nav']))
          {
              $this->nm_btn_exist['first'][] = "first_bot";
              if ($this->Rec_ini == 0)
              {
                  $Cod_Btn = nmButtonOutput($this->arr_buttons, "bcons_inicio", "nm_gp_submit_rec('ini');", "nm_gp_submit_rec('ini');", "first_bot", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "disabled", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
                  $nm_saida->saida("           $Cod_Btn \r\n");
              }
              else
              {
                  $Cod_Btn = nmButtonOutput($this->arr_buttons, "bcons_inicio", "nm_gp_submit_rec('ini');", "nm_gp_submit_rec('ini');", "first_bot", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
                  $nm_saida->saida("           $Cod_Btn \r\n");
              }
                  $NM_btn = true;
          }
          if ($this->nmgp_botoes['back'] == "on" && empty($this->nm_grid_sem_reg) && $this->Ini->Apl_paginacao != "FULL" && !isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_liga']['nav']))
          {
              $this->nm_btn_exist['back'][] = "back_bot";
              if ($this->Rec_ini == 0)
              {
                  $Cod_Btn = nmButtonOutput($this->arr_buttons, "bcons_retorna", "nm_gp_submit_rec('" . $this->Rec_ini . "');", "nm_gp_submit_rec('" . $this->Rec_ini . "');", "back_bot", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "disabled", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
                  $nm_saida->saida("           $Cod_Btn \r\n");
              }
              else
              {
                  $Cod_Btn = nmButtonOutput($this->arr_buttons, "bcons_retorna", "nm_gp_submit_rec('" . $this->Rec_ini . "');", "nm_gp_submit_rec('" . $this->Rec_ini . "');", "back_bot", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
                  $nm_saida->saida("           $Cod_Btn \r\n");
              }
                  $NM_btn = true;
          }
          if (empty($this->nm_grid_sem_reg) && $this->nmgp_botoes['navpage'] == "on" && !isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_liga']['nav']) && $this->Ini->Apl_paginacao != "FULL" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_lin_grid'] != "all")
          {
              $Reg_Page  = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_lin_grid'] * $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_col_grid'];
              $Max_link   = 5;
              $Mid_link   = ceil($Max_link / 2);
              $Corr_link  = (($Max_link % 2) == 0) ? 0 : 1;
              $Qtd_Pages  = ceil($this->count_ger / $Reg_Page);
              $Page_Atu   = ceil($this->nmgp_reg_final / $Reg_Page);
              $Link_ini   = 1;
              if ($Page_Atu > $Max_link)
              {
                  $Link_ini = $Page_Atu - $Mid_link + $Corr_link;
              }
              elseif ($Page_Atu > $Mid_link)
              {
                  $Link_ini = $Page_Atu - $Mid_link + $Corr_link;
              }
              if (($Qtd_Pages - $Link_ini) < $Max_link)
              {
                  $Link_ini = ($Qtd_Pages - $Max_link) + 1;
              }
              if ($Link_ini < 1)
              {
                  $Link_ini = 1;
              }
              for ($x = 0; $x < $Max_link && $Link_ini <= $Qtd_Pages; $x++)
              {
                  $rec = (($Link_ini - 1) * $Reg_Page) + 1;
                  if ($Link_ini == $Page_Atu)
                  {
                      $nm_saida->saida("            <span class=\"scGridToolbarNavOpen\" style=\"vertical-align: middle;\">" . $Link_ini . "</span>\r\n");
                  }
                  else
                  {
                      $nm_saida->saida("            <a class=\"scGridToolbarNav\" style=\"vertical-align: middle;\" href=\"javascript: nm_gp_submit_rec(" . $rec . ");\">" . $Link_ini . "</a>\r\n");
                  }
                  $Link_ini++;
                  if (($x + 1) < $Max_link && $Link_ini <= $Qtd_Pages && '' != $this->Ini->Str_toolbarnav_separator && @is_file($this->Ini->root . $this->Ini->path_img_global . $this->Ini->Str_toolbarnav_separator))
                  {
                      $nm_saida->saida("            <img src=\"" . $this->Ini->path_img_global . $this->Ini->Str_toolbarnav_separator . "\" align=\"absmiddle\" style=\"vertical-align: middle;\">\r\n");
                  }
              }
              $NM_btn = true;
          }
          if ($this->nmgp_botoes['forward'] == "on" && empty($this->nm_grid_sem_reg) && $this->Ini->Apl_paginacao != "FULL" && !isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_liga']['nav']))
          {
              $this->nm_btn_exist['forward'][] = "forward_bot";
              $Cod_Btn = nmButtonOutput($this->arr_buttons, "bcons_avanca", "nm_gp_submit_rec('" . $this->Rec_fim . "');", "nm_gp_submit_rec('" . $this->Rec_fim . "');", "forward_bot", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
              $nm_saida->saida("           $Cod_Btn \r\n");
              $NM_btn = true;
          }
          if ($this->nmgp_botoes['last'] == "on" && empty($this->nm_grid_sem_reg) && $this->Ini->Apl_paginacao != "FULL" && !isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_liga']['nav']))
          {
              $this->nm_btn_exist['last'][] = "last_bot";
              $Cod_Btn = nmButtonOutput($this->arr_buttons, "bcons_final", "nm_gp_submit_rec('fim');", "nm_gp_submit_rec('fim');", "last_bot", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
              $nm_saida->saida("           $Cod_Btn \r\n");
              $NM_btn = true;
          }
          $nm_saida->saida("         </td> \r\n");
          $nm_saida->saida("          <td class=\"" . $this->css_scGridToolbarPadd . "\" nowrap valign=\"middle\" align=\"right\" width=\"33%\"> \r\n");
          if ($this->nmgp_botoes['rows'] == "on" && empty($this->nm_grid_sem_reg))
          {
              $nm_sumario = "[" . $this->Ini->Nm_lang['lang_othr_smry_info'] . "]";
              $nm_sumario = str_replace("?start?", $this->nmgp_reg_inicial, $nm_sumario);
              if ($this->Ini->Apl_paginacao == "FULL")
              {
                  $nm_sumario = str_replace("?final?", "<span class='sm_counter_final'>".$this->count_ger."</span>", $nm_sumario);
              }
              else
              {
                  $nm_sumario = str_replace("?final?", "<span class='sm_counter_final'>".$this->nmgp_reg_final."</span>", $nm_sumario);
              }
              $nm_sumario = str_replace("?total?", "<span class='sm_counter_total'>".$this->count_ger."</span>", $nm_sumario);
              $nm_saida->saida("           <span class=\"summary_indicator " . $this->css_css_toolbar_obj . "\" style=\"border:0px;\"><span class='sm_counter'>" . $nm_sumario . "</span></span>\r\n");
              $NM_btn = true;
          }
          if (is_file("grid_jdp_beneficiohogar_detalle_help.txt") && !$this->grid_emb_form)
          {
             $Arq_WebHelp = file("grid_jdp_beneficiohogar_detalle_help.txt"); 
             if (isset($Arq_WebHelp[0]) && !empty($Arq_WebHelp[0]))
             {
                 $Arq_WebHelp[0] = str_replace("\r\n" , "", trim($Arq_WebHelp[0]));
                 $Tmp = explode(";", $Arq_WebHelp[0]); 
                 foreach ($Tmp as $Cada_help)
                 {
                     $Tmp1 = explode(":", $Cada_help); 
                     if (!empty($Tmp1[0]) && isset($Tmp1[1]) && !empty($Tmp1[1]) && $Tmp1[0] == "cons" && is_file($this->Ini->root . $this->Ini->path_help . $Tmp1[1]))
                     {
                        $Cod_Btn = nmButtonOutput($this->arr_buttons, "bhelp", "nm_open_popup('" . $this->Ini->path_help . $Tmp1[1] . "');", "nm_open_popup('" . $this->Ini->path_help . $Tmp1[1] . "');", "help_bot", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
                        $nm_saida->saida("           $Cod_Btn \r\n");
                        $NM_btn = true;
                     }
                 }
             }
          }
      }
      $nm_saida->saida("         </td> \r\n");
      $nm_saida->saida("        </tr> \r\n");
      $nm_saida->saida("       </table> \r\n");
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
      { 
          $this->Ini->Arr_result['setValue'][] = array('field' => 'sc_grid_toobar_bot', 'value' => NM_charset_to_utf8($_SESSION['scriptcase']['saida_html']));
          $_SESSION['scriptcase']['saida_html'] = "";
      } 
      $nm_saida->saida("      </td> \r\n");
      $nm_saida->saida("     </tr> \r\n");
      $nm_saida->saida("      <tr style=\"display: none\">\r\n");
      $nm_saida->saida("      <td> \r\n");
      $nm_saida->saida("     </form> \r\n");
      $nm_saida->saida("      </td> \r\n");
      $nm_saida->saida("     </tr> \r\n");
      if (!$NM_btn && isset($NM_ult_sep))
      {
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
          { 
              $this->Ini->Arr_result['setDisplay'][] = array('field' => $NM_ult_sep, 'value' => 'none');
          } 
          $nm_saida->saida("     <script language=\"javascript\">\r\n");
          $nm_saida->saida("        document.getElementById('" . $NM_ult_sep . "').style.display='none';\r\n");
          $nm_saida->saida("     </script>\r\n");
      }
   }
   function nmgp_barra_top_mobile()
   {
      global 
             $nm_saida, $nm_url_saida, $nm_apl_dependente;
      $NM_btn  = false;
      $NM_Gbtn = false;
      $nm_saida->saida("      <tr style=\"display: none\">\r\n");
      $nm_saida->saida("      <td>\r\n");
      $nm_saida->saida("      <form id=\"id_F0_top\" name=\"F0_top\" method=\"post\" action=\"./\" target=\"_self\"> \r\n");
      $nm_saida->saida("      <input type=\"text\" id=\"id_sc_truta_f0_top\" name=\"sc_truta_f0_top\" value=\"\"/> \r\n");
      $nm_saida->saida("      <input type=\"hidden\" id=\"script_init_f0_top\" name=\"script_case_init\" value=\"" . NM_encode_input($this->Ini->sc_page) . "\"/> \r\n");
      $nm_saida->saida("      <input type=\"hidden\" id=\"opcao_f0_top\" name=\"nmgp_opcao\" value=\"muda_qt_linhas\"/> \r\n");
      $nm_saida->saida("      </td></tr><tr id=\"sc_grid_toobar_top_tr\">\r\n");
      $nm_saida->saida("       <td id=\"sc_grid_toobar_top\"  colspan=3 class=\"" . $this->css_scGridTabelaTd . "\" valign=\"top\"> \r\n");
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
      { 
          $_SESSION['scriptcase']['saida_html'] = "";
      } 
      $nm_saida->saida("        <table id=\"sc_grid_toobar_top_table\" class=\"" . $this->css_scGridToolbar . "\" style=\"padding: 0px; border-spacing: 0px; border-width: 0px; vertical-align: top;\" width=\"100%\" valign=\"top\">\r\n");
      $nm_saida->saida("         <tr class=\"" . $this->css_scGridToolbarPadd . "_tr\"> \r\n");
      $nm_saida->saida("          <td class=\"" . $this->css_scGridToolbarPadd . "\" nowrap valign=\"middle\" align=\"left\" width=\"33%\"> \r\n");
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != "print") 
      {
      if (!$this->Ini->SC_Link_View && $this->nmgp_botoes['qsearch'] == "on")
      {
          $nm_saida->saida("           <script type=\"text/javascript\">var change_fast_top = \"\";</script>\r\n");
          $OPC_cmp = (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['fast_search'])) ? $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['fast_search'][0] : "";
          $OPC_arg = (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['fast_search'])) ? $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['fast_search'][1] : "";
          $OPC_dat = (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['fast_search'])) ? $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['fast_search'][2] : "";
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
          {
              $this->Ini->Arr_result['setVar'][] = array('var' => 'change_fast_top', 'value' => "");
          }
          if ($_SESSION['scriptcase']['charset'] != "UTF-8" && NM_is_utf8($OPC_cmp))
          {
              $OPC_cmp = NM_conv_charset($OPC_cmp, $_SESSION['scriptcase']['charset'], "UTF-8");
          }
          if ($_SESSION['scriptcase']['charset'] != "UTF-8" && NM_is_utf8($OPC_arg))
          {
              $OPC_arg = NM_conv_charset($OPC_arg, $_SESSION['scriptcase']['charset'], "UTF-8");
          }
          if ($_SESSION['scriptcase']['charset'] != "UTF-8" && NM_is_utf8($OPC_dat))
          {
              $OPC_dat = NM_conv_charset($OPC_dat, $_SESSION['scriptcase']['charset'], "UTF-8");
          }
          $stateSearchIconClose  = 'none';
          $stateSearchIconSearch = '';
          if(!empty($OPC_dat))
          {
              $stateSearchIconClose  = '';
              $stateSearchIconSearch = 'none';
          }
          $nm_saida->saida("          <input type=\"hidden\"  id=\"fast_search_f0_top\" name=\"nmgp_fast_search\" value=\"SC_all_Cmp\">\r\n");
          $nm_saida->saida("          <select id=\"cond_fast_search_f0_top\" class=\"" . $this->css_css_toolbar_obj . "\" style=\"vertical-align: middle;display:none;\" name=\"nmgp_cond_fast_search\" onChange=\"change_fast_top = 'CH';\">\r\n");
          $OPC_sel = " selected='selected'";
          $nm_saida->saida("           <option value=\"qp\"$OPC_sel>" . $this->Ini->Nm_lang['lang_srch_like'] . "</option>\r\n");
          $nm_saida->saida("          </select>\r\n");
          $nm_saida->saida("          <span id=\"quicksearchph_top\" class=\"" . $this->css_css_toolbar_obj . "\" style='display: inline-block; vertical-align: inherit;'>\r\n");
          $nm_saida->saida("           <span>\r\n");
          $nm_saida->saida("             <input type=\"text\" id=\"SC_fast_search_top\" class=\"" . $this->css_css_toolbar_obj . "_text\" style=\"border-width: 0px;\" name=\"nmgp_arg_fast_search\" value=\"" . NM_encode_input($OPC_dat) . "\" size=\"10\" onChange=\"change_fast_top = 'CH';\" alt=\"{maxLength: 255}\" placeholder=\"" . $this->Ini->Nm_lang['lang_othr_qk_watermark'] . "\">&nbsp;\r\n");
          $nm_saida->saida("             <img style=\"display: " . $stateSearchIconSearch . "\" id=\"SC_fast_search_submit_top\" class='css_toolbar_obj_qs_search_img' src=\"" . $this->Ini->path_botoes . "/" . $this->Ini->Img_qs_search . "\" onclick=\"nm_gp_submit_qsearch('top');\">\r\n");
          $nm_saida->saida("             <img style=\"display: " . $stateSearchIconClose . "\" class='css_toolbar_obj_qs_search_img' id=\"SC_fast_search_close_top\" src=\"" . $this->Ini->path_botoes . "/" . $this->Ini->Img_qs_clean . "\" onclick=\"document.getElementById('SC_fast_search_top').value = '__Clear_Fast__'; nm_gp_submit_qsearch('top');\">\r\n");
          $nm_saida->saida("            </span>\r\n");
          $nm_saida->saida("          </span>");
          $NM_btn = true;
      }
      if ($this->nmgp_botoes['group_4'] == "on" && !$this->grid_emb_form)
      {
          $nm_saida->saida("           <script type=\"text/javascript\">var sc_itens_btgp_group_4_top = false;</script>\r\n");
          $Cod_Btn = nmButtonOutput($this->arr_buttons, "group_group_4", "scBtnGrpShow('group_4_top')", "scBtnGrpShow('group_4_top')", "sc_btgp_btn_group_4_top", "", "" . $this->Ini->Nm_lang['lang_btns_expt_email_title'] . "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "" . $this->Ini->Nm_lang['lang_btns_expt_email'] . "", "", "", "__sc_grp__", "text_fontawesomeicon", "text_right", "", "", "", "", "", "", "");
          $nm_saida->saida("           $Cod_Btn\r\n");
          $NM_btn  = true;
          $NM_Gbtn = false;
          $Cod_Btn = nmButtonGroupTableOutput($this->arr_buttons, "group_group_4", 'group_4', 'top', 'list', 'ini');
          $nm_saida->saida("           $Cod_Btn\r\n");
          $Cod_Btn = nmButtonGroupTableOutput($this->arr_buttons, "group_group_4", 'group_4', 'top', 'list', 'fim');
          $nm_saida->saida("           $Cod_Btn\r\n");
          $nm_saida->saida("           <script type=\"text/javascript\">\r\n");
          $nm_saida->saida("             if (!sc_itens_btgp_group_4_top) {\r\n");
          $nm_saida->saida("                 document.getElementById('sc_btgp_btn_group_4_top').style.display='none'; }\r\n");
          $nm_saida->saida("           </script>\r\n");
      }
      if ($this->nmgp_botoes['group_3'] == "on" && !$this->grid_emb_form)
      {
          $nm_saida->saida("           <script type=\"text/javascript\">var sc_itens_btgp_group_3_top = false;</script>\r\n");
          $Cod_Btn = nmButtonOutput($this->arr_buttons, "group_group_3", "scBtnGrpShow('group_3_top')", "scBtnGrpShow('group_3_top')", "sc_btgp_btn_group_3_top", "", "" . $this->Ini->Nm_lang['lang_btns_expt'] . "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "" . $this->Ini->Nm_lang['lang_btns_expt'] . "", "", "", "__sc_grp__", "text_fontawesomeicon", "text_right", "", "", "", "", "", "", "");
          $nm_saida->saida("           $Cod_Btn\r\n");
          $NM_btn  = true;
          $NM_Gbtn = false;
          $Cod_Btn = nmButtonGroupTableOutput($this->arr_buttons, "group_group_3", 'group_3', 'top', 'list', 'ini');
          $nm_saida->saida("           $Cod_Btn\r\n");
      if ($this->nmgp_botoes['pdf'] == "on" && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_psq'] && empty($this->nm_grid_sem_reg) && !$this->grid_emb_form)
      {
          $nm_saida->saida("           <script type=\"text/javascript\">sc_itens_btgp_group_3_top = true;</script>\r\n");
      $Tem_gb_pdf  = "s";
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Ind_Groupby'] == "sc_free_total")
      {
          $Tem_gb_pdf = "n";
      }
      $Tem_pdf_res = "n";
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Ind_Groupby'] != "sc_free_total")
      {
          $Tem_pdf_res = "s";
      }
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Ind_Groupby'] == "sc_free_group_by" && empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Gb_Free_cmp']))
      {
          $Tem_pdf_res = "n";
      }
              $this->nm_btn_exist['pdf'][] = "pdf_top";
          $nm_saida->saida("            <div id=\"div_pdf_top\" class=\"scBtnGrpText scBtnGrpClick\">\r\n");
              $Cod_Btn = nmButtonOutput($this->arr_buttons, "bpdf", "", "", "pdf_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "thickbox", "" . $this->Ini->path_link . "grid_jdp_beneficiohogar_detalle/grid_jdp_beneficiohogar_detalle_config_pdf.php?nm_opc=pdf&nm_target=0&nm_cor=cor&papel=8&lpapel=279&apapel=216&orientacao=1&bookmarks=1&largura=1200&conf_larg=S&conf_fonte=10&grafico=XX&sc_ver_93=s&nm_tem_gb=" . $Tem_gb_pdf . "&nm_res_cons=" . $Tem_pdf_res . "&nm_ini_pdf_res=grid,resume&nm_all_modules=grid,resume,chart&nm_label_group=N&nm_all_cab=S&nm_all_label=S&nm_orient_grid=4&password=n&summary_export_columns=N&pdf_zip=N&origem=cons&language=es&conf_socor=N&script_case_init=" . $this->Ini->sc_page . "&app_name=grid_jdp_beneficiohogar_detalle&KeepThis=true&TB_iframe=true&modal=true", "group_3", "only_text", "text_right", "", "", "", "", "", "", "");
              $nm_saida->saida("           $Cod_Btn \r\n");
          $nm_saida->saida("            </div>\r\n");
              $NM_Gbtn = true;
      }
      if ($this->nmgp_botoes['word'] == "on" && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_psq'] && empty($this->nm_grid_sem_reg) && !$this->grid_emb_form)
      {
          $nm_saida->saida("           <script type=\"text/javascript\">sc_itens_btgp_group_3_top = true;</script>\r\n");
          $Tem_word_res = "n";
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Ind_Groupby'] != "sc_free_total")
          {
              $Tem_word_res = "s";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Ind_Groupby'] == "sc_free_group_by" && empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Gb_Free_cmp']))
          {
              $Tem_word_res = "n";
          }
          $nm_saida->saida("            <div id=\"div_word_top\" class=\"scBtnGrpText scBtnGrpClick\">\r\n");
              $this->nm_btn_exist['word'][] = "word_top";
              $Cod_Btn = nmButtonOutput($this->arr_buttons, "bword", "", "", "word_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "thickbox", "" . $this->Ini->path_link . "grid_jdp_beneficiohogar_detalle/grid_jdp_beneficiohogar_detalle_config_word.php?script_case_init=" . $this->Ini->sc_page . "&summary_export_columns=N&nm_cor=CO&nm_res_cons=" . $Tem_word_res . "&nm_ini_word_res=grid,resume&nm_all_modules=grid,resume,chart&password=n&origem=cons&language=es&KeepThis=true&TB_iframe=true&modal=true", "group_3", "only_text", "text_right", "", "", "", "", "", "", "");
              $nm_saida->saida("           $Cod_Btn \r\n");
          $nm_saida->saida("            </div>\r\n");
              $NM_Gbtn = true;
      }
      if ($this->nmgp_botoes['xls'] == "on" && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_psq'] && empty($this->nm_grid_sem_reg) && !$this->grid_emb_form)
      {
          $nm_saida->saida("           <script type=\"text/javascript\">sc_itens_btgp_group_3_top = true;</script>\r\n");
          $Tem_xls_res = "n";
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Ind_Groupby'] != "sc_free_total")
          {
              $Tem_xls_res = "s";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Ind_Groupby'] == "sc_free_group_by" && empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Gb_Free_cmp']))
          {
              $Tem_xls_res = "n";
          }
          $nm_saida->saida("            <div id=\"div_xls_top\" class=\"scBtnGrpText scBtnGrpClick\">\r\n");
              $this->nm_btn_exist['xls'][] = "xls_top";
              $Cod_Btn = nmButtonOutput($this->arr_buttons, "bexcel", "", "", "xls_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "thickbox", "" . $this->Ini->path_link . "grid_jdp_beneficiohogar_detalle/grid_jdp_beneficiohogar_detalle_config_xls.php?script_case_init=" . $this->Ini->sc_page . "&app_name=grid_jdp_beneficiohogar_detalle&nm_tp_xls=xlsx&nm_tot_xls=S&nm_res_cons=" . $Tem_xls_res . "&nm_ini_xls_res=grid,resume&nm_all_modules=grid,resume,chart&password=n&summary_export_columns=N&origem=cons&language=es&KeepThis=true&TB_iframe=true&modal=true", "group_3", "only_text", "text_right", "", "", "", "", "", "", "");
              $nm_saida->saida("           $Cod_Btn \r\n");
          $nm_saida->saida("            </div>\r\n");
              $NM_Gbtn = true;
      }
      if ($this->nmgp_botoes['csv'] == "on" && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_psq'] && empty($this->nm_grid_sem_reg) && !$this->grid_emb_form)
      {
          $nm_saida->saida("           <script type=\"text/javascript\">sc_itens_btgp_group_3_top = true;</script>\r\n");
          $Tem_csv_res = "n";
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Ind_Groupby'] != "sc_free_total")
          {
              $Tem_csv_res = "s";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Ind_Groupby'] == "sc_free_group_by" && empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Gb_Free_cmp']))
          {
              $Tem_csv_res = "n";
          }
          $nm_saida->saida("            <div id=\"div_csv_top\" class=\"scBtnGrpText scBtnGrpClick\">\r\n");
              $this->nm_btn_exist['csv'][] = "csv_top";
              $Cod_Btn = nmButtonOutput($this->arr_buttons, "bcsv", "", "", "csv_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "thickbox", "" . $this->Ini->path_link . "grid_jdp_beneficiohogar_detalle/grid_jdp_beneficiohogar_detalle_config_csv.php?script_case_init=" . $this->Ini->sc_page . "&summary_export_columns=N&password=n&nm_res_cons=" . $Tem_csv_res . "&nm_ini_csv_res=grid,resume&nm_all_modules=grid,resume,chart&nm_delim_line=1&nm_delim_col=1&nm_delim_dados=1&nm_label_csv=N&language=&origem=cons&KeepThis=true&TB_iframe=true&modal=true", "group_3", "only_text", "text_right", "", "", "", "", "", "", "");
              $nm_saida->saida("           $Cod_Btn \r\n");
          $nm_saida->saida("            </div>\r\n");
              $NM_Gbtn = true;
      }
          if ($NM_Gbtn)
          {
                  $nm_saida->saida("           </td></tr><tr><td class=\"scBtnGrpBackground\">\r\n");
              $NM_Gbtn = false;
          }
      if ($this->nmgp_botoes['print'] == "on" && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_psq'] && empty($this->nm_grid_sem_reg) && !$this->grid_emb_form)
      {
          $Tem_pdf_res = "n";
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Ind_Groupby'] != "sc_free_total")
          {
              $Tem_pdf_res = "s";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Ind_Groupby'] == "sc_free_group_by" && empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Gb_Free_cmp']))
          {
              $Tem_pdf_res = "n";
          }
          $nm_saida->saida("           <script type=\"text/javascript\">sc_itens_btgp_group_3_top = true;</script>\r\n");
          $nm_saida->saida("            <div id=\"div_print_top\" class=\"scBtnGrpText scBtnGrpClick\">\r\n");
              $this->nm_btn_exist['print'][] = "print_top";
              $Cod_Btn = nmButtonOutput($this->arr_buttons, "bprint", "", "", "print_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "thickbox", "" . $this->Ini->path_link . "grid_jdp_beneficiohogar_detalle/grid_jdp_beneficiohogar_detalle_config_print.php?script_case_init=" . $this->Ini->sc_page . "&summary_export_columns=N&nm_opc=RC&nm_cor=CO&password=n&language=es&nm_page=" . NM_encode_input($this->Ini->sc_page) . "&nm_res_cons=" . $Tem_pdf_res . "&nm_ini_prt_res=grid,resume&nm_all_modules=grid,resume,chart&origem=cons&KeepThis=true&TB_iframe=true&modal=true", "group_3", "only_text", "text_right", "", "", "", "", "", "", "");
              $nm_saida->saida("           $Cod_Btn \r\n");
          $nm_saida->saida("            </div>\r\n");
              $NM_Gbtn = true;
      }
          $Cod_Btn = nmButtonGroupTableOutput($this->arr_buttons, "group_group_3", 'group_3', 'top', 'list', 'fim');
          $nm_saida->saida("           $Cod_Btn\r\n");
          $nm_saida->saida("           <script type=\"text/javascript\">\r\n");
          $nm_saida->saida("             if (!sc_itens_btgp_group_3_top) {\r\n");
          $nm_saida->saida("                 document.getElementById('sc_btgp_btn_group_3_top').style.display='none'; }\r\n");
          $nm_saida->saida("           </script>\r\n");
      }
      if (is_file($this->Ini->root . $this->Ini->path_img_global . $this->Ini->Img_sep_grid))
      {
          if ($NM_btn)
          {
              $NM_btn = false;
              $NM_ult_sep = "NM_sep_2";
              $nm_saida->saida("          <img id=\"NM_sep_2\" class=\"NM_toolbar_sep\" src=\"" . $this->Ini->path_img_global . $this->Ini->Img_sep_grid . "\" align=\"absmiddle\" style=\"vertical-align: middle;\">\r\n");
          }
      }
      if (!$this->Ini->SC_Link_View && $this->nmgp_botoes['filter'] == "on"  && !$this->grid_emb_form)
      {
           $this->nm_btn_exist['filter'][] = "pesq_top";
           $Cod_Btn = nmButtonOutput($this->arr_buttons, "bpesquisa", "nm_gp_move('busca', '0', 'grid');", "nm_gp_move('busca', '0', 'grid');", "pesq_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
           $nm_saida->saida("           $Cod_Btn \r\n");
           $NM_btn = true;
      }
        if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['SC_Ind_Groupby'] != "sc_free_total")
        {
          if ($this->nmgp_botoes['summary'] == "on" && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_psq'] && empty($this->nm_grid_sem_reg) && !$this->grid_emb_form)
          {
              $this->nm_btn_exist['summary'][] = "res_top";
              if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['where_resumo']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['where_resumo'])) {
                  $Cod_Btn = nmButtonOutput($this->arr_buttons, "bvoltar", "nm_gp_move('resumo', '0');", "nm_gp_move('resumo', '0');", "res_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
              } 
              else { 
                  $Cod_Btn = nmButtonOutput($this->arr_buttons, "bresumo", "nm_gp_move('resumo', '0');", "nm_gp_move('resumo', '0');", "res_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
              } 
              $nm_saida->saida("           $Cod_Btn \r\n");
                  $NM_btn = true;
          }
        }
          if (is_file("grid_jdp_beneficiohogar_detalle_help.txt") && !$this->grid_emb_form)
          {
             $Arq_WebHelp = file("grid_jdp_beneficiohogar_detalle_help.txt"); 
             if (isset($Arq_WebHelp[0]) && !empty($Arq_WebHelp[0]))
             {
                 $Arq_WebHelp[0] = str_replace("\r\n" , "", trim($Arq_WebHelp[0]));
                 $Tmp = explode(";", $Arq_WebHelp[0]); 
                 foreach ($Tmp as $Cada_help)
                 {
                     $Tmp1 = explode(":", $Cada_help); 
                     if (!empty($Tmp1[0]) && isset($Tmp1[1]) && !empty($Tmp1[1]) && $Tmp1[0] == "cons" && is_file($this->Ini->root . $this->Ini->path_help . $Tmp1[1]))
                     {
                        $Cod_Btn = nmButtonOutput($this->arr_buttons, "bhelp", "nm_open_popup('" . $this->Ini->path_help . $Tmp1[1] . "');", "nm_open_popup('" . $this->Ini->path_help . $Tmp1[1] . "');", "help_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
                        $nm_saida->saida("           $Cod_Btn \r\n");
                        $NM_btn = true;
                     }
                 }
             }
          }
      if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['b_sair'] || $this->grid_emb_form || $this->grid_emb_form_full || (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['dashboard_info']['under_dashboard']) && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['dashboard_info']['under_dashboard']))
      {
         $this->nmgp_botoes['exit'] = "off"; 
      }
      if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_psq'])
      {
          $this->nm_btn_exist['exit'][] = "sai_top";
         if ($nm_apl_dependente == 1 && $this->nmgp_botoes['exit'] == "on") 
         { 
            $Cod_Btn = nmButtonOutput($this->arr_buttons, "bvoltar", "document.F5.action='$nm_url_saida'; document.F5.submit();", "document.F5.action='$nm_url_saida'; document.F5.submit();", "sai_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
            $nm_saida->saida("           $Cod_Btn \r\n");
            $NM_btn = true;
         } 
         elseif (!$this->Ini->SC_Link_View && !$this->aba_iframe && $this->nmgp_botoes['exit'] == "on") 
         { 
            $Cod_Btn = nmButtonOutput($this->arr_buttons, "bsair", "document.F5.action='$nm_url_saida'; document.F5.submit();", "document.F5.action='$nm_url_saida'; document.F5.submit();", "sai_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
            $nm_saida->saida("           $Cod_Btn \r\n");
            $NM_btn = true;
         } 
      }
      elseif ($this->nmgp_botoes['exit'] == "on")
      {
        if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['sc_modal']) && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['sc_modal'])
        {
           $Cod_Btn = nmButtonOutput($this->arr_buttons, "bvoltar", "self.parent.tb_remove()", "self.parent.tb_remove()", "sai_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
        }
        else
        {
           $Cod_Btn = nmButtonOutput($this->arr_buttons, "bvoltar", "window.close();", "window.close();", "sai_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
        }
         $nm_saida->saida("           $Cod_Btn \r\n");
         $NM_btn = true;
      }
      }
      $nm_saida->saida("         </td> \r\n");
      $nm_saida->saida("        </tr> \r\n");
      $nm_saida->saida("       </table> \r\n");
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
      { 
          $this->Ini->Arr_result['setValue'][] = array('field' => 'sc_grid_toobar_top', 'value' => NM_charset_to_utf8($_SESSION['scriptcase']['saida_html']));
          $_SESSION['scriptcase']['saida_html'] = "";
      } 
      $nm_saida->saida("      </td> \r\n");
      $nm_saida->saida("     </tr> \r\n");
      $nm_saida->saida("      <tr style=\"display: none\">\r\n");
      $nm_saida->saida("      <td> \r\n");
      $nm_saida->saida("     </form> \r\n");
      $nm_saida->saida("      </td> \r\n");
      $nm_saida->saida("     </tr> \r\n");
      if (!$NM_btn && isset($NM_ult_sep))
      {
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
          { 
              $this->Ini->Arr_result['setDisplay'][] = array('field' => $NM_ult_sep, 'value' => 'none');
          } 
          $nm_saida->saida("     <script language=\"javascript\">\r\n");
          $nm_saida->saida("        document.getElementById('" . $NM_ult_sep . "').style.display='none';\r\n");
          $nm_saida->saida("     </script>\r\n");
      }
   }
   function nmgp_barra_bot_mobile()
   {
      global 
             $nm_saida, $nm_url_saida, $nm_apl_dependente;
      $NM_btn  = false;
      $NM_Gbtn = false;
      $nm_saida->saida("      <tr style=\"display: none\">\r\n");
      $nm_saida->saida("      <td>\r\n");
      $nm_saida->saida("      <form id=\"id_F0_bot\" name=\"F0_bot\" method=\"post\" action=\"./\" target=\"_self\"> \r\n");
      $nm_saida->saida("      <input type=\"text\" id=\"id_sc_truta_f0_bot\" name=\"sc_truta_f0_bot\" value=\"\"/> \r\n");
      $nm_saida->saida("      <input type=\"hidden\" id=\"script_init_f0_bot\" name=\"script_case_init\" value=\"" . NM_encode_input($this->Ini->sc_page) . "\"/> \r\n");
      $nm_saida->saida("      <input type=\"hidden\" id=\"opcao_f0_bot\" name=\"nmgp_opcao\" value=\"muda_qt_linhas\"/> \r\n");
      $nm_saida->saida("      </td></tr><tr id=\"sc_grid_toobar_bot_tr\">\r\n");
      $nm_saida->saida("       <td id=\"sc_grid_toobar_bot\"  colspan=3 class=\"" . $this->css_scGridTabelaTd . "\" valign=\"top\"> \r\n");
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
      { 
          $_SESSION['scriptcase']['saida_html'] = "";
      } 
      $nm_saida->saida("        <table id=\"sc_grid_toobar_bot_table\" class=\"" . $this->css_scGridToolbar . "\" style=\"padding: 0px; border-spacing: 0px; border-width: 0px; vertical-align: top;\" width=\"100%\" valign=\"top\">\r\n");
      $nm_saida->saida("         <tr class=\"" . $this->css_scGridToolbarPadd . "_tr\"> \r\n");
      $nm_saida->saida("          <td class=\"" . $this->css_scGridToolbarPadd . "\" nowrap valign=\"middle\" align=\"left\" width=\"33%\"> \r\n");
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != "print") 
      {
          if (empty($this->nm_grid_sem_reg) && $this->nmgp_botoes['goto'] == "on" && $this->Ini->Apl_paginacao != "FULL" )
          {
              $Reg_Page  = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_lin_grid'];
              $this->nm_btn_exist['goto'][] = "brec_bot";
              $Cod_Btn = nmButtonOutput($this->arr_buttons, "birpara", "var rec_nav = ((document.getElementById('rec_f0_bot').value - 1) * " . NM_encode_input($Reg_Page) . ") + 1; nm_gp_submit_ajax('muda_rec_linhas', rec_nav);", "var rec_nav = ((document.getElementById('rec_f0_bot').value - 1) * " . NM_encode_input($Reg_Page) . ") + 1; nm_gp_submit_ajax('muda_rec_linhas', rec_nav);", "brec_bot", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
              $nm_saida->saida("           $Cod_Btn \r\n");
              $Page_Atu   = ceil($this->nmgp_reg_inicial / $Reg_Page);
              $nm_saida->saida("          <input id=\"rec_f0_bot\" type=\"text\" class=\"" . $this->css_css_toolbar_obj . "\" name=\"rec\" value=\"" . NM_encode_input($Page_Atu) . "\" style=\"width:25px;vertical-align: middle;\"/> \r\n");
              $NM_btn = true;
          }
          if (empty($this->nm_grid_sem_reg) && $this->nmgp_botoes['qtline'] == "on" && $this->Ini->Apl_paginacao != "FULL")
          {
              $nm_saida->saida("          <span class=\"" . $this->css_css_toolbar_obj . "\" style=\"border: 0px;vertical-align: middle;\">" . $this->Ini->Nm_lang['lang_btns_rows'] . "</span>\r\n");
              $nm_saida->saida("          <select class=\"" . $this->css_css_toolbar_obj . "\" style=\"vertical-align: middle;\" id=\"quant_linhas_f0_bot\" name=\"nmgp_quant_linhas\" onchange=\"sc_ind = document.getElementById('quant_linhas_f0_bot').selectedIndex; nm_gp_submit_ajax('muda_qt_linhas', document.getElementById('quant_linhas_f0_bot').options[sc_ind].value + ';' + document.getElementById('quant_colunas_f0_bot').value);\"> \r\n");
              $obj_sel = ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_lin_grid'] == 1) ? " selected" : "";
              $nm_saida->saida("           <option value=\"1\" " . $obj_sel . ">1</option>\r\n");
              $obj_sel = ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_lin_grid'] == 10) ? " selected" : "";
              $nm_saida->saida("           <option value=\"10\" " . $obj_sel . ">10</option>\r\n");
              $obj_sel = ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_lin_grid'] == 20) ? " selected" : "";
              $nm_saida->saida("           <option value=\"20\" " . $obj_sel . ">20</option>\r\n");
              $obj_sel = ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_lin_grid'] == 50) ? " selected" : "";
              $nm_saida->saida("           <option value=\"50\" " . $obj_sel . ">50</option>\r\n");
              $nm_saida->saida("          </select>\r\n");
              $nm_saida->saida("          <input type=\"text\" class=\"" . $this->css_css_toolbar_obj . "\" id=\"quant_colunas_f0_bot\" name=\"nmgp_quant_colunas\" value=\"" . NM_encode_input($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_col_grid']) . "\" onchange=\"sc_ind = document.getElementById('quant_linhas_f0_bot').selectedIndex; nm_gp_submit_ajax('muda_qt_linhas', document.getElementById('quant_linhas_f0_bot').options[sc_ind].value + ';' + document.getElementById('quant_colunas_f0_bot').value);\" style=\"width:25px;vertical-align: middle;\"/> \r\n");
              $NM_btn = true;
          }
          if ($this->nmgp_botoes['first'] == "on" && empty($this->nm_grid_sem_reg) && $this->Ini->Apl_paginacao != "FULL" && !isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_liga']['nav']))
          {
              $this->nm_btn_exist['first'][] = "first_bot";
              if ($this->Rec_ini == 0)
              {
                  $Cod_Btn = nmButtonOutput($this->arr_buttons, "bcons_inicio", "nm_gp_submit_rec('ini');", "nm_gp_submit_rec('ini');", "first_bot", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "disabled", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
                  $nm_saida->saida("           $Cod_Btn \r\n");
              }
              else
              {
                  $Cod_Btn = nmButtonOutput($this->arr_buttons, "bcons_inicio", "nm_gp_submit_rec('ini');", "nm_gp_submit_rec('ini');", "first_bot", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
                  $nm_saida->saida("           $Cod_Btn \r\n");
              }
                  $NM_btn = true;
          }
          if ($this->nmgp_botoes['back'] == "on" && empty($this->nm_grid_sem_reg) && $this->Ini->Apl_paginacao != "FULL" && !isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_liga']['nav']))
          {
              $this->nm_btn_exist['back'][] = "back_bot";
              if ($this->Rec_ini == 0)
              {
                  $Cod_Btn = nmButtonOutput($this->arr_buttons, "bcons_retorna", "nm_gp_submit_rec('" . $this->Rec_ini . "');", "nm_gp_submit_rec('" . $this->Rec_ini . "');", "back_bot", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "disabled", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
                  $nm_saida->saida("           $Cod_Btn \r\n");
              }
              else
              {
                  $Cod_Btn = nmButtonOutput($this->arr_buttons, "bcons_retorna", "nm_gp_submit_rec('" . $this->Rec_ini . "');", "nm_gp_submit_rec('" . $this->Rec_ini . "');", "back_bot", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
                  $nm_saida->saida("           $Cod_Btn \r\n");
              }
                  $NM_btn = true;
          }
          if (empty($this->nm_grid_sem_reg) && $this->nmgp_botoes['navpage'] == "on" && !isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_liga']['nav']) && $this->Ini->Apl_paginacao != "FULL" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_lin_grid'] != "all")
          {
              $Reg_Page  = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_lin_grid'] * $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['qt_col_grid'];
              $Max_link   = 5;
              $Mid_link   = ceil($Max_link / 2);
              $Corr_link  = (($Max_link % 2) == 0) ? 0 : 1;
              $Qtd_Pages  = ceil($this->count_ger / $Reg_Page);
              $Page_Atu   = ceil($this->nmgp_reg_final / $Reg_Page);
              $Link_ini   = 1;
              if ($Page_Atu > $Max_link)
              {
                  $Link_ini = $Page_Atu - $Mid_link + $Corr_link;
              }
              elseif ($Page_Atu > $Mid_link)
              {
                  $Link_ini = $Page_Atu - $Mid_link + $Corr_link;
              }
              if (($Qtd_Pages - $Link_ini) < $Max_link)
              {
                  $Link_ini = ($Qtd_Pages - $Max_link) + 1;
              }
              if ($Link_ini < 1)
              {
                  $Link_ini = 1;
              }
              for ($x = 0; $x < $Max_link && $Link_ini <= $Qtd_Pages; $x++)
              {
                  $rec = (($Link_ini - 1) * $Reg_Page) + 1;
                  if ($Link_ini == $Page_Atu)
                  {
                      $nm_saida->saida("            <span class=\"scGridToolbarNavOpen\" style=\"vertical-align: middle;\">" . $Link_ini . "</span>\r\n");
                  }
                  else
                  {
                      $nm_saida->saida("            <a class=\"scGridToolbarNav\" style=\"vertical-align: middle;\" href=\"javascript: nm_gp_submit_rec(" . $rec . ");\">" . $Link_ini . "</a>\r\n");
                  }
                  $Link_ini++;
                  if (($x + 1) < $Max_link && $Link_ini <= $Qtd_Pages && '' != $this->Ini->Str_toolbarnav_separator && @is_file($this->Ini->root . $this->Ini->path_img_global . $this->Ini->Str_toolbarnav_separator))
                  {
                      $nm_saida->saida("            <img src=\"" . $this->Ini->path_img_global . $this->Ini->Str_toolbarnav_separator . "\" align=\"absmiddle\" style=\"vertical-align: middle;\">\r\n");
                  }
              }
              $NM_btn = true;
          }
          if ($this->nmgp_botoes['forward'] == "on" && empty($this->nm_grid_sem_reg) && $this->Ini->Apl_paginacao != "FULL" && !isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_liga']['nav']))
          {
              $this->nm_btn_exist['forward'][] = "forward_bot";
              $Cod_Btn = nmButtonOutput($this->arr_buttons, "bcons_avanca", "nm_gp_submit_rec('" . $this->Rec_fim . "');", "nm_gp_submit_rec('" . $this->Rec_fim . "');", "forward_bot", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
              $nm_saida->saida("           $Cod_Btn \r\n");
              $NM_btn = true;
          }
          if ($this->nmgp_botoes['last'] == "on" && empty($this->nm_grid_sem_reg) && $this->Ini->Apl_paginacao != "FULL" && !isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_liga']['nav']))
          {
              $this->nm_btn_exist['last'][] = "last_bot";
              $Cod_Btn = nmButtonOutput($this->arr_buttons, "bcons_final", "nm_gp_submit_rec('fim');", "nm_gp_submit_rec('fim');", "last_bot", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
              $nm_saida->saida("           $Cod_Btn \r\n");
              $NM_btn = true;
          }
          if ($this->nmgp_botoes['rows'] == "on" && empty($this->nm_grid_sem_reg))
          {
              $nm_sumario = "[" . $this->Ini->Nm_lang['lang_othr_smry_info'] . "]";
              $nm_sumario = str_replace("?start?", $this->nmgp_reg_inicial, $nm_sumario);
              if ($this->Ini->Apl_paginacao == "FULL")
              {
                  $nm_sumario = str_replace("?final?", "<span class='sm_counter_final'>".$this->count_ger."</span>", $nm_sumario);
              }
              else
              {
                  $nm_sumario = str_replace("?final?", "<span class='sm_counter_final'>".$this->nmgp_reg_final."</span>", $nm_sumario);
              }
              $nm_sumario = str_replace("?total?", "<span class='sm_counter_total'>".$this->count_ger."</span>", $nm_sumario);
              $nm_saida->saida("           <span class=\"summary_indicator " . $this->css_css_toolbar_obj . "\" style=\"border:0px;\"><span class='sm_counter'>" . $nm_sumario . "</span></span>\r\n");
              $NM_btn = true;
          }
          if (is_file("grid_jdp_beneficiohogar_detalle_help.txt") && !$this->grid_emb_form)
          {
             $Arq_WebHelp = file("grid_jdp_beneficiohogar_detalle_help.txt"); 
             if (isset($Arq_WebHelp[0]) && !empty($Arq_WebHelp[0]))
             {
                 $Arq_WebHelp[0] = str_replace("\r\n" , "", trim($Arq_WebHelp[0]));
                 $Tmp = explode(";", $Arq_WebHelp[0]); 
                 foreach ($Tmp as $Cada_help)
                 {
                     $Tmp1 = explode(":", $Cada_help); 
                     if (!empty($Tmp1[0]) && isset($Tmp1[1]) && !empty($Tmp1[1]) && $Tmp1[0] == "cons" && is_file($this->Ini->root . $this->Ini->path_help . $Tmp1[1]))
                     {
                        $Cod_Btn = nmButtonOutput($this->arr_buttons, "bhelp", "nm_open_popup('" . $this->Ini->path_help . $Tmp1[1] . "');", "nm_open_popup('" . $this->Ini->path_help . $Tmp1[1] . "');", "help_bot", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
                        $nm_saida->saida("           $Cod_Btn \r\n");
                        $NM_btn = true;
                     }
                 }
             }
          }
      }
      $nm_saida->saida("         </td> \r\n");
      $nm_saida->saida("        </tr> \r\n");
      $nm_saida->saida("       </table> \r\n");
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
      { 
          $this->Ini->Arr_result['setValue'][] = array('field' => 'sc_grid_toobar_bot', 'value' => NM_charset_to_utf8($_SESSION['scriptcase']['saida_html']));
          $_SESSION['scriptcase']['saida_html'] = "";
      } 
      $nm_saida->saida("      </td> \r\n");
      $nm_saida->saida("     </tr> \r\n");
      $nm_saida->saida("      <tr style=\"display: none\">\r\n");
      $nm_saida->saida("      <td> \r\n");
      $nm_saida->saida("     </form> \r\n");
      $nm_saida->saida("      </td> \r\n");
      $nm_saida->saida("     </tr> \r\n");
      if (!$NM_btn && isset($NM_ult_sep))
      {
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
          { 
              $this->Ini->Arr_result['setDisplay'][] = array('field' => $NM_ult_sep, 'value' => 'none');
          } 
          $nm_saida->saida("     <script language=\"javascript\">\r\n");
          $nm_saida->saida("        document.getElementById('" . $NM_ult_sep . "').style.display='none';\r\n");
          $nm_saida->saida("     </script>\r\n");
      }
   }
   function nmgp_barra_top()
   {
       if (isset($_SESSION['scriptcase']['proc_mobile']) && $_SESSION['scriptcase']['proc_mobile'])
       {
           $this->nmgp_barra_top_mobile();
           $this->nmgp_embbed_placeholder_top();
       }
       if (!isset($_SESSION['scriptcase']['proc_mobile']) || !$_SESSION['scriptcase']['proc_mobile'])
       {
           $this->nmgp_barra_top_normal();
           $this->nmgp_embbed_placeholder_top();
       }
   }
   function nmgp_barra_bot()
   {
       if (isset($_SESSION['scriptcase']['proc_mobile']) && $_SESSION['scriptcase']['proc_mobile'])
       {
           $this->nmgp_embbed_placeholder_bot();
           $this->nmgp_barra_bot_mobile();
       }
       if (!isset($_SESSION['scriptcase']['proc_mobile']) || !$_SESSION['scriptcase']['proc_mobile'])
       {
           $this->nmgp_embbed_placeholder_bot();
           $this->nmgp_barra_bot_normal();
       }
   }
   function nmgp_embbed_placeholder_top()
   {
      global $nm_saida;
      $nm_saida->saida("     <tr id=\"sc_id_save_grid_placeholder_top\" style=\"display: none\">\r\n");
      $nm_saida->saida("      <td colspan=3>\r\n");
      $nm_saida->saida("      </td>\r\n");
      $nm_saida->saida("     </tr>\r\n");
      $nm_saida->saida("     <tr id=\"sc_id_groupby_placeholder_top\" style=\"display: none\">\r\n");
      $nm_saida->saida("      <td colspan=3>\r\n");
      $nm_saida->saida("      </td>\r\n");
      $nm_saida->saida("     </tr>\r\n");
      $nm_saida->saida("     <tr id=\"sc_id_sel_campos_placeholder_top\" style=\"display: none\">\r\n");
      $nm_saida->saida("      <td colspan=3>\r\n");
      $nm_saida->saida("      </td>\r\n");
      $nm_saida->saida("     </tr>\r\n");
      $nm_saida->saida("     <tr id=\"sc_id_export_email_placeholder_top\" style=\"display: none\">\r\n");
      $nm_saida->saida("      <td colspan=3>\r\n");
      $nm_saida->saida("      </td>\r\n");
      $nm_saida->saida("     </tr>\r\n");
      $nm_saida->saida("     <tr id=\"sc_id_order_campos_placeholder_top\" style=\"display: none\">\r\n");
      $nm_saida->saida("      <td colspan=3>\r\n");
      $nm_saida->saida("      </td>\r\n");
      $nm_saida->saida("     </tr>\r\n");
   }
   function nmgp_embbed_placeholder_bot()
   {
      global $nm_saida;
      $nm_saida->saida("     <tr id=\"sc_id_save_grid_placeholder_bot\" style=\"display: none\">\r\n");
      $nm_saida->saida("      <td colspan=3>\r\n");
      $nm_saida->saida("      </td>\r\n");
      $nm_saida->saida("     </tr>\r\n");
      $nm_saida->saida("     <tr id=\"sc_id_groupby_placeholder_bot\" style=\"display: none\">\r\n");
      $nm_saida->saida("      <td colspan=3>\r\n");
      $nm_saida->saida("      </td>\r\n");
      $nm_saida->saida("     </tr>\r\n");
      $nm_saida->saida("     <tr id=\"sc_id_sel_campos_placeholder_bot\" style=\"display: none\">\r\n");
      $nm_saida->saida("      <td colspan=3>\r\n");
      $nm_saida->saida("      </td>\r\n");
      $nm_saida->saida("     </tr>\r\n");
      $nm_saida->saida("     <tr id=\"sc_id_export_email_placeholder_bot\" style=\"display: none\">\r\n");
      $nm_saida->saida("      <td colspan=3>\r\n");
      $nm_saida->saida("      </td>\r\n");
      $nm_saida->saida("     </tr>\r\n");
      $nm_saida->saida("     <tr id=\"sc_id_order_campos_placeholder_bot\" style=\"display: none\">\r\n");
      $nm_saida->saida("      <td colspan=3>\r\n");
      $nm_saida->saida("      </td>\r\n");
      $nm_saida->saida("     </tr>\r\n");
   }
   function html_grid_search()
   {
       global $nm_saida;
       $this->grid_search_seq = 0;
       $this->grid_search_str = "";
       $this->grid_search_dat = array();
       $this->grid_search_str = "";
        if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
        { 
           $_SESSION['scriptcase']['saida_html'] = "";
        } 
       $this->NM_case_insensitive = false;
       $tmp = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['cond_pesq'];
       $pos = strrpos($tmp, "##*@@");
       if ($pos !== false)
       {
           $and_or = (substr($tmp, ($pos + 5)) == "and") ? $this->Ini->Nm_lang['lang_srch_and_cond'] : $this->Ini->Nm_lang['lang_srch_orr_cond'];
           $tmp    = substr($tmp, 0, $pos);
           $this->grid_search_str = str_replace("##*@@", ", " . $and_or . " ", $tmp);
       }
       $str_display = empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['grid_pesq'])?'none':'';
       if(!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
       {
          $nm_saida->saida("   <tr id=\"NM_Grid_Search\" ajax='' style='display:" . $str_display . "'>\r\n");
       }
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'] && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['grid_pesq']))
       { 
           $_SESSION['scriptcase']['saida_html'] = "";
           foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['grid_pesq'] as $cmp => $def)
           {
               $this->Ini->Arr_result['setValue'][] = array('field' => 'grid_search_label_' . $cmp, 'value' => NM_charset_to_utf8(trim($def['descr'])));
               $this->Ini->Arr_result['setTitle'][] = array('field' => 'grid_search_label_' . $cmp, 'value' => NM_charset_to_utf8(trim($def['hint'])));
           }
           $lin_obj = $this->grid_search_add_tag();
           $this->Ini->Arr_result['setValue'][] = array('field' => 'id_grid_search_add_tag', 'value' => NM_charset_to_utf8($lin_obj));
           $this->Ini->Arr_result['setValue'][] = array('field' => 'id_grid_search_cmd_str', 'value' => NM_charset_to_utf8($this->grid_search_str));
           if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['save_grid']))
           {
               return;
           }
           else
           {
               $this->Ini->Arr_result['setDisplay'][] = array('field' => 'NM_Grid_Search', 'value' => '');
           }
       } 
           if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['save_grid']))
           {
               $str_display = empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['grid_pesq']) ? 'none' : '';
               $this->Ini->Arr_result['setDisplay'][] = array('field' => 'NM_Grid_Search', 'value' => $str_display);
           }
       $nm_saida->saida("   <td  colspan=3 valign=\"top\"> \r\n");
       $nm_saida->saida("   <div id='id_grid_search_cmd_string' class=\"" . $this->css_scAppDivMoldura . "\" style='cursor:pointer; display:none;' onclick=\"$('#id_grid_search_cmd_string').hide();$('#div_grid_search').show();\"> \r\n");
             if (is_file($this->Ini->root . $this->Ini->path_img_global . '/' . $this->Ini->App_div_tree_img_exp))
             {
       $nm_saida->saida("                             <img id='id_app_div_tree_img_exp' src=\"" . $this->Ini->path_img_global . "/" . $this->Ini->App_div_tree_img_exp . "\" border=0 align='absmiddle' class='scGridFilterTagIconExp'>\r\n");
             }
       $nm_saida->saida("     <span class=\"" . $this->css_scAppDivHeaderText . "\">\r\n");
       $nm_saida->saida("             " . $this->Ini->Nm_lang['lang_othr_dynamicsearch_title_outside'] . "\r\n");
       $nm_saida->saida("     </span>\r\n");
       $nm_saida->saida("     <span id='id_grid_search_cmd_str' class=\"" . $this->css_scAppDivContentText . "\">" . NM_encode_input(trim($this->grid_search_str)) . "</span>\r\n");
       $nm_saida->saida("   </div> \r\n");
       $nm_saida->saida("   <div id=\"div_grid_search\" class=\"" . $this->css_scAppDivMoldura . " scGridFilterTag\" style='display:;'> \r\n");
             if (is_file($this->Ini->root . $this->Ini->path_img_global . '/' . $this->Ini->App_div_tree_img_col))
             {
       $nm_saida->saida("                             <a href=\"#\" onclick=\"$('#id_grid_search_cmd_string').show();$('#div_grid_search').hide();\" class='scGridFilterTagIconCol'><img id='id_app_div_tree_img_col' src=\"" . $this->Ini->path_img_global . "/" . $this->Ini->App_div_tree_img_col . "\" border=0 align='absmiddle' style='vertical-align: middle; margin-right:4px;'></a>\r\n");
             }
       $nm_saida->saida("    <div id='icon_grid_search' class='scGridFilterTagIcon'><svg height='1792' viewBox='0 0 1792 1792' width='1792' xmlns='http://www.w3.org/2000/svg'><path d='M1595 295q17 41-14 70l-493 493v742q0 42-39 59-13 5-25 5-27 0-45-19l-256-256q-19-19-19-45v-486l-493-493q-31-29-14-70 17-39 59-39h1280q42 0 59 39z'/></svg></div> \r\n");
       $nm_saida->saida("    <div id=\"tags_grid_search\" class='scGridFilterTagList'> \r\n");
       $nm_saida->saida("        <form id= \"id_Fgrid_search\" name=\"Fgrid_search\" method=\"post\" action=\"./\" target=\"_self\"> \r\n");
       $nm_saida->saida("            <input type=\"hidden\" name=\"script_case_init\" value=\"" . NM_encode_input($this->Ini->sc_page) . "\"/> \r\n");
       $nm_saida->saida("            <input type=\"hidden\" name=\"nmgp_opcao\" value=\"grid_search\"/> \r\n");
       $nm_saida->saida("            <input type=\"hidden\" name=\"parm\" value=\"\"/> \r\n");
            if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['grid_pesq']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['grid_pesq']))
            {
                foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['grid_pesq'] as $cmp => $def)
                {
                    if (isset($def['label'])) {
                        $this->grid_search_seq++;
                        $lin_obj = $this->grid_search_tag_ini($cmp, $def, $this->grid_search_seq);
                        $nm_saida->saida("" . $lin_obj . "\r\n");
                        if ($cmp == "ac_nombre")
                        {
                           $this->grid_search_dat[$this->grid_search_seq] = "ac_nombre";
                           $lin_obj = $this->grid_search_ac_nombre($this->grid_search_seq, 'N', $def['opc'], $def['val'], $def['label']);
                           $nm_saida->saida("" . $lin_obj . "\r\n");
                        }
                        if ($cmp == "suba_nombre")
                        {
                           $this->grid_search_dat[$this->grid_search_seq] = "suba_nombre";
                           $lin_obj = $this->grid_search_suba_nombre($this->grid_search_seq, 'N', $def['opc'], $def['val'], $def['label']);
                           $nm_saida->saida("" . $lin_obj . "\r\n");
                        }
                        $lin_obj = $this->grid_search_tag_end();
                        $nm_saida->saida("" . $lin_obj . "\r\n");
                    }
                }
            }
       $nm_saida->saida("            <div id='add_grid_search' class='scGridFilterTagAdd SC_SubMenuApp' onclick=\"nm_show_advancedsearch_fields();\">\r\n");
       $nm_saida->saida("                " . $this->Ini->Nm_lang['lang_srch_addfields'] . "\r\n");
       $nm_saida->saida("                <div id='id_grid_search_add_tag' style='position: absolute; border-collapse: collapse; z-index: 1000; display:none;'>\r\n");
       $lin_obj = $this->grid_search_add_tag();
       $nm_saida->saida("" . $lin_obj . "\r\n");
       $nm_saida->saida("                </div>\r\n");
       $nm_saida->saida("            </div>\r\n");
       $nm_saida->saida("        </form>\r\n");
       $nm_saida->saida("    </div>\r\n");
       $this->NM_fil_ant = $this->gera_array_filtros();
       $strDisplayFilter = (empty($this->NM_fil_ant))?'none':'';
       $nm_saida->saida("   <div id='save_grid_search' class='scGridFilterTagSave'>\r\n");
       $nm_saida->saida("    <form name='Fgrid_search_save'>\r\n");
       $nm_saida->saida("     <span id=\"id_NM_filters_save\" style=\"display: " . $strDisplayFilter . "\">\r\n");
       $nm_saida->saida("       <SELECT class=\"scFilterToolbar_obj\" id=\"id_sel_recup_filters\" name=\"sel_recup_filters\" onChange=\"nm_change_grid_search(this)\" size=\"1\">\r\n");
       $nm_saida->saida("           <option value=\"\"></option>\r\n");
       $Nome_filter = "";
       foreach ($this->NM_fil_ant as $Cada_filter => $Tipo_filter)
       {
           $Select = "";
           if (isset($this->NM_curr_fil) && $Cada_filter == $this->NM_curr_fil)
           {
               $Select = "selected";
           }
           if (NM_is_utf8($Cada_filter) && $_SESSION['scriptcase']['charset'] != "UTF-8")
           {
               $Cada_filter    = sc_convert_encoding($Cada_filter, $_SESSION['scriptcase']['charset'], "UTF-8");
               $Tipo_filter[0] = sc_convert_encoding($Tipo_filter[0], $_SESSION['scriptcase']['charset'], "UTF-8");
           }
           elseif (!NM_is_utf8($Cada_filter) && $_SESSION['scriptcase']['charset'] == "UTF-8")
           {
               $Cada_filter    = sc_convert_encoding($Cada_filter, "UTF-8", $_SESSION['scriptcase']['charset']);
               $Tipo_filter[0] = sc_convert_encoding($Tipo_filter[0], "UTF-8", $_SESSION['scriptcase']['charset']);
           }
           if ($Tipo_filter[1] != $Nome_filter)
           {
               $Nome_filter = $Tipo_filter[1];
                   $nm_saida->saida("       <option value=''>" . NM_encode_input($Nome_filter) . "</option>\r\n");
           }
              $nm_saida->saida("        <option value='" . NM_encode_input($Tipo_filter[0]) . "' " . $Select . ">.." . $Cada_filter . "</option>\r\n");
       }
       $nm_saida->saida("       </SELECT>\r\n");
       $nm_saida->saida("     </span>\r\n");
       $Cod_Btn = nmButtonOutput($this->arr_buttons, "bedit_filter_appdiv", "document.getElementById('Salvar_filters').style.display = ''; document.Fgrid_search_save.nmgp_save_name.focus()", "document.getElementById('Salvar_filters').style.display = ''; document.Fgrid_search_save.nmgp_save_name.focus()", "Ativa_save", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
       $nm_saida->saida("       $Cod_Btn \r\n");
       $nm_saida->saida("    <DIV id=\"Salvar_filters\" style=\"display:none;z-index:9999;position: absolute;\">\r\n");
       $nm_saida->saida("     <TABLE align=\"center\" class=\"scFilterTable\">\r\n");
       $nm_saida->saida("      <TR>\r\n");
       $nm_saida->saida("       <TD class=\"scFilterBlock\">\r\n");
       $nm_saida->saida("        <table style=\"border-width: 0px; border-collapse: collapse\" width=\"100%\">\r\n");
       $nm_saida->saida("         <tr>\r\n");
       $nm_saida->saida("          <td style=\"padding: 0px\" valign=\"top\" class=\"scFilterBlockFont\">" . $this->Ini->Nm_lang['lang_othr_srch_head'] . "</td>\r\n");
       $nm_saida->saida("          <td style=\"padding: 0px\" align=\"right\" valign=\"top\">\r\n");
       $Cod_Btn = nmButtonOutput($this->arr_buttons, "bcancelar_appdiv", "document.getElementById('Salvar_filters').style.display = 'none'", "document.getElementById('Salvar_filters').style.display = 'none'", "Cancel_frm", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
       $nm_saida->saida("       $Cod_Btn \r\n");
       $nm_saida->saida("          </td>\r\n");
       $nm_saida->saida("         </tr>\r\n");
       $nm_saida->saida("        </table>\r\n");
       $nm_saida->saida("       </TD>\r\n");
       $nm_saida->saida("      </TR>\r\n");
       $nm_saida->saida("      <TR>\r\n");
       $nm_saida->saida("       <TD class=\"scFilterFieldOdd\">\r\n");
       $nm_saida->saida("        <table style=\"border-width: 0px; border-collapse: collapse\" width=\"100%\">\r\n");
       $nm_saida->saida("         <tr>\r\n");
       $nm_saida->saida("          <td style=\"padding: 0px\" valign=\"top\">\r\n");
       $nm_saida->saida("           <input class=\"scFilterObjectOdd\" type=\"text\" id=\"SC_nmgp_save_name\" name=\"nmgp_save_name\" value=\"\">\r\n");
       $nm_saida->saida("          </td>\r\n");
       $nm_saida->saida("          <td style=\"padding: 0px\" align=\"right\" valign=\"top\">\r\n");
       $Cod_Btn = nmButtonOutput($this->arr_buttons, "bsalvar_appdiv", "nm_save_grid_search()", "nm_save_grid_search()", "Save_frm", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
       $nm_saida->saida("       $Cod_Btn \r\n");
       $nm_saida->saida("          </td>\r\n");
       $nm_saida->saida("         </tr>\r\n");
       $nm_saida->saida("        </table>\r\n");
       $nm_saida->saida("       </TD>\r\n");
       $nm_saida->saida("      </TR>\r\n");
       $style_del_filter = (!empty($this->NM_fil_ant)) ? '' : 'none';
       $nm_saida->saida("      <TR>\r\n");
       $nm_saida->saida("       <TD class=\"scFilterFieldEven\">\r\n");
       $nm_saida->saida("       <DIV id=\"Apaga_filters\" style=\"display: " . $style_del_filter . "\">\r\n");
       $nm_saida->saida("        <table style=\"border-width: 0px; border-collapse: collapse\" width=\"100%\">\r\n");
       $nm_saida->saida("         <tr>\r\n");
       $nm_saida->saida("          <td style=\"padding: 0px\" valign=\"top\">\r\n");
       $nm_saida->saida("          <div id=\"id_sel_filters_del\">\r\n");
       $nm_saida->saida("           <SELECT class=\"scFilterObjectOdd\" id=\"sel_filters_del\" name=\"NM_filters_del\" size=\"1\">\r\n");
       $nm_saida->saida("            <option value=\"\"></option>\r\n");
       $Nome_filter = "";
       foreach ($this->NM_fil_ant as $Cada_filter => $Tipo_filter)
       {
           $Select = "";
           if ($Cada_filter == $this->NM_curr_fil)
           {
               $Select = "selected";
           }
           if (NM_is_utf8($Cada_filter) && $_SESSION['scriptcase']['charset'] != "UTF-8")
           {
               $Cada_filter    = sc_convert_encoding($Cada_filter, $_SESSION['scriptcase']['charset'], "UTF-8");
               $Tipo_filter[0] = sc_convert_encoding($Tipo_filter[0], $_SESSION['scriptcase']['charset'], "UTF-8");
           }
           elseif (!NM_is_utf8($Cada_filter) && $_SESSION['scriptcase']['charset'] == "UTF-8")
           {
               $Cada_filter    = sc_convert_encoding($Cada_filter, "UTF-8", $_SESSION['scriptcase']['charset']);
               $Tipo_filter[0] = sc_convert_encoding($Tipo_filter[0], "UTF-8", $_SESSION['scriptcase']['charset']);
           }
           if ($Tipo_filter[1] != $Nome_filter)
           {
               $Nome_filter = $Tipo_filter[1];
               $nm_saida->saida("           <option value=''>" . NM_encode_input($Nome_filter) . "</option>\r\n");
           }
          $nm_saida->saida("           <option value='" . NM_encode_input($Tipo_filter[0]) . "' " . $Select . ">.." . $Cada_filter . "</option>\r\n");
       }
       $nm_saida->saida("           </SELECT>\r\n");
       $nm_saida->saida("          </div>\r\n");
       $nm_saida->saida("          </td>\r\n");
       $nm_saida->saida("          <td style=\"padding: 0px\" align=\"right\" valign=\"top\">\r\n");
       $Cod_Btn = nmButtonOutput($this->arr_buttons, "bexcluir", "nm_del_grid_search()", "nm_del_grid_search()", "Exc_filtro", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
       $nm_saida->saida("       $Cod_Btn \r\n");
       $nm_saida->saida("          </td>\r\n");
       $nm_saida->saida("         </tr>\r\n");
       $nm_saida->saida("        </table>\r\n");
       $nm_saida->saida("       </DIV>\r\n");
       $nm_saida->saida("       </TD>\r\n");
       $nm_saida->saida("      </TR>\r\n");
       $nm_saida->saida("     </TABLE>\r\n");
       $nm_saida->saida("    </DIV> \r\n");
       $nm_saida->saida("   </form>\r\n");
       $nm_saida->saida("  </div> \r\n");
       $nm_saida->saida("    <div id='close_grid_search' class='scGridFilterTagClose' onclick=\"checkLastTag(true);setTimeout(function() {nm_proc_grid_search(0, 'del_grid_search_all', 'grid_search')}, 200);\"></div>\r\n");
       $nm_saida->saida("   </div>\r\n");
       $nm_saida->saida("   </td>\r\n");
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
       { 
           $this->Ini->Arr_result['setValue'][] = array('field' => 'NM_Grid_Search', 'value' => NM_charset_to_utf8($_SESSION['scriptcase']['saida_html']));
           $_SESSION['scriptcase']['saida_html'] = "";
           if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['save_grid']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['grid_pesq']))
           { 
               $this->Ini->Arr_result['exec_JS'][] = array('function' => 'SC_carga_evt_jquery_grid', 'parm' => 'all');
           } 
       } 
       if(!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
       {
           $nm_saida->saida("   </tr>\r\n");
       }
       $this->JS_grid_search();
   }
   function grid_search_tag_ini($cmp, $def, $seq)
   {
       global $nm_saida;
       $lin_obj  = "";
       $lin_obj .= "<div class='scGridFilterTagListItem' id='grid_search_" . $cmp . "'>";
       $lin_obj .= "<span class='scGridFilterTagListItemLabel' id='grid_search_label_" . $cmp . "' title='" . NM_encode_input($def['hint']) . "' style='cursor:pointer;' onclick=\"closeAllTags();$('#grid_search_" . $cmp . " .scGridFilterTagListFilter').toggle();\">" . NM_encode_input($def['descr']) . "</span>";
       $lin_obj .= "<span class='scGridFilterTagListItemClose' onclick=\"$(this).parent().remove();checkLastTag(false);setTimeout(function() {nm_proc_grid_search('" . $seq . "', 'del_grid_search', 'grid_search'); return false;}, 200); return false;
    \"></span>";
       return $lin_obj;
   }
   function grid_search_tag_end()
   {
       global $nm_saida;
       $lin_obj  = "</div>";
       return $lin_obj;
   }
   function grid_search_add_tag()
   {
       $lin_obj  = "";
       $All_cmp_search = array('ac_nombre','suba_nombre');
       $nmgp_tab_label = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['pesq_tab_label'];
       if (!empty($nmgp_tab_label))
       {
          $nm_tab_campos = explode("?@?", $nmgp_tab_label);
          $nmgp_tab_label = array();
          foreach ($nm_tab_campos as $cada_campo)
          {
              $parte_campo = explode("?#?", $cada_campo);
              $nmgp_tab_label[$parte_campo[0]] = $parte_campo[1];
          }
       }
       if (count($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['grid_pesq']) < 2)
       {
           $lin_obj .= "<table id='id_grid_search_all_cmp' cellpadding=0 cellspacing=0>";
           foreach ($All_cmp_search as $cada_cmp)
           {
               if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['grid_pesq'][$cada_cmp]))
               {
                   $lin_obj .= "  <tr>";
                   $lin_obj .= "    <td class='scBtnGrpBackground'>";
                   $lin_obj .= "        <div class='scBtnGrpText' style='cursor:pointer; right:80px;' onClick=\"ajax_add_grid_search(this, 'grid', '" . $cada_cmp . "'); return false;\">";
                   $lin_obj .= "            " . $nmgp_tab_label[$cada_cmp] . "";
                   $lin_obj .= "        </div>";
                   $lin_obj .= "    </td>";
                   $lin_obj .= "  </tr>";
               }
           }
           $lin_obj .= "</table>";
       }
       return $lin_obj;
   }
   function grid_search_ac_nombre($ind, $ajax, $opc="", $val=array(), $label='')
   {
       $lin_obj  = "";
       $lin_obj .= "     <div class='scGridFilterTagListFilter' id='grid_search_ac_nombre_" . $ind . "' style='display:none; z-index: 10'>";
       $lin_obj .= "         <div class='scGridFilterTagListFilterLabel'>". NM_encode_input($label) ." <span class='scGridFilterTagListFilterLabelClose' onclick='closeAllTags(this);'></span></div>";
       $lin_obj .= "         <div class='scGridFilterTagListFilterInputs'>";
       if (empty($opc))
       {
           $opc = "qp";
       }
       $lin_obj .= "       <select id='grid_search_ac_nombre_cond_" . $ind . "' name='cond_grid_search_ac_nombre_" . $ind . "' class='" . $this->css_scAppDivToolbarInput . "' style='vertical-align: middle;' onChange='grid_search_hide_input(\"ac_nombre\", $ind)'>";
       $selected = ($opc == "qp") ? " selected" : "";
       $lin_obj .= "        <option value='qp'" . $selected . ">" . $this->Ini->Nm_lang['lang_srch_like'] . "</option>";
       $selected = ($opc == "np") ? " selected" : "";
       $lin_obj .= "        <option value='np'" . $selected . ">" . $this->Ini->Nm_lang['lang_srch_not_like'] . "</option>";
       $selected = ($opc == "eq") ? " selected" : "";
       $lin_obj .= "        <option value='eq'" . $selected . ">" . $this->Ini->Nm_lang['lang_srch_exac'] . "</option>";
       $selected = ($opc == "ep") ? " selected" : "";
       $lin_obj .= "        <option value='ep'" . $selected . ">" . $this->Ini->Nm_lang['lang_srch_empty'] . "</option>";
       $lin_obj .= "       </select>";
       if ($opc == "nu" || $opc == "nn" || $opc == "ep" || $opc == "ne")
       {
           $display_in_1 = "none";
       }
       else
       {
           $display_in_1 = "''";
       }
       $lin_obj .= "       <span id=\"grid_ac_nombre_" . $ind . "\" style=\"display:" . $display_in_1 . "\">";
       $val_cmp = (isset($val[0][0])) ? $val[0][0] : "";
       $ac_nombre = $val_cmp;
       if ($ac_nombre != "")
       {
       $ac_nombre_look = substr($this->Db->qstr($ac_nombre), 1, -1); 
       $nmgp_def_dados = array(); 
       $nm_comando = "select distinct ac.nombre from " . $this->Ini->nm_tabela . " where pl.idPlanificacion=" . $_SESSION['gloPlanificacion'] . " AND pl.idtipoBeneficiario=2 and ac.nombre = '$ac_nombre_look' order by ac.nombre"; 
       $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_comando; 
       $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
      if ($rs = $this->Db->SelectLimit($nm_comando, 10, 0)) 
       { 
          while (!$rs->EOF) 
          { 
            $cmp1 = trim($rs->fields[0]);
            $nmgp_def_dados[] = array($cmp1 => $cmp1); 
             $rs->MoveNext(); 
          } 
          $rs->Close(); 
       } 
       else  
       {  
           if  ($ajax == 'N')
           {  
              $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg()); 
              exit; 
           } 
           else
           {  
              echo $this->Db->ErrorMsg(); 
           } 
       } 
       }
       if (isset($nmgp_def_dados[0][$ac_nombre]))
       {
           $sAutocompValue = $nmgp_def_dados[0][$ac_nombre];
       }
       else
       {
           $sAutocompValue = $val_cmp;
           $val[0][0]      = $val_cmp;
       }
       $val_cmp = (isset($val[0][0])) ? $val[0][0] : "";
       $lin_obj .= "     <input  type=\"text\" class='sc-js-input " . $this->css_scAppDivToolbarInput . "' id='grid_search_ac_nombre_val_" . $ind . "' name='val_grid_search_ac_nombre_" . $ind . "' value=\"" . NM_encode_input($val_cmp) . "\" size=50 alt=\"{datatype: 'text', maxLength: 1500, allowedChars: '', lettersCase: '', autoTab: false, enterTab: false}\" style='display: none'>";
       $tmp_pos = strpos($val_cmp, "##@@");
       if ($tmp_pos !== false) {
           $val_cmp = substr($val_cmp, ($tmp_pos + 4));
           $sAutocompValue = substr($sAutocompValue, ($tmp_pos + 4));
       }
       $lin_obj .= "     <input class='sc-js-input " . $this->css_scAppDivToolbarInput . "' type='text' id='id_ac_grid_ac_nombre" . $ind . "' name='val_grid_search_ac_nombre_autocomp" . $ind . "' size='50' value='" . NM_encode_input($sAutocompValue) . "' alt=\"{datatype: 'text', maxLength: 50, allowedChars: '', lettersCase: '', autoTab: false, enterTab: false}\">";
       $lin_obj .= "       </span>";
       $lin_obj .= "          </div>";
       $lin_obj .= "          <div class='scGridFilterTagListFilterBar'>";
       $lin_obj .= nmButtonOutput($this->arr_buttons, "bapply_appdiv", "closeAllTags();setTimeout(function() {nm_proc_grid_search($ind, 'proc_grid_search', 'grid_search')}, 200);", "closeAllTags();setTimeout(function() {nm_proc_grid_search($ind, 'proc_grid_search', 'grid_search')}, 200);", "grid_search_apply_" . $ind . "", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
       $lin_obj .= "          </div>";
       $lin_obj .= "      </div>";
       return $lin_obj;
   }
   function grid_search_suba_nombre($ind, $ajax, $opc="", $val=array(), $label='')
   {
       $lin_obj  = "";
       $lin_obj .= "     <div class='scGridFilterTagListFilter' id='grid_search_suba_nombre_" . $ind . "' style='display:none; z-index: 10'>";
       $lin_obj .= "         <div class='scGridFilterTagListFilterLabel'>". NM_encode_input($label) ." <span class='scGridFilterTagListFilterLabelClose' onclick='closeAllTags(this);'></span></div>";
       $lin_obj .= "         <div class='scGridFilterTagListFilterInputs'>";
       if (empty($opc))
       {
           $opc = "qp";
       }
       $lin_obj .= "       <select id='grid_search_suba_nombre_cond_" . $ind . "' name='cond_grid_search_suba_nombre_" . $ind . "' class='" . $this->css_scAppDivToolbarInput . "' style='vertical-align: middle;' onChange='grid_search_hide_input(\"suba_nombre\", $ind)'>";
       $selected = ($opc == "qp") ? " selected" : "";
       $lin_obj .= "        <option value='qp'" . $selected . ">" . $this->Ini->Nm_lang['lang_srch_like'] . "</option>";
       $selected = ($opc == "np") ? " selected" : "";
       $lin_obj .= "        <option value='np'" . $selected . ">" . $this->Ini->Nm_lang['lang_srch_not_like'] . "</option>";
       $selected = ($opc == "eq") ? " selected" : "";
       $lin_obj .= "        <option value='eq'" . $selected . ">" . $this->Ini->Nm_lang['lang_srch_exac'] . "</option>";
       $selected = ($opc == "ep") ? " selected" : "";
       $lin_obj .= "        <option value='ep'" . $selected . ">" . $this->Ini->Nm_lang['lang_srch_empty'] . "</option>";
       $lin_obj .= "       </select>";
       if ($opc == "nu" || $opc == "nn" || $opc == "ep" || $opc == "ne")
       {
           $display_in_1 = "none";
       }
       else
       {
           $display_in_1 = "''";
       }
       $lin_obj .= "       <span id=\"grid_suba_nombre_" . $ind . "\" style=\"display:" . $display_in_1 . "\">";
       $val_cmp = (isset($val[0][0])) ? $val[0][0] : "";
       $suba_nombre = $val_cmp;
       if ($suba_nombre != "")
       {
       $suba_nombre_look = substr($this->Db->qstr($suba_nombre), 1, -1); 
       $nmgp_def_dados = array(); 
       $nm_comando = "select distinct suba.nombre from " . $this->Ini->nm_tabela . " where pl.idPlanificacion=" . $_SESSION['gloPlanificacion'] . " AND pl.idtipoBeneficiario=2 and suba.nombre = '$suba_nombre_look' order by suba.nombre"; 
       $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_comando; 
       $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
      if ($rs = $this->Db->SelectLimit($nm_comando, 10, 0)) 
       { 
          while (!$rs->EOF) 
          { 
            $cmp1 = trim($rs->fields[0]);
            $nmgp_def_dados[] = array($cmp1 => $cmp1); 
             $rs->MoveNext(); 
          } 
          $rs->Close(); 
       } 
       else  
       {  
           if  ($ajax == 'N')
           {  
              $this->Erro->mensagem (__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg()); 
              exit; 
           } 
           else
           {  
              echo $this->Db->ErrorMsg(); 
           } 
       } 
       }
       if (isset($nmgp_def_dados[0][$suba_nombre]))
       {
           $sAutocompValue = $nmgp_def_dados[0][$suba_nombre];
       }
       else
       {
           $sAutocompValue = $val_cmp;
           $val[0][0]      = $val_cmp;
       }
       $val_cmp = (isset($val[0][0])) ? $val[0][0] : "";
       $lin_obj .= "     <input  type=\"text\" class='sc-js-input " . $this->css_scAppDivToolbarInput . "' id='grid_search_suba_nombre_val_" . $ind . "' name='val_grid_search_suba_nombre_" . $ind . "' value=\"" . NM_encode_input($val_cmp) . "\" size=50 alt=\"{datatype: 'text', maxLength: 1800, allowedChars: '', lettersCase: '', autoTab: false, enterTab: false}\" style='display: none'>";
       $tmp_pos = strpos($val_cmp, "##@@");
       if ($tmp_pos !== false) {
           $val_cmp = substr($val_cmp, ($tmp_pos + 4));
           $sAutocompValue = substr($sAutocompValue, ($tmp_pos + 4));
       }
       $lin_obj .= "     <input class='sc-js-input " . $this->css_scAppDivToolbarInput . "' type='text' id='id_ac_grid_suba_nombre" . $ind . "' name='val_grid_search_suba_nombre_autocomp" . $ind . "' size='50' value='" . NM_encode_input($sAutocompValue) . "' alt=\"{datatype: 'text', maxLength: 50, allowedChars: '', lettersCase: '', autoTab: false, enterTab: false}\">";
       $lin_obj .= "       </span>";
       $lin_obj .= "          </div>";
       $lin_obj .= "          <div class='scGridFilterTagListFilterBar'>";
       $lin_obj .= nmButtonOutput($this->arr_buttons, "bapply_appdiv", "closeAllTags();setTimeout(function() {nm_proc_grid_search($ind, 'proc_grid_search', 'grid_search')}, 200);", "closeAllTags();setTimeout(function() {nm_proc_grid_search($ind, 'proc_grid_search', 'grid_search')}, 200);", "grid_search_apply_" . $ind . "", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
       $lin_obj .= "          </div>";
       $lin_obj .= "      </div>";
       return $lin_obj;
   }
   function lookup_ajax_ac_nombre($ac_nombre)
   {
       $ac_nombre = substr($this->Db->qstr($ac_nombre), 1, -1);
       $this->NM_case_insensitive = false;
       $ac_nombre_look = substr($this->Db->qstr($ac_nombre), 1, -1); 
       $nmgp_def_dados = array(); 
       $nm_comando = "select distinct ac.nombre from " . $this->Ini->nm_tabela . " where pl.idPlanificacion=" . $_SESSION['gloPlanificacion'] . " AND pl.idtipoBeneficiario=2 and  ac.nombre like '%" . $ac_nombre . "%' order by ac.nombre"; 
       $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_comando; 
       $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
      if ($rs = $this->Db->SelectLimit($nm_comando, 10, 0)) 
       { 
          while (!$rs->EOF) 
          { 
            $cmp1 = NM_charset_to_utf8(trim($rs->fields[0]));
            $cmp1 = grid_jdp_beneficiohogar_detalle_pack_protect_string($cmp1);
            $nmgp_def_dados[] = array($cmp1 => $cmp1); 
             $rs->MoveNext(); 
          } 
          $rs->Close(); 
          return $nmgp_def_dados; 
       } 
       else  
       {  
          echo $this->Db->ErrorMsg(); 
       } 
   }
   function lookup_ajax_suba_nombre($suba_nombre)
   {
       $suba_nombre = substr($this->Db->qstr($suba_nombre), 1, -1);
       $this->NM_case_insensitive = false;
       $suba_nombre_look = substr($this->Db->qstr($suba_nombre), 1, -1); 
       $nmgp_def_dados = array(); 
       $nm_comando = "select distinct suba.nombre from " . $this->Ini->nm_tabela . " where pl.idPlanificacion=" . $_SESSION['gloPlanificacion'] . " AND pl.idtipoBeneficiario=2 and  suba.nombre like '%" . $suba_nombre . "%' order by suba.nombre"; 
       $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_comando; 
       $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
      if ($rs = $this->Db->SelectLimit($nm_comando, 10, 0)) 
       { 
          while (!$rs->EOF) 
          { 
            $cmp1 = NM_charset_to_utf8(trim($rs->fields[0]));
            $cmp1 = grid_jdp_beneficiohogar_detalle_pack_protect_string($cmp1);
            $nmgp_def_dados[] = array($cmp1 => $cmp1); 
             $rs->MoveNext(); 
          } 
          $rs->Close(); 
          return $nmgp_def_dados; 
       } 
       else  
       {  
          echo $this->Db->ErrorMsg(); 
       } 
   }
   function gera_array_filtros()
   {
       $this->NM_fil_ant = array();
       $pos_path = strrpos($this->Ini->path_prod, "/");
       $this->NM_path_filter = $this->Ini->root . substr($this->Ini->path_prod, 0, $pos_path) . "/conf/filters/";
       $NM_patch   = "MealSint2/grid_jdp_beneficiohogar_detalle";
       if (is_dir($this->NM_path_filter . $NM_patch))
       {
           $NM_dir = @opendir($this->NM_path_filter . $NM_patch);
           while (FALSE !== ($NM_arq = @readdir($NM_dir)))
           {
             if (@is_file($this->NM_path_filter . $NM_patch . "/" . $NM_arq))
             {
                 $Sc_v6 = false;
                 $NMcmp_filter = file($this->NM_path_filter . $NM_patch . "/" . $NM_arq);
                 $NMcmp_filter = explode("@NMF@", $NMcmp_filter[0]);
                 if (substr($NMcmp_filter[0], 0, 6) == "SC_V6_" || substr($NMcmp_filter[0], 0, 6) == "SC_V8_")
                 {
                     $Name_filter = substr($NMcmp_filter[0], 6);
                     if (!empty($Name_filter))
                     {
                         $nmgp_save_name = str_replace('/', ' ', $Name_filter);
                         $nmgp_save_name = str_replace('\\', ' ', $nmgp_save_name);
                         $nmgp_save_name = str_replace('.', ' ', $nmgp_save_name);
                         $this->NM_fil_ant[$Name_filter][0] = $NM_patch . "/" . $nmgp_save_name;
                         $this->NM_fil_ant[$Name_filter][1] = "" . $this->Ini->Nm_lang['lang_srch_public']  . "";
                         $Sc_v6 = true;
                     }
                 }
                 if (!$Sc_v6)
                 {
                     $this->NM_fil_ant[$NM_arq][0] = $NM_patch . "/" . $NM_arq;
                     $this->NM_fil_ant[$NM_arq][1] = "" . $this->Ini->Nm_lang['lang_srch_public']  . "";
                 }
             }
           }
       }
       return $this->NM_fil_ant;
   }
   function JS_grid_search()
   {
       global $nm_saida;
       $nm_saida->saida("   <script type=\"text/javascript\">\r\n");
       $nm_saida->saida("     var Tot_obj_grid_search = " . $this->grid_search_seq . ";\r\n");
       $nm_saida->saida("     Tab_obj_grid_search = new Array();\r\n");
       $nm_saida->saida("     Tab_evt_grid_search = new Array();\r\n");
       foreach ($this->grid_search_dat as $seq => $cmp)
       {
           $nm_saida->saida("     Tab_obj_grid_search[" . $seq . "] = '" . $cmp . "';\r\n");
       }
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
       { 
           $this->Ini->Arr_result['setArr'][] = array('var' => 'Tab_obj_grid_search', 'value' => '');
           $this->Ini->Arr_result['setArr'][] = array('var' => 'Tab_evt_grid_search', 'value' => '');
           $this->Ini->Arr_result['setVar'][] = array('var' => 'Tot_obj_grid_search', 'value' => $this->grid_search_seq);
           foreach ($this->grid_search_dat as $seq => $cmp)
           {
               $this->Ini->Arr_result['setVar'][] = array('var' => 'Tab_obj_grid_search[' . $seq . ']', 'value' => $cmp);
           }
       } 
       $nm_saida->saida("     function SC_carga_evt_jquery_grid(tp_carga)\r\n");
       $nm_saida->saida("     {\r\n");
       $nm_saida->saida("         for (i = 1; i <= Tot_obj_grid_search; i++)\r\n");
       $nm_saida->saida("         {\r\n");
       $nm_saida->saida("             if (Tab_obj_grid_search[i] != 'NMSC_Grid_Null' && (tp_carga == 'all' || tp_carga == i))\r\n");
       $nm_saida->saida("             {\r\n");
       $nm_saida->saida("                 x   = 0;\r\n");
       $nm_saida->saida("                 tmp = Tab_obj_grid_search[i];\r\n");
       $nm_saida->saida("                 cps = new Array();\r\n");
       $nm_saida->saida("                 cps[x] = tmp;\r\n");
       $nm_saida->saida("                 for (x = 0; x < cps.length ; x++)\r\n");
       $nm_saida->saida("                 {\r\n");
       $nm_saida->saida("                     cmp = cps[x];\r\n");
       $nm_saida->saida("                     if (Tab_evt_grid_search[cmp])\r\n");
       $nm_saida->saida("                     {\r\n");
       $nm_saida->saida("                         eval (\"$('#grid_search_\" + cmp + \"_val_\" + i + \"').bind('change', function() {\" + Tab_evt_grid_search[cmp] + \"})\");\r\n");
       $nm_saida->saida("                     }\r\n");
       $nm_saida->saida("                 }\r\n");
       $nm_saida->saida("             }\r\n");
       $nm_saida->saida("         }\r\n");
       $nm_saida->saida("         for (i = 1; i <= Tot_obj_grid_search; i++)\r\n");
       $nm_saida->saida("         {\r\n");
       $nm_saida->saida("             if (Tab_obj_grid_search[i] != 'NMSC_Grid_Null' && (tp_carga == 'all' || tp_carga == i))\r\n");
       $nm_saida->saida("             {\r\n");
       $nm_saida->saida("                 tmp = Tab_obj_grid_search[i];\r\n");
       $nm_saida->saida("                 if (tmp == 'ac_nombre')\r\n");
       $nm_saida->saida("                 {\r\n");
       $nm_saida->saida("                      var x_ac_nombre = i;\r\n");
       $nm_saida->saida("                      $(\"#id_ac_grid_ac_nombre\" + i).autocomplete({\r\n");
       $nm_saida->saida("                        minLength: 1,\r\n");
       $nm_saida->saida("                        source: function (request, response) {\r\n");
       $nm_saida->saida("                        $.ajax({\r\n");
       $nm_saida->saida("                          url: \"index.php\",\r\n");
       $nm_saida->saida("                          dataType: \"json\",\r\n");
       $nm_saida->saida("                          data: {\r\n");
       $nm_saida->saida("                             q: request.term,\r\n");
       $nm_saida->saida("                             nmgp_opcao: \"ajax_aut_comp_dyn_search\",\r\n");
       $nm_saida->saida("                             origem: \"grid\",\r\n");
       $nm_saida->saida("                             field: \"ac_nombre\",\r\n");
       $nm_saida->saida("                             max_itens: \"10\",\r\n");
       $nm_saida->saida("                             cod_desc: \"N\",\r\n");
       $nm_saida->saida("                             script_case_init: " . $this->Ini->sc_page . "\r\n");
       $nm_saida->saida("                           },\r\n");
       $nm_saida->saida("                          success: function (data) {\r\n");
       $nm_saida->saida("                            if (data == \"ss_time_out\") {\r\n");
       $nm_saida->saida("                                nm_move();\r\n");
       $nm_saida->saida("                            }\r\n");
       $nm_saida->saida("                            response(data);\r\n");
       $nm_saida->saida("                          }\r\n");
       $nm_saida->saida("                         });\r\n");
       $nm_saida->saida("                        },\r\n");
       $nm_saida->saida("                        select: function (event, ui) {\r\n");
       $nm_saida->saida("                          $(\"#grid_search_ac_nombre_val_\" + x_ac_nombre).val(ui.item.value);\r\n");
       $nm_saida->saida("                          $(this).val(ui.item.label);\r\n");
       $nm_saida->saida("                          event.preventDefault();\r\n");
       $nm_saida->saida("                        },\r\n");
       $nm_saida->saida("                        focus: function (event, ui) {\r\n");
       $nm_saida->saida("                          $(\"#grid_search_ac_nombre_val_\" + x_ac_nombre).val(ui.item.value);\r\n");
       $nm_saida->saida("                          $(this).val(ui.item.label);\r\n");
       $nm_saida->saida("                          event.preventDefault();\r\n");
       $nm_saida->saida("                        },\r\n");
       $nm_saida->saida("                        change: function (event, ui) {\r\n");
       $nm_saida->saida("                          if (null == ui.item) {\r\n");
       $nm_saida->saida("                             $(\"#grid_search_ac_nombre_val_\" + x_ac_nombre).val( $(this).val() );\r\n");
       $nm_saida->saida("                          }\r\n");
       $nm_saida->saida("                        }\r\n");
       $nm_saida->saida("                      });\r\n");
       $nm_saida->saida("                 }\r\n");
       $nm_saida->saida("                 if (tmp == 'suba_nombre')\r\n");
       $nm_saida->saida("                 {\r\n");
       $nm_saida->saida("                      var x_suba_nombre = i;\r\n");
       $nm_saida->saida("                      $(\"#id_ac_grid_suba_nombre\" + i).autocomplete({\r\n");
       $nm_saida->saida("                        minLength: 1,\r\n");
       $nm_saida->saida("                        source: function (request, response) {\r\n");
       $nm_saida->saida("                        $.ajax({\r\n");
       $nm_saida->saida("                          url: \"index.php\",\r\n");
       $nm_saida->saida("                          dataType: \"json\",\r\n");
       $nm_saida->saida("                          data: {\r\n");
       $nm_saida->saida("                             q: request.term,\r\n");
       $nm_saida->saida("                             nmgp_opcao: \"ajax_aut_comp_dyn_search\",\r\n");
       $nm_saida->saida("                             origem: \"grid\",\r\n");
       $nm_saida->saida("                             field: \"suba_nombre\",\r\n");
       $nm_saida->saida("                             max_itens: \"10\",\r\n");
       $nm_saida->saida("                             cod_desc: \"N\",\r\n");
       $nm_saida->saida("                             script_case_init: " . $this->Ini->sc_page . "\r\n");
       $nm_saida->saida("                           },\r\n");
       $nm_saida->saida("                          success: function (data) {\r\n");
       $nm_saida->saida("                            if (data == \"ss_time_out\") {\r\n");
       $nm_saida->saida("                                nm_move();\r\n");
       $nm_saida->saida("                            }\r\n");
       $nm_saida->saida("                            response(data);\r\n");
       $nm_saida->saida("                          }\r\n");
       $nm_saida->saida("                         });\r\n");
       $nm_saida->saida("                        },\r\n");
       $nm_saida->saida("                        select: function (event, ui) {\r\n");
       $nm_saida->saida("                          $(\"#grid_search_suba_nombre_val_\" + x_suba_nombre).val(ui.item.value);\r\n");
       $nm_saida->saida("                          $(this).val(ui.item.label);\r\n");
       $nm_saida->saida("                          event.preventDefault();\r\n");
       $nm_saida->saida("                        },\r\n");
       $nm_saida->saida("                        focus: function (event, ui) {\r\n");
       $nm_saida->saida("                          $(\"#grid_search_suba_nombre_val_\" + x_suba_nombre).val(ui.item.value);\r\n");
       $nm_saida->saida("                          $(this).val(ui.item.label);\r\n");
       $nm_saida->saida("                          event.preventDefault();\r\n");
       $nm_saida->saida("                        },\r\n");
       $nm_saida->saida("                        change: function (event, ui) {\r\n");
       $nm_saida->saida("                          if (null == ui.item) {\r\n");
       $nm_saida->saida("                             $(\"#grid_search_suba_nombre_val_\" + x_suba_nombre).val( $(this).val() );\r\n");
       $nm_saida->saida("                          }\r\n");
       $nm_saida->saida("                        }\r\n");
       $nm_saida->saida("                      });\r\n");
       $nm_saida->saida("                 }\r\n");
       $nm_saida->saida("             }\r\n");
       $nm_saida->saida("         }\r\n");
       $nm_saida->saida("     }\r\n");
       $nm_saida->saida("     function grid_search_hide_input(field, ind)\r\n");
       $nm_saida->saida("     {\r\n");
       $nm_saida->saida("        var index = document.getElementById('grid_search_' + field + '_cond_' + ind).selectedIndex;\r\n");
       $nm_saida->saida("        var parm  = document.getElementById('grid_search_' + field + '_cond_' + ind).options[index].value;\r\n");
       $nm_saida->saida("        if (parm == \"nu\" || parm == \"nn\" || parm == \"ep\" || parm == \"ne\")\r\n");
       $nm_saida->saida("        {\r\n");
       $nm_saida->saida("            $('#grid_' + field + '_' + ind).css('display','none');\r\n");
       $nm_saida->saida("        }\r\n");
       $nm_saida->saida("        else\r\n");
       $nm_saida->saida("        {\r\n");
       $nm_saida->saida("            $('#grid_' + field + '_' + ind).css('display','');\r\n");
       $nm_saida->saida("        }\r\n");
       $nm_saida->saida("     }\r\n");
       $nm_saida->saida("     var addfilter_status = 'out';\r\n");
       $nm_saida->saida("     function nm_show_advancedsearch_fields()\r\n");
       $nm_saida->saida("     {\r\n");
       $nm_saida->saida("       var btn_id = 'add_grid_search';\r\n");
       $nm_saida->saida("       var obj_id = 'id_grid_search_add_tag';\r\n");
       $nm_saida->saida("       if($('#' + btn_id).offset().left + $('#' + obj_id).width() > $(document).width())\r\n");
       $nm_saida->saida("       {\r\n");
       $nm_saida->saida("            $('#' + obj_id).css('margin-left', ( $(document).width() - $('#' + btn_id).offset().left - $('#' + obj_id).width() - 10 ));\r\n");
       $nm_saida->saida("       }\r\n");
       $nm_saida->saida("       addfilter_status = 'open';\r\n");
       $nm_saida->saida("       $('#' + btn_id).mouseout(function() {\r\n");
       $nm_saida->saida("         setTimeout(function() {\r\n");
       $nm_saida->saida("           nm_hide_advancedsearch_fields(obj_id);\r\n");
       $nm_saida->saida("         }, 1000);\r\n");
       $nm_saida->saida("       });\r\n");
       $nm_saida->saida("       $('#' + obj_id + ' div').click(function() {\r\n");
       $nm_saida->saida("         addfilter_status = 'out';\r\n");
       $nm_saida->saida("         nm_hide_advancedsearch_fields(obj_id);\r\n");
       $nm_saida->saida("       });\r\n");
       $nm_saida->saida("       $('#' + obj_id).css({\r\n");
       $nm_saida->saida("         'left': $('#' + btn_id).left\r\n");
       $nm_saida->saida("       })\r\n");
       $nm_saida->saida("       .mouseover(function() {\r\n");
       $nm_saida->saida("         addfilter_status = 'over';\r\n");
       $nm_saida->saida("       })\r\n");
       $nm_saida->saida("       .mouseleave(function() {\r\n");
       $nm_saida->saida("         addfilter_status = 'out';\r\n");
       $nm_saida->saida("         setTimeout(function() {\r\n");
       $nm_saida->saida("           nm_hide_advancedsearch_fields(obj_id);\r\n");
       $nm_saida->saida("         }, 1000);\r\n");
       $nm_saida->saida("       })\r\n");
       $nm_saida->saida("       .show('fast');\r\n");
       $nm_saida->saida("     }\r\n");
       $nm_saida->saida("     function nm_hide_advancedsearch_fields(obj_id) {\r\n");
       $nm_saida->saida("      if ('over' != addfilter_status) {\r\n");
       $nm_saida->saida("        $('#' + obj_id).hide('fast');\r\n");
       $nm_saida->saida("      }\r\n");
       $nm_saida->saida("     }\r\n");
       $nm_saida->saida("     function closeAllTags(obj)\r\n");
       $nm_saida->saida("     {\r\n");
       $nm_saida->saida("         if (obj !== undefined)\r\n");
       $nm_saida->saida("         {\r\n");
       $nm_saida->saida("             if($(obj).parent().parent().parent().attr('new') == 'new')\r\n");
       $nm_saida->saida("             {\r\n");
       $nm_saida->saida("                 $(obj).parent().parent().parent().find('.scGridFilterTagListItemClose').click();\r\n");
       $nm_saida->saida("             }\r\n");
       $nm_saida->saida("         }\r\n");
       $nm_saida->saida("         $('.scGridFilterTagListFilter').hide();\r\n");
       $nm_saida->saida("     }\r\n");
       $nm_saida->saida("     function checkLastTag(bol_force)\r\n");
       $nm_saida->saida("     {\r\n");
       $nm_saida->saida("         if(bol_force || $('.scGridFilterTagListItem').length == 0)\r\n");
       $nm_saida->saida("         {\r\n");
       $nm_saida->saida("             $('#NM_Grid_Search').remove();\r\n");
       $nm_saida->saida("         }\r\n");
       $nm_saida->saida("     }\r\n");
       $nm_saida->saida("     var nm_empty_data_cond = ['ep','ne','nu','nn'];\r\n");
       $nm_saida->saida("     function nm_proc_grid_search(Seq, Tp_Proc, Origem)\r\n");
       $nm_saida->saida("     {\r\n");
       $nm_saida->saida("         var out_dyn = \"\";\r\n");
       $nm_saida->saida("         var i       = Seq;\r\n");
       $nm_saida->saida("         if (Tp_Proc == 'del_grid_search' || Tp_Proc == 'del_grid_search_all')\r\n");
       $nm_saida->saida("         {\r\n");
       $nm_saida->saida("             $('#add_grid_search').removeClass('scGridFilterTagAddDisabled');\r\n");
       $nm_saida->saida("             out_dyn += Tab_obj_grid_search[i] + \"_DYN_\" + Tp_Proc;\r\n");
       $nm_saida->saida("             if (Tp_Proc == 'del_grid_search_all')\r\n");
       $nm_saida->saida("             {\r\n");
       $nm_saida->saida("                 Tab_obj_grid_search = new Array();\r\n");
       $nm_saida->saida("                 checkLastTag(true);\r\n");
       $nm_saida->saida("             }\r\n");
       $nm_saida->saida("             else\r\n");
       $nm_saida->saida("             {\r\n");
       $nm_saida->saida("                 Tab_obj_grid_search[i] = 'NMSC_Grid_Null';\r\n");
       $nm_saida->saida("                 eval('Dropdownchecklist_'+ Tab_obj_grid_search[i] +'=false;');\r\n");
       $nm_saida->saida("             }\r\n");
       $nm_saida->saida("         }\r\n");
       $nm_saida->saida("         else\r\n");
       $nm_saida->saida("         {\r\n");
       $nm_saida->saida("             $('#grid_search_' + Tab_obj_grid_search[i]).attr('new', '');\r\n");
       $nm_saida->saida("             if (Tab_obj_grid_search[i] != 'NMSC_Grid_Null')\r\n");
       $nm_saida->saida("             {\r\n");
       $nm_saida->saida("                 out_dyn += Tab_obj_grid_search[i];\r\n");
       $nm_saida->saida("                 obj_dyn  = 'grid_search_' + Tab_obj_grid_search[i] + '_cond_' + i;\r\n");
       $nm_saida->saida("                 out_cond = grid_search_get_sel_cond(obj_dyn);\r\n");
       $nm_saida->saida("                 out_dyn += \"_DYN_\" + out_cond;\r\n");
       $nm_saida->saida("                 obj_dyn  = 'grid_search_' + Tab_obj_grid_search[i] + '_val_';\r\n");
       $nm_saida->saida("                 if (Tab_obj_grid_search[i] == 'ac_nombre')\r\n");
       $nm_saida->saida("                 {\r\n");
       $nm_saida->saida("                     obj_ac  = 'id_ac_grid_' + Tab_obj_grid_search[i] + i;\r\n");
       $nm_saida->saida("                     result  = grid_search_get_text(obj_dyn + i, obj_ac);\r\n");
       $nm_saida->saida("                 }\r\n");
       $nm_saida->saida("                 if (Tab_obj_grid_search[i] == 'suba_nombre')\r\n");
       $nm_saida->saida("                 {\r\n");
       $nm_saida->saida("                     obj_ac  = 'id_ac_grid_' + Tab_obj_grid_search[i] + i;\r\n");
       $nm_saida->saida("                     result  = grid_search_get_text(obj_dyn + i, obj_ac);\r\n");
       $nm_saida->saida("                 }\r\n");
       $nm_saida->saida("                 if((result == '' || result == '_VLS2_' || result == 'Y:_VLS_M:_VLS_D:_VLS2_Y:_VLS_M:_VLS_D:' || result == 'Y:_VLS_M:_VLS_D:_VLS_H:_VLS_I:_VLS_S:_VLS2_Y:_VLS_M:_VLS_D:_VLS_H:_VLS_I:_VLS_S:') && nm_empty_data_cond.indexOf(out_cond) == -1 && out_cond.substring(0, 3) != 'bi_')\r\n");
       $nm_saida->saida("                 {\r\n");
       $nm_saida->saida("                     alert(\"" . $this->Ini->Nm_lang['lang_srch_req_field'] . "\");\r\n");
       $nm_saida->saida("                     return false;\r\n");
       $nm_saida->saida("                 }\r\n");
       $nm_saida->saida("                 out_dyn += \"_DYN_\" + result;\r\n");
       $nm_saida->saida("             }\r\n");
       $nm_saida->saida("         }\r\n");
       $nm_saida->saida("         ajax_navigate(Origem, out_dyn);\r\n");
       $nm_saida->saida("     }\r\n");
       $nm_saida->saida("     function nm_save_grid_search()\r\n");
       $nm_saida->saida("     {\r\n");
       $nm_saida->saida("         if (document.Fgrid_search_save.nmgp_save_name.value == '')\r\n");
       $nm_saida->saida("         {\r\n");
       $nm_saida->saida("             alert(\"" . $this->Ini->Nm_lang['lang_srch_req_field'] . "\");\r\n");
       $nm_saida->saida("             document.Fgrid_search_save.nmgp_save_name.focus();\r\n");
       $nm_saida->saida("             return false;\r\n");
       $nm_saida->saida("         }\r\n");
       $nm_saida->saida("         save_name = document.Fgrid_search_save.nmgp_save_name.value;\r\n");
       $nm_saida->saida("         save_opt  = \"\"\r\n");
       $nm_saida->saida("         str_out = \"\";\r\n");
       $nm_saida->saida("         for (i = 1; i <= Tot_obj_grid_search; i++)\r\n");
       $nm_saida->saida("         {\r\n");
       $nm_saida->saida("             if (Tab_obj_grid_search[i] != 'NMSC_Grid_Null')\r\n");
       $nm_saida->saida("             {\r\n");
       $nm_saida->saida("                 obj_dyn  = 'grid_search_' + Tab_obj_grid_search[i] + '_cond_' + i;\r\n");
       $nm_saida->saida("                 out_cond = grid_search_get_sel_cond(obj_dyn);\r\n");
       $nm_saida->saida("                 str_out += \"SC_\" + Tab_obj_grid_search[i] + \"_cond#NMF#\" + out_cond + \"@NMF@\";\r\n");
       $nm_saida->saida("                 obj_dyn  = 'grid_search_' + Tab_obj_grid_search[i] + '_val_';\r\n");
       $nm_saida->saida("                 obj_dyn2 = 'grid_search_' + Tab_obj_grid_search[i] + '_v2__val_';\r\n");
       $nm_saida->saida("                 if (Tab_obj_grid_search[i] == 'ac_nombre')\r\n");
       $nm_saida->saida("                 {\r\n");
       $nm_saida->saida("                     result  = grid_search_get_text(obj_dyn + i, '');\r\n");
       $nm_saida->saida("                     str_out += \"SC_\" + Tab_obj_grid_search[i] + \"#NMF#\" + result + \"@NMF@\";\r\n");
       $nm_saida->saida("                     obj_ac  = 'id_ac_grid_' + Tab_obj_grid_search[i] + i;\r\n");
       $nm_saida->saida("                     result  = grid_search_get_text(obj_dyn + i, obj_ac);\r\n");
       $nm_saida->saida("                     str_out += \"id_ac_\" + Tab_obj_grid_search[i] + \"#NMF#\" + result + \"@NMF@\";\r\n");
       $nm_saida->saida("                 }\r\n");
       $nm_saida->saida("                 if (Tab_obj_grid_search[i] == 'suba_nombre')\r\n");
       $nm_saida->saida("                 {\r\n");
       $nm_saida->saida("                     result  = grid_search_get_text(obj_dyn + i, '');\r\n");
       $nm_saida->saida("                     str_out += \"SC_\" + Tab_obj_grid_search[i] + \"#NMF#\" + result + \"@NMF@\";\r\n");
       $nm_saida->saida("                     obj_ac  = 'id_ac_grid_' + Tab_obj_grid_search[i] + i;\r\n");
       $nm_saida->saida("                     result  = grid_search_get_text(obj_dyn + i, obj_ac);\r\n");
       $nm_saida->saida("                     str_out += \"id_ac_\" + Tab_obj_grid_search[i] + \"#NMF#\" + result + \"@NMF@\";\r\n");
       $nm_saida->saida("                 }\r\n");
       $nm_saida->saida("             }\r\n");
       $nm_saida->saida("         }\r\n");
       $nm_saida->saida("         nmAjaxProcOn();\r\n");
       $nm_saida->saida("         $.ajax({\r\n");
       $nm_saida->saida("           type: \"POST\",\r\n");
       $nm_saida->saida("           url: \"index.php\",\r\n");
       $nm_saida->saida("           data: \"nmgp_opcao=ajax_filter_save&script_case_init=\" + document.Fgrid_search.script_case_init.value + \"&nmgp_save_name=\" + save_name + \"&nmgp_save_option=\" + save_opt + \"&NM_filters_save=\" + str_out + \"&nmgp_save_origem=grid\"\r\n");
       $nm_saida->saida("          })\r\n");
       $nm_saida->saida("          .done(function(json_save_fil) {\r\n");
       $nm_saida->saida("             var i, oResp;\r\n");
       $nm_saida->saida("             Tst_integrid = json_save_fil.trim();\r\n");
       $nm_saida->saida("             if (\"{\" != Tst_integrid.substr(0, 1)) {\r\n");
       $nm_saida->saida("                 nmAjaxProcOff();\r\n");
       $nm_saida->saida("                 alert (json_save_fil);\r\n");
       $nm_saida->saida("                 return;\r\n");
       $nm_saida->saida("             }\r\n");
       $nm_saida->saida("             eval(\"oResp = \" + json_save_fil);\r\n");
       $nm_saida->saida("             if (oResp[\"ss_time_out\"]) {\r\n");
       $nm_saida->saida("                 nmAjaxProcOff();\r\n");
       $nm_saida->saida("                 nm_move();\r\n");
       $nm_saida->saida("             }\r\n");
       $nm_saida->saida("             if (oResp[\"setValue\"]) {\r\n");
       $nm_saida->saida("               for (i = 0; i < oResp[\"setValue\"].length; i++) {\r\n");
       $nm_saida->saida("                    $(\"#\" + oResp[\"setValue\"][i][\"field\"]).html(oResp[\"setValue\"][i][\"value\"]);\r\n");
       $nm_saida->saida("               }\r\n");
       $nm_saida->saida("             }\r\n");
       $nm_saida->saida("             if (oResp[\"htmOutput\"]) {\r\n");
       $nm_saida->saida("                 nmAjaxShowDebug(oResp);\r\n");
       $nm_saida->saida("              }\r\n");
       $nm_saida->saida("             document.getElementById('SC_nmgp_save_name').value = '';\r\n");
       $nm_saida->saida("             document.getElementById('Apaga_filters').style.display = '';\r\n");
       $nm_saida->saida("             document.getElementById('id_sel_recup_filters').style.display = '';\r\n");
       $nm_saida->saida("             document.getElementById('Salvar_filters').style.display = 'none';\r\n");
       $nm_saida->saida("             document.getElementById('id_sel_recup_filters').selectedIndex = -1;\r\n");
       $nm_saida->saida("             document.getElementById('sel_filters_del').selectedIndex = -1;\r\n");
       $nm_saida->saida("             nmAjaxProcOff();\r\n");
       $nm_saida->saida("         });\r\n");
       $nm_saida->saida("     }\r\n");
       $nm_saida->saida("     function nm_del_grid_search()\r\n");
       $nm_saida->saida("     {\r\n");
       $nm_saida->saida("        obj_sel = document.Fgrid_search_save.elements['NM_filters_del'];\r\n");
       $nm_saida->saida("        index   = obj_sel.selectedIndex;\r\n");
       $nm_saida->saida("        if (index == -1 || obj_sel.options[index].value == \"\") \r\n");
       $nm_saida->saida("        {\r\n");
       $nm_saida->saida("            return false;\r\n");
       $nm_saida->saida("        }\r\n");
       $nm_saida->saida("        parm = obj_sel.options[index].value;\r\n");
       $nm_saida->saida("        nmAjaxProcOn();\r\n");
       $nm_saida->saida("        $.ajax({\r\n");
       $nm_saida->saida("          type: \"POST\",\r\n");
       $nm_saida->saida("          url: \"index.php\",\r\n");
       $nm_saida->saida("          data: \"nmgp_opcao=ajax_filter_delete&script_case_init=\" + document.Fgrid_search.script_case_init.value + \"&NM_filters_del=\" + parm + \"&nmgp_save_origem=grid\"\r\n");
       $nm_saida->saida("         })\r\n");
       $nm_saida->saida("         .done(function(json_del_fil) {\r\n");
       $nm_saida->saida("            var i, oResp;\r\n");
       $nm_saida->saida("            Tst_integrid = json_del_fil.trim();\r\n");
       $nm_saida->saida("            if (\"{\" != Tst_integrid.substr(0, 1)) {\r\n");
       $nm_saida->saida("                nmAjaxProcOff();\r\n");
       $nm_saida->saida("                alert (json_del_fil);\r\n");
       $nm_saida->saida("                return;\r\n");
       $nm_saida->saida("            }\r\n");
       $nm_saida->saida("            eval(\"oResp = \" + json_del_fil);\r\n");
       $nm_saida->saida("             if (oResp[\"ss_time_out\"]) {\r\n");
       $nm_saida->saida("                 nmAjaxProcOff();\r\n");
       $nm_saida->saida("                 nm_move();\r\n");
       $nm_saida->saida("             }\r\n");
       $nm_saida->saida("            if (oResp[\"setValue\"]) {\r\n");
       $nm_saida->saida("              for (i = 0; i < oResp[\"setValue\"].length; i++) {\r\n");
       $nm_saida->saida("                   $(\"#\" + oResp[\"setValue\"][i][\"field\"]).html(oResp[\"setValue\"][i][\"value\"]);\r\n");
       $nm_saida->saida("              }\r\n");
       $nm_saida->saida("            }\r\n");
       $nm_saida->saida("            if (oResp[\"htmOutput\"]) {\r\n");
       $nm_saida->saida("                nmAjaxShowDebug(oResp);\r\n");
       $nm_saida->saida("            }\r\n");
       $nm_saida->saida("            nmAjaxProcOff();\r\n");
       $nm_saida->saida("        });\r\n");
       $nm_saida->saida("     }\r\n");
       $nm_saida->saida("     function nm_change_grid_search(obj_sel)\r\n");
       $nm_saida->saida("     {\r\n");
       $nm_saida->saida("        index = obj_sel.selectedIndex;\r\n");
       $nm_saida->saida("        if (index == -1 || obj_sel.options[index].value == \"\") \r\n");
       $nm_saida->saida("        {\r\n");
       $nm_saida->saida("            return false;\r\n");
       $nm_saida->saida("        }\r\n");
       $nm_saida->saida("        for (i = 1; i <= Tot_obj_grid_search; i++)\r\n");
       $nm_saida->saida("        {\r\n");
       $nm_saida->saida("            $('#grid_search_' + Tab_obj_grid_search[i]).remove();\r\n");
       $nm_saida->saida("             eval('Dropdownchecklist_'+ Tab_obj_grid_search[i] +'=false;');\r\n");
       $nm_saida->saida("        }\r\n");
       $nm_saida->saida("        Tot_obj_grid_search = 0;\r\n");
       $nm_saida->saida("        Tab_obj_grid_search = new Array();\r\n");
       $nm_saida->saida("        ajax_navigate('grid_search_change_fil', obj_sel.options[index].value);;\r\n");
       $nm_saida->saida("     }\r\n");
       $nm_saida->saida("     function grid_search_get_sel_cond(obj_id)\r\n");
       $nm_saida->saida("     {\r\n");
       $nm_saida->saida("        var index = document.getElementById(obj_id).selectedIndex;\r\n");
       $nm_saida->saida("        return document.getElementById(obj_id).options[index].value;\r\n");
       $nm_saida->saida("     }\r\n");
       $nm_saida->saida("     function grid_search_get_select(obj_id, str_type)\r\n");
       $nm_saida->saida("     {\r\n");
       $nm_saida->saida("        if(str_type == '')\r\n");
       $nm_saida->saida("        {\r\n");
       $nm_saida->saida("            var obj = document.getElementById(obj_id);\r\n");
       $nm_saida->saida("        }\r\n");
       $nm_saida->saida("        else\r\n");
       $nm_saida->saida("        {\r\n");
       $nm_saida->saida("            var obj = $('#' + obj_id).multipleSelect('getSelects');\r\n");
       $nm_saida->saida("        }\r\n");
       $nm_saida->saida("        var val = \"\";\r\n");
       $nm_saida->saida("        for (iSelect = 0; iSelect < obj.length; iSelect++)\r\n");
       $nm_saida->saida("        {\r\n");
       $nm_saida->saida("            if ((str_type == '' && obj[iSelect].selected) || (str_type=='RADIO' || str_type=='CHECKBOX'))\r\n");
       $nm_saida->saida("            {\r\n");
       $nm_saida->saida("                if(str_type == '' && obj[iSelect].selected)\r\n");
       $nm_saida->saida("                {\r\n");
       $nm_saida->saida("                    new_val = obj[iSelect].value;\r\n");
       $nm_saida->saida("                }\r\n");
       $nm_saida->saida("                else\r\n");
       $nm_saida->saida("                {\r\n");
       $nm_saida->saida("                    new_val = obj[iSelect];\r\n");
       $nm_saida->saida("                }\r\n");
       $nm_saida->saida("                val += (val != \"\") ? \"_VLS_\" : \"\";\r\n");
       $nm_saida->saida("                val += new_val;\r\n");
       $nm_saida->saida("            }\r\n");
       $nm_saida->saida("        }\r\n");
       $nm_saida->saida("        return val;\r\n");
       $nm_saida->saida("     }\r\n");
       $nm_saida->saida("     function grid_search_get_Dselelect(obj_id)\r\n");
       $nm_saida->saida("     {\r\n");
       $nm_saida->saida("        var obj = document.getElementById(obj_id);\r\n");
       $nm_saida->saida("        var val = \"\";\r\n");
       $nm_saida->saida("        for (iSelect = 0; iSelect < obj.length; iSelect++)\r\n");
       $nm_saida->saida("        {\r\n");
       $nm_saida->saida("            val += (val != \"\") ? \"_VLS_\" : \"\";\r\n");
       $nm_saida->saida("            val += obj[iSelect].value;\r\n");
       $nm_saida->saida("        }\r\n");
       $nm_saida->saida("        return val;\r\n");
       $nm_saida->saida("     }\r\n");
       $nm_saida->saida("     function grid_search_get_radio(obj_id)\r\n");
       $nm_saida->saida("     {\r\n");
       $nm_saida->saida("        var Nobj = document.getElementById(obj_id).name;\r\n");
       $nm_saida->saida("        var obj  = document.getElementsByName(Nobj);\r\n");
       $nm_saida->saida("        var val  = \"\";\r\n");
       $nm_saida->saida("        for (iRadio = 0; iRadio < obj.length; iRadio++)\r\n");
       $nm_saida->saida("        {\r\n");
       $nm_saida->saida("            if (obj[iRadio].checked)\r\n");
       $nm_saida->saida("            {\r\n");
       $nm_saida->saida("                val += (val != \"\") ? \"_VLS_\" : \"\";\r\n");
       $nm_saida->saida("                val += obj[iRadio].value;\r\n");
       $nm_saida->saida("            }\r\n");
       $nm_saida->saida("        }\r\n");
       $nm_saida->saida("        return val;\r\n");
       $nm_saida->saida("     }\r\n");
       $nm_saida->saida("     function grid_search_get_checkbox(obj_id)\r\n");
       $nm_saida->saida("     {\r\n");
       $nm_saida->saida("        var Nobj = document.getElementById(obj_id).name;\r\n");
       $nm_saida->saida("        var obj  = document.getElementsByName(Nobj);\r\n");
       $nm_saida->saida("        var val  = \"\";\r\n");
       $nm_saida->saida("        if (!obj.length)\r\n");
       $nm_saida->saida("        {\r\n");
       $nm_saida->saida("            if (obj.checked)\r\n");
       $nm_saida->saida("            {\r\n");
       $nm_saida->saida("                val = obj.value;\r\n");
       $nm_saida->saida("            }\r\n");
       $nm_saida->saida("            return val;\r\n");
       $nm_saida->saida("        }\r\n");
       $nm_saida->saida("        else\r\n");
       $nm_saida->saida("        {\r\n");
       $nm_saida->saida("            for (iCheck = 0; iCheck < obj.length; iCheck++)\r\n");
       $nm_saida->saida("            {\r\n");
       $nm_saida->saida("                if (obj[iCheck].checked)\r\n");
       $nm_saida->saida("                {\r\n");
       $nm_saida->saida("                    val += (val != \"\") ? \"_VLS_\" : \"\";\r\n");
       $nm_saida->saida("                    val += obj[iCheck].value;\r\n");
       $nm_saida->saida("                }\r\n");
       $nm_saida->saida("            }\r\n");
       $nm_saida->saida("        }\r\n");
       $nm_saida->saida("        return val;\r\n");
       $nm_saida->saida("     }\r\n");
       $nm_saida->saida("     function grid_search_get_text(obj_id, obj_ac)\r\n");
       $nm_saida->saida("     {\r\n");
       $nm_saida->saida("        var obj = document.getElementById(obj_id);\r\n");
       $nm_saida->saida("        var val = \"\";\r\n");
       $nm_saida->saida("        if (obj)\r\n");
       $nm_saida->saida("        {\r\n");
       $nm_saida->saida("            val = obj.value;\r\n");
       $nm_saida->saida("        }\r\n");
       $nm_saida->saida("        if (obj_ac != '' && val == '')\r\n");
       $nm_saida->saida("        {\r\n");
       $nm_saida->saida("            obj = document.getElementById(obj_ac);\r\n");
       $nm_saida->saida("            if (obj)\r\n");
       $nm_saida->saida("            {\r\n");
       $nm_saida->saida("                val = obj.value;\r\n");
       $nm_saida->saida("            }\r\n");
       $nm_saida->saida("        }\r\n");
       $nm_saida->saida("        return val;\r\n");
       $nm_saida->saida("     }\r\n");
       $nm_saida->saida("     function grid_search_get_dt_h(obj_id, ind, TP)\r\n");
       $nm_saida->saida("     {\r\n");
       $nm_saida->saida("        var val = new Array();\r\n");
       $nm_saida->saida("        if (TP == 'DT' || TP == 'DH')\r\n");
       $nm_saida->saida("        {\r\n");
       $nm_saida->saida("            obj_part  = document.getElementById(obj_id + '_ano_val_' + ind);\r\n");
       $nm_saida->saida("            val      += \"Y:\";\r\n");
       $nm_saida->saida("            if (obj_part && obj_part.type.substr(0, 6) == 'select')\r\n");
       $nm_saida->saida("            {\r\n");
       $nm_saida->saida("                Tval = grid_search_get_sel_cond(obj_id + '_ano_val_' + ind);\r\n");
       $nm_saida->saida("                val += (Tval != -1) ? Tval : '';\r\n");
       $nm_saida->saida("            }\r\n");
       $nm_saida->saida("            else\r\n");
       $nm_saida->saida("            {\r\n");
       $nm_saida->saida("                val += (obj_part) ? obj_part.value : '';\r\n");
       $nm_saida->saida("            }\r\n");
       $nm_saida->saida("            obj_part  = document.getElementById(obj_id + '_mes_val_' + ind);\r\n");
       $nm_saida->saida("            val      += \"_VLS_M:\";\r\n");
       $nm_saida->saida("            if (obj_part && obj_part.type.substr(0, 6) == 'select')\r\n");
       $nm_saida->saida("            {\r\n");
       $nm_saida->saida("                Tval = grid_search_get_sel_cond(obj_id + '_mes_val_' + ind);\r\n");
       $nm_saida->saida("                val += (Tval != -1) ? Tval : '';\r\n");
       $nm_saida->saida("            }\r\n");
       $nm_saida->saida("            else\r\n");
       $nm_saida->saida("            {\r\n");
       $nm_saida->saida("                val += (obj_part) ? obj_part.value : '';\r\n");
       $nm_saida->saida("            }\r\n");
       $nm_saida->saida("            obj_part  = document.getElementById(obj_id + '_dia_val_' + ind);\r\n");
       $nm_saida->saida("            val      += \"_VLS_D:\";\r\n");
       $nm_saida->saida("            if (obj_part && obj_part.type.substr(0, 6) == 'select')\r\n");
       $nm_saida->saida("            {\r\n");
       $nm_saida->saida("                Tval = grid_search_get_sel_cond(obj_id + '_dia_val_' + ind);\r\n");
       $nm_saida->saida("                val += (Tval != -1) ? Tval : '';\r\n");
       $nm_saida->saida("            }\r\n");
       $nm_saida->saida("            else\r\n");
       $nm_saida->saida("            {\r\n");
       $nm_saida->saida("                val += (obj_part) ? obj_part.value : '';\r\n");
       $nm_saida->saida("            }\r\n");
       $nm_saida->saida("        }\r\n");
       $nm_saida->saida("        if (TP == 'HH' || TP == 'DH')\r\n");
       $nm_saida->saida("        {\r\n");
       $nm_saida->saida("            val            += (val != \"\") ? \"_VLS_\" : \"\";\r\n");
       $nm_saida->saida("            obj_part        = document.getElementById(obj_id + '_hor_val_' + ind);\r\n");
       $nm_saida->saida("            val            += \"H:\";\r\n");
       $nm_saida->saida("            val            += (obj_part) ? obj_part.value : '';\r\n");
       $nm_saida->saida("            obj_part        = document.getElementById(obj_id + '_min_val_' + ind);\r\n");
       $nm_saida->saida("            val            += \"_VLS_I:\";\r\n");
       $nm_saida->saida("            val            += (obj_part) ? obj_part.value : '';\r\n");
       $nm_saida->saida("            obj_part        = document.getElementById(obj_id + '_seg_val_' + ind);\r\n");
       $nm_saida->saida("            val            += \"_VLS_S:\";\r\n");
       $nm_saida->saida("            val            += (obj_part) ? obj_part.value : '';\r\n");
       $nm_saida->saida("        }\r\n");
       $nm_saida->saida("        return val;\r\n");
       $nm_saida->saida("     }\r\n");
       $nm_saida->saida("   </script>\r\n");
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
 function check_btns()
 {
 }
 function nm_fim_grid($flag_apaga_pdf_log = TRUE)
 {
   global
   $nm_saida, $nm_url_saida, $NMSC_modal;
   if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && isset($_SESSION['sc_session'][$this->Ini->sc_page]['SC_sub_css']))
   {
       unset($_SESSION['sc_session'][$this->Ini->sc_page]['SC_sub_css']);
       unset($_SESSION['sc_session'][$this->Ini->sc_page]['SC_sub_css_bw']);
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'])
   { 
        return;
   } 
   $nm_saida->saida("   </TABLE></TD>\r\n");
   $nm_saida->saida("   </TR>\r\n");
   if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "pdf" &&
        $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "print" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao_print'] != "print" && !$this->Print_All) 
   { 
      $nm_saida->saida("     <tr><td colspan=3  class=\"" . $this->css_scGridTabelaTd . "\" style=\"vertical-align: top\"> \r\n");
      $nm_saida->saida("     <iframe class=\"css_iframes\" id=\"nmsc_iframe_liga_B_grid_jdp_beneficiohogar_detalle\" marginWidth=\"0px\" marginHeight=\"0px\" frameborder=\"0\" valign=\"top\" height=\"0px\" width=\"0px\" name=\"nm_iframe_liga_B_grid_jdp_beneficiohogar_detalle\" scrolling=\"auto\" src=\"NM_Blank_Page.htm\"></iframe>\r\n");
      $nm_saida->saida("     </td></tr> \r\n");
   } 
   $nm_saida->saida("   </TABLE>\r\n");
   $nm_saida->saida("   </div>\r\n");
   $nm_saida->saida("   </TR>\r\n");
   $nm_saida->saida("   </TD>\r\n");
   $nm_saida->saida("   </TABLE>\r\n");
   $nm_saida->saida("   <div id=\"sc-id-fixedheaders-placeholder\" style=\"display: none; position: fixed; top: 0\"></div>\r\n");
   $nm_saida->saida("   </body>\r\n");
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] == "pdf" || $this->Print_All)
   { 
   $nm_saida->saida("   </HTML>\r\n");
        return;
   } 
   $nm_saida->saida("   <script type=\"text/javascript\">\r\n");
   $nm_saida->saida("   NM_ancor_ult_lig = '';\r\n");
   if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['embutida'])
   { 
       if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['NM_arr_tree']))
       {
           $temp = array();
           foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['NM_arr_tree'] as $NM_aplic => $resto)
           {
               $temp[] = $NM_aplic;
           }
           $temp = array_unique($temp);
           foreach ($temp as $NM_aplic)
           {
               if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
               { 
                   $this->Ini->Arr_result['setArr'][] = array('var' => ' NM_tab_' . $NM_aplic, 'value' => '');
               } 
               $nm_saida->saida("   NM_tab_" . $NM_aplic . " = new Array();\r\n");
           }
           foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['NM_arr_tree'] as $NM_aplic => $resto)
           {
               foreach ($resto as $NM_ind => $NM_quebra)
               {
                   foreach ($NM_quebra as $NM_nivel => $NM_tipo)
                   {
                       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
                       { 
                           $this->Ini->Arr_result['setVar'][] = array('var' => ' NM_tab_' . $NM_aplic . '[' . $NM_ind . ']', 'value' => $NM_tipo . $NM_nivel);
                       } 
                       $nm_saida->saida("   NM_tab_" . $NM_aplic . "[" . $NM_ind . "] = '" . $NM_tipo . $NM_nivel . "';\r\n");
                   }
               }
           }
       }
   }
   $nm_saida->saida("   function NM_liga_tbody(tbody, Obj, Apl)\r\n");
   $nm_saida->saida("   {\r\n");
   $nm_saida->saida("      Nivel = parseInt (Obj[tbody].substr(3));\r\n");
   $nm_saida->saida("      for (ind = tbody + 1; ind < Obj.length; ind++)\r\n");
   $nm_saida->saida("      {\r\n");
   $nm_saida->saida("           Nv = parseInt (Obj[ind].substr(3));\r\n");
   $nm_saida->saida("           Tp = Obj[ind].substr(0, 3);\r\n");
   $nm_saida->saida("           if (Nivel == Nv && Tp == 'top')\r\n");
   $nm_saida->saida("           {\r\n");
   $nm_saida->saida("               break;\r\n");
   $nm_saida->saida("           }\r\n");
   $nm_saida->saida("           if (((Nivel + 1) == Nv && Tp == 'top') || (Nivel == Nv && Tp == 'bot'))\r\n");
   $nm_saida->saida("           {\r\n");
   $nm_saida->saida("               document.getElementById('tbody_' + Apl + '_' + ind + '_' + Tp).style.display='';\r\n");
   $nm_saida->saida("           } \r\n");
   $nm_saida->saida("      }\r\n");
   $nm_saida->saida("   }\r\n");
   $nm_saida->saida("   function NM_apaga_tbody(tbody, Obj, Apl)\r\n");
   $nm_saida->saida("   {\r\n");
   $nm_saida->saida("      Nivel = Obj[tbody].substr(3);\r\n");
   $nm_saida->saida("      for (ind = tbody + 1; ind < Obj.length; ind++)\r\n");
   $nm_saida->saida("      {\r\n");
   $nm_saida->saida("           Nv = Obj[ind].substr(3);\r\n");
   $nm_saida->saida("           Tp = Obj[ind].substr(0, 3);\r\n");
   $nm_saida->saida("           if ((Nivel == Nv && Tp == 'top') || Nv < Nivel)\r\n");
   $nm_saida->saida("           {\r\n");
   $nm_saida->saida("               break;\r\n");
   $nm_saida->saida("           }\r\n");
   $nm_saida->saida("           if ((Nivel != Nv) || (Nivel == Nv && Tp == 'bot'))\r\n");
   $nm_saida->saida("           {\r\n");
   $nm_saida->saida("               document.getElementById('tbody_' + Apl + '_' + ind + '_' + Tp).style.display='none';\r\n");
   $nm_saida->saida("               if (Tp == 'top')\r\n");
   $nm_saida->saida("               {\r\n");
   $nm_saida->saida("                   document.getElementById('b_open_' + Apl + '_' + ind).style.display='';\r\n");
   $nm_saida->saida("                   document.getElementById('b_close_' + Apl + '_' + ind).style.display='none';\r\n");
   $nm_saida->saida("               } \r\n");
   $nm_saida->saida("           } \r\n");
   $nm_saida->saida("      }\r\n");
   $nm_saida->saida("   }\r\n");
   $nm_saida->saida("   NM_obj_ant = '';\r\n");
   $nm_saida->saida("   function NM_apaga_div_lig(obj_nome)\r\n");
   $nm_saida->saida("   {\r\n");
   $nm_saida->saida("      if (NM_obj_ant != '')\r\n");
   $nm_saida->saida("      {\r\n");
   $nm_saida->saida("          NM_obj_ant.style.display='none';\r\n");
   $nm_saida->saida("      }\r\n");
   $nm_saida->saida("      obj = document.getElementById(obj_nome);\r\n");
   $nm_saida->saida("      NM_obj_ant = obj;\r\n");
   $nm_saida->saida("      ind_time = setTimeout(\"obj.style.display='none'\", 300);\r\n");
   $nm_saida->saida("      return ind_time;\r\n");
   $nm_saida->saida("   }\r\n");
   $nm_saida->saida("   function NM_btn_disable()\r\n");
   $nm_saida->saida("   {\r\n");
   foreach ($this->nm_btn_disabled as $cod_btn => $st_btn) {
      if (isset($this->nm_btn_exist[$cod_btn]) && $st_btn == 'on') {
         foreach ($this->nm_btn_exist[$cod_btn] as $cada_id) {
       $nm_saida->saida("     $('#" . $cada_id . "').prop('onclick', null).off('click').addClass('disabled').removeAttr('href');\r\n");
       $nm_saida->saida("     $('#div_" . $cada_id . "').addClass('disabled');\r\n");
         }
      }
   }
   $nm_saida->saida("   }\r\n");
   $str_pbfile = $this->Ini->root . $this->Ini->path_imag_temp . '/sc_pb_' . session_id() . '.tmp';
   if (@is_file($str_pbfile) && $flag_apaga_pdf_log)
   {
      @unlink($str_pbfile);
   }
   if ($this->Rec_ini == 0 && empty($this->nm_grid_sem_reg) && !$this->Print_All && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "pdf" && !$_SESSION['scriptcase']['proc_mobile'])
   { 
       $nm_saida->saida("   document.getElementById('first_bot').disabled = true;\r\n");
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
       {
           $this->Ini->Arr_result['setDisabled'][] = array('field' => 'first_bot', 'value' => "true");
       }
       $nm_saida->saida("   document.getElementById('back_bot').disabled = true;\r\n");
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
       {
           $this->Ini->Arr_result['setDisabled'][] = array('field' => 'back_bot', 'value' => "true");
       }
   } 
   elseif ($this->Rec_ini == 0 && empty($this->nm_grid_sem_reg) && !$this->Print_All && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "pdf" && $_SESSION['scriptcase']['proc_mobile'])
   { 
       $nm_saida->saida("   document.getElementById('first_bot').disabled = true;\r\n");
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
       {
           $this->Ini->Arr_result['setDisabled'][] = array('field' => 'first_bot', 'value' => "true");
       }
       $nm_saida->saida("   document.getElementById('back_bot').disabled = true;\r\n");
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
       {
           $this->Ini->Arr_result['setDisabled'][] = array('field' => 'back_bot', 'value' => "true");
       }
   } 
   $nm_saida->saida("  $(window).scroll(function() {\r\n");
   $nm_saida->saida("   if (typeof(scSetFixedHeaders) === typeof(function(){})) scSetFixedHeaders();\r\n");
   $nm_saida->saida("  }).resize(function() {\r\n");
   $nm_saida->saida("   if (typeof(scSetFixedHeaders) === typeof(function(){})) scSetFixedHeaders();\r\n");
   $nm_saida->saida("  });\r\n");
   if ($this->rs_grid->EOF && empty($this->nm_grid_sem_reg) && !$this->Print_All && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "pdf")
   {
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "pdf" && !isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_liga']['nav']) && !$_SESSION['scriptcase']['proc_mobile'])
       { 
           { 
               $nm_saida->saida("   document.getElementById('forward_bot').disabled = true;\r\n");
               $nm_saida->saida("   document.getElementById('forward_bot').className = \"scButton_" . $this->arr_buttons['bcons_avanca']['style'] . " disabled\";\r\n");
               if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
               {
                   $this->Ini->Arr_result['setDisabled'][] = array('field' => 'forward_bot', 'value' => "true");
                   $this->Ini->Arr_result['setClass'][] = array('field' => 'forward_bot', 'value' => "scButton_" . $this->arr_buttons['bcons_avanca']['style'] . ' disabled');
               }
               if ($this->arr_buttons['bcons_avanca']['display'] == 'only_img' || $this->arr_buttons['bcons_avanca']['display'] == 'text_img')
               { 
                   $nm_saida->saida("   document.getElementById('id_img_forward_bot').src = \"" . $this->Ini->path_botoes . "/" . $this->arr_buttons['bcons_avanca']['image'] . "\";\r\n");
                   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
                   {
                       $this->Ini->Arr_result['setSrc'][] = array('field' => 'id_img_forward_bot', 'value' => $this->Ini->path_botoes . "/" . $this->arr_buttons['bcons_avanca']['image']);
                   }
               } 
           } 
           { 
               $nm_saida->saida("   document.getElementById('last_bot').disabled = true;\r\n");
               $nm_saida->saida("   document.getElementById('last_bot').className = \"scButton_" . $this->arr_buttons['bcons_final']['style'] . " disabled\";\r\n");
               if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
               {
                  $this->Ini->Arr_result['setDisabled'][] = array('field' => 'last_bot', 'value' => "true");
                  $this->Ini->Arr_result['setClass'][] = array('field' => 'last_bot', 'value' => "scButton_" . $this->arr_buttons['bcons_final']['style'] . ' disabled');
               }
               if ($this->arr_buttons['bcons_final']['display'] == 'only_img' || $this->arr_buttons['bcons_final']['display'] == 'text_img')
               { 
                   $nm_saida->saida("   document.getElementById('id_img_last_bot').src = \"" . $this->Ini->path_botoes . "/" . $this->arr_buttons['bcons_final']['image'] . "\";\r\n");
                   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
                   {
                       $this->Ini->Arr_result['setSrc'][] = array('field' => 'id_img_last_bot', 'value' => $this->Ini->path_botoes . "/" . $this->arr_buttons['bcons_final']['image']);
                   }
               } 
           } 
       } 
       elseif ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opcao'] != "pdf" && !isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['opc_liga']['nav']) && $_SESSION['scriptcase']['proc_mobile'])
       { 
           { 
               $nm_saida->saida("   document.getElementById('forward_bot').disabled = true;\r\n");
               $nm_saida->saida("   document.getElementById('forward_bot').className = \"scButton_" . $this->arr_buttons['bcons_avanca']['style'] . " disabled\";\r\n");
               if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
               {
                   $this->Ini->Arr_result['setDisabled'][] = array('field' => 'forward_bot', 'value' => "true");
                   $this->Ini->Arr_result['setClass'][] = array('field' => 'forward_bot', 'value' => "scButton_" . $this->arr_buttons['bcons_avanca']['style'] . ' disabled');
               }
               if ($this->arr_buttons['bcons_avanca']['display'] == 'only_img' || $this->arr_buttons['bcons_avanca']['display'] == 'text_img')
               { 
                   $nm_saida->saida("   document.getElementById('id_img_forward_bot').src = \"" . $this->Ini->path_botoes . "/" . $this->arr_buttons['bcons_avanca']['image'] . "\";\r\n");
                   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
                   {
                       $this->Ini->Arr_result['setSrc'][] = array('field' => 'id_img_forward_bot', 'value' => $this->Ini->path_botoes . "/" . $this->arr_buttons['bcons_avanca']['image']);
                   }
               } 
           } 
           { 
               $nm_saida->saida("   document.getElementById('last_bot').disabled = true;\r\n");
               $nm_saida->saida("   document.getElementById('last_bot').className = \"scButton_" . $this->arr_buttons['bcons_final']['style'] . " disabled\";\r\n");
               if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
               {
                  $this->Ini->Arr_result['setDisabled'][] = array('field' => 'last_bot', 'value' => "true");
                  $this->Ini->Arr_result['setClass'][] = array('field' => 'last_bot', 'value' => "scButton_" . $this->arr_buttons['bcons_final']['style'] . ' disabled');
               }
               if ($this->arr_buttons['bcons_final']['display'] == 'only_img' || $this->arr_buttons['bcons_final']['display'] == 'text_img')
               { 
                   $nm_saida->saida("   document.getElementById('id_img_last_bot').src = \"" . $this->Ini->path_botoes . "/" . $this->arr_buttons['bcons_final']['image'] . "\";\r\n");
                   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
                   {
                       $this->Ini->Arr_result['setSrc'][] = array('field' => 'id_img_last_bot', 'value' => $this->Ini->path_botoes . "/" . $this->arr_buttons['bcons_final']['image']);
                   }
               } 
           } 
       } 
       $nm_saida->saida("   nm_gp_fim = \"fim\";\r\n");
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
       {
           $this->Ini->Arr_result['setVar'][] = array('var' => 'nm_gp_fim', 'value' => "fim");
           $this->Ini->Arr_result['scrollEOF'] = true;
       }
   }
   else
   {
       $nm_saida->saida("   nm_gp_fim = \"\";\r\n");
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
       {
           $this->Ini->Arr_result['setVar'][] = array('var' => 'nm_gp_fim', 'value' => "");
       }
   }
   if (isset($this->redir_modal) && !empty($this->redir_modal))
   {
       echo $this->redir_modal;
   }
   $nm_saida->saida("   Tab_lig_apls    = new Array();\r\n");
   $nm_saida->saida("   Tab_lig_init    = new Array();\r\n");
   $nm_saida->saida("   Tab_lig_Type    = new Array();\r\n");
   $nm_saida->saida("   Tab_lig_lab     = new Array();\r\n");
   $nm_saida->saida("   Tab_lig_hint    = new Array();\r\n");
   $nm_saida->saida("   Tab_lig_img_on  = new Array();\r\n");
   $nm_saida->saida("   Tab_lig_img_off = new Array();\r\n");
   if (!empty($this->Ini->Init_apl_lig))
   {
       $ix = 0;
       foreach ($this->Ini->Init_apl_lig as $apls_name => $apls_parm)
       {
           $nm_saida->saida("   Tab_lig_apls[" . $ix . "] = '" . $apls_name . "';\r\n");
           $nm_saida->saida("   Tab_lig_init['" . $apls_name . "'] = '" . $apls_parm['ini'] . "';\r\n");
           $nm_saida->saida("   Tab_lig_Type['" . $apls_name . "'] = '" . $apls_parm['type'] . "';\r\n");
           $nm_saida->saida("   Tab_lig_lab['" . $apls_name . "'] = '" . $apls_parm['lab'] . "';\r\n");
           $nm_saida->saida("   Tab_lig_hint['" . $apls_name . "'] = '" . $apls_parm['hint'] . "';\r\n");
           $nm_saida->saida("   Tab_lig_img_on['" . $apls_name . "'] = '" . $apls_parm['img_on'] . "';\r\n");
           $nm_saida->saida("   Tab_lig_img_off['" . $apls_name . "'] = '" . $apls_parm['img_off'] . "';\r\n");
           $ix++;
       }
   }
   $nm_saida->saida("   </script>\r\n");
   if ($this->grid_emb_form || $this->grid_emb_form_full)
   {
       $nm_saida->saida("   <script type=\"text/javascript\">\r\n");
       $nm_saida->saida("      window.onload = function() {\r\n");
       $nm_saida->saida("         setTimeout(\"parent.scAjaxDetailHeight('grid_jdp_beneficiohogar_detalle', $(document).innerHeight())\",50);\r\n");
       $nm_saida->saida("      }\r\n");
       $nm_saida->saida("   </script>\r\n");
   }
   $nm_saida->saida("   </HTML>\r\n");
 }
//--- 
//--- 
 function form_navegacao()
 {
   global
   $nm_saida, $nm_url_saida;
   $str_pbfile = $this->Ini->root . $this->Ini->path_imag_temp . '/sc_pb_' . session_id() . '.tmp';
   $nm_saida->saida("   <form name=\"F3\" method=\"post\" \r\n");
   $nm_saida->saida("                     action=\"./\" \r\n");
   $nm_saida->saida("                     target=\"_self\" style=\"display: none\"> \r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"nmgp_chave\" value=\"\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"nmgp_opcao\" value=\"\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"nmgp_ordem\" value=\"\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"SC_lig_apl_orig\" value=\"grid_jdp_beneficiohogar_detalle\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"nmgp_parm_acum\" value=\"\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"nmgp_quant_linhas\" value=\"\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"nmgp_url_saida\" value=\"\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"nmgp_parms\" value=\"\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"nmgp_tipo_pdf\" value=\"\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"nmgp_outra_jan\" value=\"\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"nmgp_orig_pesq\" value=\"\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"SC_module_export\" value=\"\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"script_case_init\" value=\"" . NM_encode_input($this->Ini->sc_page) . "\"/> \r\n");
   $nm_saida->saida("   </form> \r\n");
   $nm_saida->saida("   <form name=\"F4\" method=\"post\" \r\n");
   $nm_saida->saida("                     action=\"./\" \r\n");
   $nm_saida->saida("                     target=\"_self\" style=\"display: none\"> \r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"nmgp_opcao\" value=\"rec\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"rec\" value=\"\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"nm_call_php\" value=\"\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"script_case_init\" value=\"" . NM_encode_input($this->Ini->sc_page) . "\"/> \r\n");
   $nm_saida->saida("   </form> \r\n");
   $nm_saida->saida("   <form name=\"F5\" method=\"post\" \r\n");
   $nm_saida->saida("                     action=\"grid_jdp_beneficiohogar_detalle_pesq.class.php\" \r\n");
   $nm_saida->saida("                     target=\"_self\" style=\"display: none\"> \r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"script_case_init\" value=\"" . NM_encode_input($this->Ini->sc_page) . "\"/> \r\n");
   $nm_saida->saida("   </form> \r\n");
   $nm_saida->saida("   <form name=\"F6\" method=\"post\" \r\n");
   $nm_saida->saida("                     action=\"./\" \r\n");
   $nm_saida->saida("                     target=\"_self\" style=\"display: none\"> \r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"script_case_init\" value=\"" . NM_encode_input($this->Ini->sc_page) . "\"/> \r\n");
   $nm_saida->saida("   </form> \r\n");
   $nm_saida->saida("   <form name=\"Fprint\" method=\"post\" \r\n");
   $nm_saida->saida("                     action=\"grid_jdp_beneficiohogar_detalle_iframe_prt.php\" \r\n");
   $nm_saida->saida("                     target=\"jan_print\" style=\"display: none\"> \r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"path_botoes\" value=\"" . $this->Ini->path_botoes . "\"/> \r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"opcao\" value=\"print\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"nmgp_opcao\" value=\"print\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"tp_print\" value=\"RC\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"cor_print\" value=\"CO\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"nmgp_opcao\" value=\"print\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"nmgp_tipo_print\" value=\"RC\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"nmgp_cor_print\" value=\"CO\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"SC_module_export\" value=\"\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"nmgp_password\" value=\"\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"script_case_init\" value=\"" . NM_encode_input($this->Ini->sc_page) . "\"/> \r\n");
   $nm_saida->saida("   </form> \r\n");
   $nm_saida->saida("   <form name=\"Fexport\" method=\"post\" \r\n");
   $nm_saida->saida("                     action=\"./\" \r\n");
   $nm_saida->saida("                     target=\"_self\" style=\"display: none\"> \r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"nmgp_opcao\" value=\"\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"nmgp_tp_xls\" value=\"\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"nmgp_tot_xls\" value=\"\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"SC_module_export\" value=\"\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"nm_delim_line\" value=\"\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"nm_delim_col\" value=\"\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"nm_delim_dados\" value=\"\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"nm_label_csv\" value=\"\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"nm_xml_tag\" value=\"\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"nm_xml_label\" value=\"\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"nm_json_format\" value=\"\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"nm_json_label\" value=\"\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"nmgp_password\" value=\"\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"script_case_init\" value=\"" . NM_encode_input($this->Ini->sc_page) . "\"/> \r\n");
   $nm_saida->saida("   </form> \r\n");
   $nm_saida->saida("  <form name=\"Fdoc_word\" method=\"post\" \r\n");
   $nm_saida->saida("        action=\"./\" \r\n");
   $nm_saida->saida("        target=\"_self\"> \r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"nmgp_opcao\" value=\"doc_word\"/> \r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"nmgp_cor_word\" value=\"CO\"/> \r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"SC_module_export\" value=\"\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"nmgp_password\" value=\"\"/>\r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"nmgp_navegator_print\" value=\"\"/> \r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"script_case_init\" value=\"" . NM_encode_input($this->Ini->sc_page) . "\"/> \r\n");
   $nm_saida->saida("  </form> \r\n");
   $nm_saida->saida("   <script type=\"text/javascript\">\r\n");
   $nm_saida->saida("    document.Fdoc_word.nmgp_navegator_print.value = navigator.appName;\r\n");
   $nm_saida->saida("   function nm_gp_word_conf(cor, SC_module_export, password, ajax, str_type, bol_param)\r\n");
   $nm_saida->saida("   {\r\n");
   $nm_saida->saida("       if (\"S\" == ajax)\r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           $('#TB_window').remove();\r\n");
   $nm_saida->saida("           $('body').append(\"<div id='TB_window'></div>\");\r\n");
   $nm_saida->saida("               nm_submit_modal(\"" . $this->Ini->path_link . "grid_jdp_beneficiohogar_detalle/grid_jdp_beneficiohogar_detalle_export_email.php?script_case_init={$this->Ini->sc_page}&path_img={$this->Ini->path_img_global}&path_btn={$this->Ini->path_botoes}&sType=\"+ str_type +\"&sAdd=__E__nmgp_cor_word=\" + cor + \"__E__SC_module_export=\" + SC_module_export + \"__E__nmgp_password=\" + password + \"&KeepThis=true&TB_iframe=true&modal=true\", bol_param);\r\n");
   $nm_saida->saida("       }\r\n");
   $nm_saida->saida("       else\r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           document.Fdoc_word.nmgp_cor_word.value = cor;\r\n");
   $nm_saida->saida("           document.Fdoc_word.nmgp_password.value = password;\r\n");
   $nm_saida->saida("           document.Fdoc_word.SC_module_export.value = SC_module_export;\r\n");
   $nm_saida->saida("           document.Fdoc_word.action = \"grid_jdp_beneficiohogar_detalle_export_ctrl.php\";\r\n");
   $nm_saida->saida("           document.Fdoc_word.submit();\r\n");
   $nm_saida->saida("       }\r\n");
   $nm_saida->saida("   }\r\n");
   $nm_saida->saida("   var obj_tr      = \"\";\r\n");
   $nm_saida->saida("   var css_tr      = \"\";\r\n");
   $nm_saida->saida("   var field_over  = " . $this->NM_field_over . ";\r\n");
   $nm_saida->saida("   var field_click = " . $this->NM_field_click . ";\r\n");
   $nm_saida->saida("   function over_tr(obj, class_obj)\r\n");
   $nm_saida->saida("   {\r\n");
   $nm_saida->saida("       if (field_over != 1)\r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           return;\r\n");
   $nm_saida->saida("       }\r\n");
   $nm_saida->saida("       if (obj_tr == obj)\r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           return;\r\n");
   $nm_saida->saida("       }\r\n");
   $nm_saida->saida("       obj.className = '" . $this->css_scGridFieldOver . "';\r\n");
   $nm_saida->saida("   }\r\n");
   $nm_saida->saida("   function out_tr(obj, class_obj)\r\n");
   $nm_saida->saida("   {\r\n");
   $nm_saida->saida("       if (field_over != 1)\r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           return;\r\n");
   $nm_saida->saida("       }\r\n");
   $nm_saida->saida("       if (obj_tr == obj)\r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           return;\r\n");
   $nm_saida->saida("       }\r\n");
   $nm_saida->saida("       obj.className = class_obj;\r\n");
   $nm_saida->saida("   }\r\n");
   $nm_saida->saida("   function click_tr(obj, class_obj)\r\n");
   $nm_saida->saida("   {\r\n");
   $nm_saida->saida("       if (field_click != 1)\r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           return;\r\n");
   $nm_saida->saida("       }\r\n");
   $nm_saida->saida("       if (obj_tr != \"\")\r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           obj_tr.className = css_tr;\r\n");
   $nm_saida->saida("       }\r\n");
   $nm_saida->saida("       css_tr        = class_obj;\r\n");
   $nm_saida->saida("       if (obj_tr == obj)\r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           obj_tr     = '';\r\n");
   $nm_saida->saida("           return;\r\n");
   $nm_saida->saida("       }\r\n");
   $nm_saida->saida("       obj_tr        = obj;\r\n");
   $nm_saida->saida("       css_tr        = class_obj;\r\n");
   $nm_saida->saida("       obj.className = '" . $this->css_scGridFieldClick . "';\r\n");
   $nm_saida->saida("   }\r\n");
   $nm_saida->saida("   var tem_hint;\r\n");
   $nm_saida->saida("   function nm_mostra_hint(nm_obj, nm_evt, nm_mens)\r\n");
   $nm_saida->saida("   {\r\n");
   $nm_saida->saida("       if (nm_mens == \"\")\r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           return;\r\n");
   $nm_saida->saida("       }\r\n");
   $nm_saida->saida("       tem_hint = true;\r\n");
   $nm_saida->saida("       if (document.layers)\r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           theString=\"<DIV CLASS='ttip'>\" + nm_mens + \"</DIV>\";\r\n");
   $nm_saida->saida("           document.tooltip.document.write(theString);\r\n");
   $nm_saida->saida("           document.tooltip.document.close();\r\n");
   $nm_saida->saida("           document.tooltip.left = nm_evt.pageX + 14;\r\n");
   $nm_saida->saida("           document.tooltip.top = nm_evt.pageY + 2;\r\n");
   $nm_saida->saida("           document.tooltip.visibility = \"show\";\r\n");
   $nm_saida->saida("       }\r\n");
   $nm_saida->saida("       else\r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           if(document.getElementById)\r\n");
   $nm_saida->saida("           {\r\n");
   $nm_saida->saida("              nmdg_nav = navigator.appName;\r\n");
   $nm_saida->saida("              elm = document.getElementById(\"tooltip\");\r\n");
   $nm_saida->saida("              elml = nm_obj;\r\n");
   $nm_saida->saida("              elm.innerHTML = nm_mens;\r\n");
   $nm_saida->saida("              if (nmdg_nav == \"Netscape\")\r\n");
   $nm_saida->saida("              {\r\n");
   $nm_saida->saida("                  elm.style.height = elml.style.height;\r\n");
   $nm_saida->saida("                  elm.style.top = nm_evt.pageY + 2 + 'px';\r\n");
   $nm_saida->saida("                  elm.style.left = nm_evt.pageX + 14 + 'px';\r\n");
   $nm_saida->saida("              }\r\n");
   $nm_saida->saida("              else\r\n");
   $nm_saida->saida("              {\r\n");
   $nm_saida->saida("                  elm.style.top = nm_evt.y + document.body.scrollTop + 10 + 'px';\r\n");
   $nm_saida->saida("                  elm.style.left = nm_evt.x + document.body.scrollLeft + 10 + 'px';\r\n");
   $nm_saida->saida("              }\r\n");
   $nm_saida->saida("              elm.style.visibility = \"visible\";\r\n");
   $nm_saida->saida("           }\r\n");
   $nm_saida->saida("       }\r\n");
   $nm_saida->saida("   }\r\n");
   $nm_saida->saida("   function nm_apaga_hint()\r\n");
   $nm_saida->saida("   {\r\n");
   $nm_saida->saida("       if (!tem_hint)\r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           return;\r\n");
   $nm_saida->saida("       }\r\n");
   $nm_saida->saida("       tem_hint = false;\r\n");
   $nm_saida->saida("       if (document.layers)\r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           document.tooltip.visibility = \"hidden\";\r\n");
   $nm_saida->saida("       }\r\n");
   $nm_saida->saida("       else\r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           if(document.getElementById)\r\n");
   $nm_saida->saida("           {\r\n");
   $nm_saida->saida("              elm.style.visibility = \"hidden\";\r\n");
   $nm_saida->saida("           }\r\n");
   $nm_saida->saida("       }\r\n");
   $nm_saida->saida("   }\r\n");
   if ($this->Rec_ini == 0)
   {
       $nm_saida->saida("   nm_gp_ini = \"ini\";\r\n");
   }
   else
   {
       $nm_saida->saida("   nm_gp_ini = \"\";\r\n");
   }
   $nm_saida->saida("   nm_gp_rec_ini = \"" . $this->Rec_ini . "\";\r\n");
   $nm_saida->saida("   nm_gp_rec_fim = \"" . $this->Rec_fim . "\";\r\n");
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['ajax_nav'])
   {
       if ($this->Rec_ini == 0)
       {
           $this->Ini->Arr_result['setVar'][] = array('var' => 'nm_gp_ini', 'value' => "ini");
       }
       else
       {
           $this->Ini->Arr_result['setVar'][] = array('var' => 'nm_gp_ini', 'value' => "");
       }
       $this->Ini->Arr_result['setVar'][] = array('var' => 'nm_gp_rec_ini', 'value' => $this->Rec_ini);
       $this->Ini->Arr_result['setVar'][] = array('var' => 'nm_gp_rec_fim', 'value' => $this->Rec_fim);
   }
   $nm_saida->saida("   function nm_gp_submit_rec(campo) \r\n");
   $nm_saida->saida("   { \r\n");
   $nm_saida->saida("      if (nm_gp_ini == \"ini\" && (campo == \"ini\" || campo == nm_gp_rec_ini)) \r\n");
   $nm_saida->saida("      { \r\n");
   $nm_saida->saida("          return; \r\n");
   $nm_saida->saida("      } \r\n");
   $nm_saida->saida("      if (nm_gp_fim == \"fim\" && (campo == \"fim\" || campo == nm_gp_rec_fim)) \r\n");
   $nm_saida->saida("      { \r\n");
   $nm_saida->saida("          return; \r\n");
   $nm_saida->saida("      } \r\n");
   $nm_saida->saida("      nm_gp_submit_ajax(\"rec\", campo); \r\n");
   $nm_saida->saida("   } \r\n");
   $nm_saida->saida("   function nm_gp_open_qsearch_div(pos)\r\n");
   $nm_saida->saida("   {\r\n");
   $nm_saida->saida("        if (typeof nm_gp_open_qsearch_div_mobile == 'function') {\r\n");
   $nm_saida->saida("            return nm_gp_open_qsearch_div_mobile(pos);\r\n");
   $nm_saida->saida("        }\r\n");
   $nm_saida->saida("        if($('#SC_fast_search_dropdown_' + pos).hasClass('fa-caret-down'))\r\n");
   $nm_saida->saida("        {\r\n");
   $nm_saida->saida("            if(($('#quicksearchph_' + pos).offset().top+$('#id_qs_div_' + pos).height()+10) >= $(document).height())\r\n");
   $nm_saida->saida("            {\r\n");
   $nm_saida->saida("                $('#id_qs_div_' + pos).offset({top:($('#quicksearchph_' + pos).offset().top-($('#quicksearchph_' + pos).height()/2)-$('#id_qs_div_' + pos).height()-4)});\r\n");
   $nm_saida->saida("            }\r\n");
   $nm_saida->saida("            nm_gp_open_qsearch_div_store_temp(pos);\r\n");
   $nm_saida->saida("            $('#SC_fast_search_dropdown_' + pos).removeClass('fa-caret-down').addClass('fa-caret-up');\r\n");
   $nm_saida->saida("        }\r\n");
   $nm_saida->saida("        else\r\n");
   $nm_saida->saida("        {\r\n");
   $nm_saida->saida("            $('#SC_fast_search_dropdown_' + pos).removeClass('fa-caret-up').addClass('fa-caret-down');\r\n");
   $nm_saida->saida("        }\r\n");
   $nm_saida->saida("        $('#id_qs_div_' + pos).toggle();\r\n");
   $nm_saida->saida("   }\r\n");
   $nm_saida->saida("   var tmp_qs_arr_fields = [], tmp_qs_arr_cond = \"\";\r\n");
   $nm_saida->saida("   function nm_gp_open_qsearch_div_store_temp(pos)\r\n");
   $nm_saida->saida("   {\r\n");
   $nm_saida->saida("        tmp_qs_arr_fields = [], tmp_qs_str_cond = \"\";\r\n");
   $nm_saida->saida("        if($('#fast_search_f0_' + pos).prop('type') == 'select-multiple')\r\n");
   $nm_saida->saida("        {\r\n");
   $nm_saida->saida("            tmp_qs_arr_fields = $('#fast_search_f0_' + pos).val();\r\n");
   $nm_saida->saida("        }\r\n");
   $nm_saida->saida("        else\r\n");
   $nm_saida->saida("        {\r\n");
   $nm_saida->saida("            tmp_qs_arr_fields.push($('#fast_search_f0_' + pos).val());\r\n");
   $nm_saida->saida("        }\r\n");
   $nm_saida->saida("        tmp_qs_str_cond = $('#cond_fast_search_f0_' + pos).val();\r\n");
   $nm_saida->saida("   }\r\n");
   $nm_saida->saida("   function nm_gp_cancel_qsearch_div_store_temp(pos)\r\n");
   $nm_saida->saida("   {\r\n");
   $nm_saida->saida("        $('#fast_search_f0_' + pos).val('');\r\n");
   $nm_saida->saida("        $(\"#fast_search_f0_\" + pos + \" option\").prop('selected', false);\r\n");
   $nm_saida->saida("        for(it=0; it<tmp_qs_arr_fields.length; it++)\r\n");
   $nm_saida->saida("        {\r\n");
   $nm_saida->saida("            $(\"#fast_search_f0_\" + pos + \" option[value='\"+ tmp_qs_arr_fields[it] +\"']\").prop('selected', true);\r\n");
   $nm_saida->saida("        }\r\n");
   $nm_saida->saida("        $(\"#fast_search_f0_\" + pos).change();\r\n");
   $nm_saida->saida("        tmp_qs_arr_fields = [];\r\n");
   $nm_saida->saida("        $('#cond_fast_search_f0_' + pos).val(tmp_qs_str_cond);\r\n");
   $nm_saida->saida("        $('#cond_fast_search_f0_' + pos).change();\r\n");
   $nm_saida->saida("        tmp_qs_str_cond = \"\";\r\n");
   $nm_saida->saida("        nm_gp_open_qsearch_div(pos);\r\n");
   $nm_saida->saida("   }\r\n");
   $nm_saida->saida("   function nm_gp_submit_qsearch(pos) \r\n");
   $nm_saida->saida("   { \r\n");
   $nm_saida->saida("       var out_qsearch = \"\";\r\n");
   $nm_saida->saida("       var ver_ch = eval('change_fast_' + pos);\r\n");
   $nm_saida->saida("       if (document.getElementById('SC_fast_search_' + pos).value == '' && ver_ch == '')\r\n");
   $nm_saida->saida("       { \r\n");
   $nm_saida->saida("           scJs_alert(\"" . $this->Ini->Nm_lang['lang_srch_req_field'] . "\");\r\n");
   $nm_saida->saida("           document.getElementById('SC_fast_search_' + pos).focus();\r\n");
   $nm_saida->saida("           return false;\r\n");
   $nm_saida->saida("       } \r\n");
   $nm_saida->saida("       if (document.getElementById('SC_fast_search_' + pos).value == '__Clear_Fast__')\r\n");
   $nm_saida->saida("       { \r\n");
   $nm_saida->saida("           document.getElementById('SC_fast_search_' + pos).value = '';\r\n");
   $nm_saida->saida("       } \r\n");
   $nm_saida->saida("       out_qsearch = $('#fast_search_f0_' + pos).val();\r\n");
   $nm_saida->saida("       out_qsearch += \"_SCQS_\" + $('#cond_fast_search_f0_' + pos).val();\r\n");
   $nm_saida->saida("       out_qsearch += \"_SCQS_\" + document.getElementById('SC_fast_search_' + pos).value;\r\n");
   $nm_saida->saida("       out_qsearch = out_qsearch.replace(/[+]/g, \"__NM_PLUS__\");\r\n");
   $nm_saida->saida("       out_qsearch = out_qsearch.replace(/[&]/g, \"__NM_AMP__\");\r\n");
   $nm_saida->saida("       out_qsearch = out_qsearch.replace(/[%]/g, \"__NM_PRC__\");\r\n");
   $nm_saida->saida("       ajax_navigate('fast_search', out_qsearch); \r\n");
   $nm_saida->saida("   } \r\n");
   $nm_saida->saida("   function nm_gp_submit_ajax(opc, parm) \r\n");
   $nm_saida->saida("   { \r\n");
   $nm_saida->saida("      return ajax_navigate(opc, parm); \r\n");
   $nm_saida->saida("   } \r\n");
   $nm_saida->saida("   function nm_gp_submit2(campo) \r\n");
   $nm_saida->saida("   { \r\n");
   $nm_saida->saida("      nm_gp_submit_ajax(\"ordem\", campo); \r\n");
   $nm_saida->saida("   } \r\n");
   $nm_saida->saida("   function nm_gp_submit3(parms, parm_acum, opc, ancor) \r\n");
   $nm_saida->saida("   { \r\n");
   $nm_saida->saida("      document.F3.target               = \"_self\"; \r\n");
   $nm_saida->saida("      document.F3.nmgp_parms.value     = parms ;\r\n");
   $nm_saida->saida("      document.F3.nmgp_parm_acum.value = parm_acum ;\r\n");
   $nm_saida->saida("      document.F3.nmgp_opcao.value     = opc ;\r\n");
   $nm_saida->saida("      document.F3.nmgp_url_saida.value = \"\";\r\n");
   $nm_saida->saida("      document.F3.action               = \"./\"  ;\r\n");
   $nm_saida->saida("      if (ancor != null) {\r\n");
   $nm_saida->saida("         ajax_save_ancor(\"F3\", ancor);\r\n");
   $nm_saida->saida("      } else {\r\n");
   $nm_saida->saida("          document.F3.submit() ;\r\n");
   $nm_saida->saida("      } \r\n");
   $nm_saida->saida("   } \r\n");
   $nm_saida->saida("   function nm_gp_submit4(apl_lig, apl_saida, parms, target, opc, apl_name, ancor) \r\n");
   $nm_saida->saida("   { \r\n");
   $nm_saida->saida("      var sob_iframe = '';\r\n");
   if ((isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['sc_modal']) && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['sc_modal']) || (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['dashboard_info']['under_dashboard']) && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['dashboard_info']['under_dashboard'])) {
       $nm_saida->saida("      sob_iframe += 'parent.';\r\n");
       $nm_saida->saida("      eval (\"var func_menu_aba = \" + sob_iframe + \"parent.createIframe\"); \r\n");
       $nm_saida->saida("      if (typeof func_menu_aba !== 'function') \r\n");
       $nm_saida->saida("      { \r\n");
       $nm_saida->saida("          sob_iframe += 'parent.';\r\n");
       $nm_saida->saida("      } \r\n");
   }
   $nm_saida->saida("      eval (\"var func_menu_aba = \" + sob_iframe + \"parent.createIframe\"); \r\n");
   $nm_saida->saida("      eval (\"var aba_atual = \" + sob_iframe + \"parent.Aba_atual\"); \r\n");
   $nm_saida->saida("      if (apl_name != null && apl_name != '' && typeof func_menu_aba === 'function') \r\n");
   $nm_saida->saida("      { \r\n");
   $nm_saida->saida("          for (i = 0; i < Tab_lig_apls.length; i++)\r\n");
   $nm_saida->saida("          {\r\n");
   $nm_saida->saida("              if (Tab_lig_apls[i] == apl_name)\r\n");
   $nm_saida->saida("              {\r\n");
   $nm_saida->saida("                  if (opc != null && opc != '') \r\n");
   $nm_saida->saida("                  {\r\n");
   $nm_saida->saida("                      opc = \"grid\";\r\n");
   $nm_saida->saida("                  }\r\n");
   $nm_saida->saida("                  else\r\n");
   $nm_saida->saida("                  {\r\n");
   $nm_saida->saida("                      opc = \"igual\";\r\n");
   $nm_saida->saida("                  }\r\n");
   $nm_saida->saida("                  parms = parms.replace(/\\?#\\?/g, \"*scin\"); \r\n");
   $nm_saida->saida("                  parms = parms.replace(/\\?@\\?/g, \"*scout\"); \r\n");
   $nm_saida->saida("                  apl_lig += '?nmgp_parms=' + parms + '&nm_run_menu=1&nmgp_opcao=' + opc + Tab_lig_init[apl_name];\r\n");
   $nm_saida->saida("                  apl_lig += '&Refresh_aba_menu=' + aba_atual;\r\n");
   $nm_saida->saida("                  func_menu_aba(apl_name, Tab_lig_lab[apl_name], Tab_lig_hint[apl_name], Tab_lig_img_on[apl_name], Tab_lig_img_off[apl_name], apl_lig, Tab_lig_Type[apl_name]);\r\n");
   $nm_saida->saida("                  return;\r\n");
   $nm_saida->saida("              }\r\n");
   $nm_saida->saida("          }\r\n");
   $nm_saida->saida("      }\r\n");
   $nm_saida->saida("      document.F3.target = target; \r\n");
   $nm_saida->saida("      if (\"dbifrm_widget\" == target.substr(0, 13)) {\r\n");
   $nm_saida->saida("          var targetIframe = $(parent.document).find(\"[name='\" + target + \"']\");\r\n");
   $nm_saida->saida("          apl_lig = parent.scIframeSCInit && parent.scIframeSCInit[target] ? addUrlParam(apl_lig, \"script_case_init\", parent.scIframeSCInit[target]) : apl_lig;\r\n");
   $nm_saida->saida("          targetIframe.attr(\"src\", apl_lig);\r\n");
   $nm_saida->saida("      }\r\n");
   $nm_saida->saida("      document.F3.action = apl_lig  ;\r\n");
   $nm_saida->saida("      if (opc == 'igual' || opc == 'novo') \r\n");
   $nm_saida->saida("      {\r\n");
   $nm_saida->saida("          document.F3.nmgp_opcao.value = opc;\r\n");
   $nm_saida->saida("      }\r\n");
   $nm_saida->saida("      else\r\n");
   $nm_saida->saida("      if (opc != null && opc != '') \r\n");
   $nm_saida->saida("      {\r\n");
   $nm_saida->saida("          document.F3.nmgp_opcao.value = \"grid\" ;\r\n");
   $nm_saida->saida("      }\r\n");
   $nm_saida->saida("      else\r\n");
   $nm_saida->saida("      {\r\n");
   $nm_saida->saida("          document.F3.nmgp_opcao.value = \"igual\" ;\r\n");
   $nm_saida->saida("      }\r\n");
   $nm_saida->saida("      document.F3.nmgp_url_saida.value   = apl_saida ;\r\n");
   $nm_saida->saida("      document.F3.nmgp_parms.value       = parms ;\r\n");
   $nm_saida->saida("      if (target == '_blank') \r\n");
   $nm_saida->saida("      {\r\n");
   $nm_saida->saida("          NM_ancor_ult_lig = ancor;\r\n");
   $nm_saida->saida("          document.F3.nmgp_outra_jan.value = \"true\" ;\r\n");
   $nm_saida->saida("          window.open('','jan_sc','location=no,menubar=no,resizable,scrollbars,status=no,toolbar=no');\r\n");
   $nm_saida->saida("          document.F3.target = \"jan_sc\"; \r\n");
   $nm_saida->saida("      }\r\n");
   $nm_saida->saida("      if (ancor != null && target == '_self') {\r\n");
   $nm_saida->saida("         ajax_save_ancor(\"F3\", ancor);\r\n");
   $nm_saida->saida("      } else {\r\n");
   $nm_saida->saida("          document.F3.submit() ;\r\n");
   $nm_saida->saida("      } \r\n");
   $nm_saida->saida("   } \r\n");
   $nm_saida->saida("   function nm_gp_submit5(apl_lig, apl_saida, parms, target, opc, modal_h, modal_w, m_confirm, apl_name, ancor) \r\n");
   $nm_saida->saida("   { \r\n");
   $nm_saida->saida("      parms = parms.replace(/@percent@/g, \"%\"); \r\n");
   $nm_saida->saida("      if (m_confirm != null && m_confirm != '') \r\n");
   $nm_saida->saida("      { \r\n");
   $nm_saida->saida("          if (confirm(m_confirm))\r\n");
   $nm_saida->saida("          { }\r\n");
   $nm_saida->saida("          else\r\n");
   $nm_saida->saida("          {\r\n");
   $nm_saida->saida("             return;\r\n");
   $nm_saida->saida("          }\r\n");
   $nm_saida->saida("      }\r\n");
   $nm_saida->saida("      var sob_iframe = '';\r\n");
   if ((isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['sc_modal']) && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['sc_modal']) || (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['dashboard_info']['under_dashboard']) && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['dashboard_info']['under_dashboard'])) {
       $nm_saida->saida("      sob_iframe += 'parent.';\r\n");
       $nm_saida->saida("      eval (\"var func_menu_aba = \" + sob_iframe + \"parent.createIframe\"); \r\n");
       $nm_saida->saida("      if (typeof func_menu_aba !== 'function') \r\n");
       $nm_saida->saida("      { \r\n");
       $nm_saida->saida("          sob_iframe += 'parent.';\r\n");
       $nm_saida->saida("      } \r\n");
   }
   $nm_saida->saida("      eval (\"var func_menu_aba = \" + sob_iframe + \"parent.createIframe\"); \r\n");
   $nm_saida->saida("      if (apl_name != null && apl_name != '' && typeof func_menu_aba === 'function') \r\n");
   $nm_saida->saida("      { \r\n");
   $nm_saida->saida("          for (i = 0; i < Tab_lig_apls.length; i++)\r\n");
   $nm_saida->saida("          {\r\n");
   $nm_saida->saida("              if (Tab_lig_apls[i] == apl_name)\r\n");
   $nm_saida->saida("              {\r\n");
   $nm_saida->saida("                  parms = parms.replace(/\\?#\\?/g, \"*scin\"); \r\n");
   $nm_saida->saida("                  parms = parms.replace(/\\?@\\?/g, \"*scout\"); \r\n");
   $nm_saida->saida("                  apl_lig += '?nmgp_parms=' + parms + '&nm_run_menu=1&nmgp_opcao=' + opc + Tab_lig_init[apl_name];\r\n");
   $nm_saida->saida("                  func_menu_aba(apl_name, Tab_lig_lab[apl_name], Tab_lig_hint[apl_name], Tab_lig_img_on[apl_name], Tab_lig_img_off[apl_name], apl_lig, Tab_lig_Type[apl_name]);\r\n");
   $nm_saida->saida("                  return;\r\n");
   $nm_saida->saida("              }\r\n");
   $nm_saida->saida("          }\r\n");
   $nm_saida->saida("      }\r\n");
   $nm_saida->saida("      if (apl_lig.substr(0, 7) == \"http://\" || apl_lig.substr(0, 8) == \"https://\")\r\n");
   $nm_saida->saida("      {\r\n");
   $nm_saida->saida("          if (target == '_blank') \r\n");
   $nm_saida->saida("          {\r\n");
   $nm_saida->saida("              window.open (apl_lig);\r\n");
   $nm_saida->saida("          }\r\n");
   $nm_saida->saida("          else\r\n");
   $nm_saida->saida("          {\r\n");
   $nm_saida->saida("              window.location = apl_lig;\r\n");
   $nm_saida->saida("          }\r\n");
   $nm_saida->saida("          return;\r\n");
   $nm_saida->saida("      }\r\n");
   $nm_saida->saida("      if (target == 'modal' || target == 'modal_rpdf') \r\n");
   $nm_saida->saida("      {\r\n");
   $nm_saida->saida("          NM_ancor_ult_lig = ancor;\r\n");
   $nm_saida->saida("          par_modal = '?&nmgp_outra_jan=true&nmgp_url_saida=modal&SC_lig_apl_orig=grid_jdp_beneficiohogar_detalle';\r\n");
   $nm_saida->saida("          if (opc != null && opc != '') \r\n");
   $nm_saida->saida("          {\r\n");
   $nm_saida->saida("              par_modal += '&nmgp_opcao=grid';\r\n");
   $nm_saida->saida("          }\r\n");
   $nm_saida->saida("          if (parms != null && parms != '') \r\n");
   $nm_saida->saida("          {\r\n");
   $nm_saida->saida("              par_modal += '&nmgp_parms=' + parms;\r\n");
   $nm_saida->saida("          }\r\n");
   $Sc_parent = "";
   if ($this->grid_emb_form || $this->grid_emb_form_full)
   {
       $Sc_parent = "parent.";
   }
   $nm_saida->saida("          if (target == 'modal') \r\n");
   $nm_saida->saida("          {\r\n");
   $nm_saida->saida("               " . $Sc_parent . "tb_show('', apl_lig + par_modal + '&TB_iframe=true&modal=true&height=' + modal_h + '&width=' + modal_w, '');\r\n");
   $nm_saida->saida("          }\r\n");
   $nm_saida->saida("          else \r\n");
   $nm_saida->saida("          {\r\n");
   $nm_saida->saida("               " . $Sc_parent . "tb_show('', apl_lig + par_modal + '&TB_iframe=true&height=' + modal_h + '&width=' + modal_w, '');\r\n");
   $nm_saida->saida("          }\r\n");
   $nm_saida->saida("          return;\r\n");
   $nm_saida->saida("      }\r\n");
   $nm_saida->saida("      document.F3.target = target; \r\n");
   $nm_saida->saida("      if (target == '_blank') \r\n");
   $nm_saida->saida("      {\r\n");
   $nm_saida->saida("          NM_ancor_ult_lig = ancor;\r\n");
   $nm_saida->saida("          document.F3.nmgp_outra_jan.value = \"true\" ;\r\n");
   $nm_saida->saida("          window.open('','jan_sc','location=no,menubar=no,resizable,scrollbars,status=no,toolbar=no');\r\n");
   $nm_saida->saida("          document.F3.target = \"jan_sc\"; \r\n");
   $nm_saida->saida("      }\r\n");
   $nm_saida->saida("      if (\"dbifrm_widget\" == target.substr(0, 13)) {\r\n");
   $nm_saida->saida("          var targetIframe = $(parent.document).find(\"[name='\" + target + \"']\");\r\n");
   $nm_saida->saida("          apl_lig = parent.scIframeSCInit && parent.scIframeSCInit[target] ? addUrlParam(apl_lig, \"script_case_init\", parent.scIframeSCInit[target]) : apl_lig;\r\n");
   $nm_saida->saida("          targetIframe.attr(\"src\", apl_lig);\r\n");
   $nm_saida->saida("      }\r\n");
   $nm_saida->saida("      document.F3.action = apl_lig;\r\n");
   $nm_saida->saida("      if (opc != null && opc != '') \r\n");
   $nm_saida->saida("      {\r\n");
   $nm_saida->saida("          document.F3.nmgp_opcao.value = \"grid\" ;\r\n");
   $nm_saida->saida("      }\r\n");
   $nm_saida->saida("      else\r\n");
   $nm_saida->saida("      {\r\n");
   $nm_saida->saida("          document.F3.nmgp_opcao.value = \"\" ;\r\n");
   $nm_saida->saida("      }\r\n");
   $nm_saida->saida("      document.F3.nmgp_url_saida.value = apl_saida ;\r\n");
   $nm_saida->saida("      document.F3.nmgp_parms.value     = parms ;\r\n");
   $nm_saida->saida("      if (ancor != null && target == '_self') {\r\n");
   $nm_saida->saida("         ajax_save_ancor(\"F3\", ancor);\r\n");
   $nm_saida->saida("      } else {\r\n");
   $nm_saida->saida("          document.F3.submit() ;\r\n");
   $nm_saida->saida("      } \r\n");
   $nm_saida->saida("      document.F3.nmgp_outra_jan.value   = \"\" ;\r\n");
   $nm_saida->saida("   } \r\n");
   $nm_saida->saida("   function addUrlParam(sUrl, sParam, sValue) {\r\n");
   $nm_saida->saida("           var baseUrl, urlParams = [], objParams = {}, tmp, i;\r\n");
   $nm_saida->saida("           tmp = sUrl.split(\"?\");\r\n");
   $nm_saida->saida("           baseUrl = tmp[0];\r\n");
   $nm_saida->saida("           if (tmp[1]) {\r\n");
   $nm_saida->saida("                   urlParams = tmp[1].split(\"&\");\r\n");
   $nm_saida->saida("           }\r\n");
   $nm_saida->saida("           for (i = 0; i < urlParams.length; i++) {\r\n");
   $nm_saida->saida("                   tmp = urlParams[i].split(\"=\");\r\n");
   $nm_saida->saida("                   objParams[ tmp[0] ] = tmp[1] ? tmp[1] : \"\";\r\n");
   $nm_saida->saida("           }\r\n");
   $nm_saida->saida("           objParams[sParam] = sValue;\r\n");
   $nm_saida->saida("           urlParams = [];\r\n");
   $nm_saida->saida("           for (tmp in objParams) {\r\n");
   $nm_saida->saida("                   urlParams.push(tmp + \"=\" + objParams[tmp]);\r\n");
   $nm_saida->saida("           }\r\n");
   $nm_saida->saida("           return baseUrl + \"?\" + urlParams.join(\"&\");\r\n");
   $nm_saida->saida("   }\r\n");
   $nm_saida->saida("   function nm_gp_submit6(apl_lig, apl_saida, parms, target, pos, alt, larg, opc, modal_h, modal_w, m_confirm, apl_name, ancor) \r\n");
   $nm_saida->saida("   { \r\n");
   $nm_saida->saida("      if (apl_lig.substr(0, 7) == \"http://\" || apl_lig.substr(0, 8) == \"https://\")\r\n");
   $nm_saida->saida("      {\r\n");
   $nm_saida->saida("          if (target == '_blank') \r\n");
   $nm_saida->saida("          {\r\n");
   $nm_saida->saida("              window.open (apl_lig);\r\n");
   $nm_saida->saida("          }\r\n");
   $nm_saida->saida("          else\r\n");
   $nm_saida->saida("          {\r\n");
   $nm_saida->saida("              window.location = apl_lig;\r\n");
   $nm_saida->saida("          }\r\n");
   $nm_saida->saida("          return;\r\n");
   $nm_saida->saida("      }\r\n");
   $nm_saida->saida("      if (pos == \"A\") {obj = document.getElementById('nmsc_iframe_liga_A_grid_jdp_beneficiohogar_detalle');} \r\n");
   $nm_saida->saida("      if (pos == \"B\") {obj = document.getElementById('nmsc_iframe_liga_B_grid_jdp_beneficiohogar_detalle');} \r\n");
   $nm_saida->saida("      if (pos == \"E\") {obj = document.getElementById('nmsc_iframe_liga_E_grid_jdp_beneficiohogar_detalle');} \r\n");
   $nm_saida->saida("      if (pos == \"D\") {obj = document.getElementById('nmsc_iframe_liga_D_grid_jdp_beneficiohogar_detalle');} \r\n");
   $nm_saida->saida("      obj.style.height = (alt == parseInt(alt)) ? alt + 'px' : alt;\r\n");
   $nm_saida->saida("      obj.style.width  = (larg == parseInt(larg)) ? larg + 'px' : larg;\r\n");
   $nm_saida->saida("      document.F3.target = target; \r\n");
   $nm_saida->saida("      document.F3.action = apl_lig  ;\r\n");
   $nm_saida->saida("      if (opc != null && opc != '') \r\n");
   $nm_saida->saida("      {\r\n");
   $nm_saida->saida("          document.F3.nmgp_opcao.value = \"grid\" ;\r\n");
   $nm_saida->saida("      }\r\n");
   $nm_saida->saida("      else\r\n");
   $nm_saida->saida("      {\r\n");
   $nm_saida->saida("          document.F3.nmgp_opcao.value = \"\" ;\r\n");
   $nm_saida->saida("      }\r\n");
   $nm_saida->saida("      document.F3.nmgp_url_saida.value = apl_saida ;\r\n");
   $nm_saida->saida("      document.F3.nmgp_parms.value     = parms ;\r\n");
   $nm_saida->saida("      if (ancor != null && target == '_self') {\r\n");
   $nm_saida->saida("         ajax_save_ancor(\"F3\", ancor);\r\n");
   $nm_saida->saida("      } else {\r\n");
   $nm_saida->saida("          document.F3.submit() ;\r\n");
   $nm_saida->saida("      } \r\n");
   $nm_saida->saida("   } \r\n");
   $nm_saida->saida("   function nm_open_export(arq_export) \r\n");
   $nm_saida->saida("   { \r\n");
   $nm_saida->saida("      window.location = arq_export;\r\n");
   $nm_saida->saida("   } \r\n");
   $nm_saida->saida("   function nm_submit_modal(parms, t_parent) \r\n");
   $nm_saida->saida("   { \r\n");
   $nm_saida->saida("      if (t_parent == 'S' && typeof parent.tb_show == 'function')\r\n");
   $nm_saida->saida("      { \r\n");
   $nm_saida->saida("           parent.tb_show('', parms, '');\r\n");
   $nm_saida->saida("      } \r\n");
   $nm_saida->saida("      else\r\n");
   $nm_saida->saida("      { \r\n");
   $nm_saida->saida("         tb_show('', parms, '');\r\n");
   $nm_saida->saida("      } \r\n");
   $nm_saida->saida("   } \r\n");
   $nm_saida->saida("   function nm_move(tipo) \r\n");
   $nm_saida->saida("   { \r\n");
   $nm_saida->saida("      document.F6.target = \"_self\"; \r\n");
   $nm_saida->saida("      document.F6.submit() ;\r\n");
   $nm_saida->saida("      return;\r\n");
   $nm_saida->saida("   } \r\n");
   $nm_saida->saida("   function nm_gp_move(x, y, z, p, g, crt, ajax, chart_level, page_break_pdf, SC_module_export, use_pass_pdf, pdf_all_cab, pdf_all_label, pdf_label_group, pdf_zip) \r\n");
   $nm_saida->saida("   { \r\n");
   $nm_saida->saida("       document.F3.action           = \"./\"  ;\r\n");
   $nm_saida->saida("       document.F3.nmgp_parms.value = \"SC_null\" ;\r\n");
   $nm_saida->saida("       document.F3.nmgp_orig_pesq.value = \"\" ;\r\n");
   $nm_saida->saida("       document.F3.nmgp_url_saida.value = \"\" ;\r\n");
   $nm_saida->saida("       document.F3.nmgp_opcao.value = x; \r\n");
   $nm_saida->saida("       document.F3.nmgp_outra_jan.value = \"\" ;\r\n");
   $nm_saida->saida("       document.F3.target = \"_self\"; \r\n");
   $nm_saida->saida("       if (y == 1) \r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           document.F3.target = \"_blank\"; \r\n");
   $nm_saida->saida("       }\r\n");
   $nm_saida->saida("       if (\"busca\" == x)\r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           document.F3.nmgp_orig_pesq.value = z; \r\n");
   $nm_saida->saida("           z = '';\r\n");
   $nm_saida->saida("       }\r\n");
   $nm_saida->saida("       if (z != null && z != '') \r\n");
   $nm_saida->saida("       { \r\n");
   $nm_saida->saida("           document.F3.nmgp_tipo_pdf.value = z; \r\n");
   $nm_saida->saida("       } \r\n");
   $nm_saida->saida("       if (\"xls\" == x)\r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           document.F3.SC_module_export.value = z;\r\n");
   if (!extension_loaded("zip"))
   {
       $nm_saida->saida("           alert (\"" . html_entity_decode($this->Ini->Nm_lang['lang_othr_prod_xtzp'], ENT_COMPAT, $_SESSION['scriptcase']['charset']) . "\");\r\n");
       $nm_saida->saida("           return false;\r\n");
   } 
   $nm_saida->saida("       }\r\n");
   $nm_saida->saida("       if (\"xml\" == x)\r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           document.F3.SC_module_export.value = z;\r\n");
   $nm_saida->saida("       }\r\n");
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['grid_jdp_beneficiohogar_detalle_iframe_params'] = array(
       'str_tmp'          => $this->Ini->path_imag_temp,
       'str_prod'         => $this->Ini->path_prod,
       'str_btn'          => $this->Ini->Str_btn_css,
       'str_lang'         => $this->Ini->str_lang,
       'str_schema'       => $this->Ini->str_schema_all,
       'str_google_fonts' => $this->Ini->str_google_fonts,
   );
   $prep_parm_pdf = "scsess?#?" . session_id() . "?@?str_tmp?#?" . $this->Ini->path_imag_temp . "?@?str_prod?#?" . $this->Ini->path_prod . "?@?str_btn?#?" . $this->Ini->Str_btn_css . "?@?str_lang?#?" . $this->Ini->str_lang . "?@?str_schema?#?"  . $this->Ini->str_schema_all . "?@?script_case_init?#?" . $this->Ini->sc_page . "?@?jspath?#?" . $this->Ini->path_js . "?#?";
   $Md5_pdf    = "@SC_par@" . NM_encode_input($this->Ini->sc_page) . "@SC_par@grid_jdp_beneficiohogar_detalle@SC_par@" . md5($prep_parm_pdf);
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['Md5_pdf'][md5($prep_parm_pdf)] = $prep_parm_pdf;
   $nm_saida->saida("       if (\"pdf\" == x)\r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           if (\"S\" == ajax)\r\n");
   $nm_saida->saida("           {\r\n");
   $nm_saida->saida("               $('#TB_window').remove();\r\n");
   $nm_saida->saida("               $('body').append(\"<div id='TB_window'></div>\");\r\n");
   $nm_saida->saida("               nm_submit_modal(\"" . $this->Ini->path_link . "grid_jdp_beneficiohogar_detalle/grid_jdp_beneficiohogar_detalle_export_email.php?script_case_init={$this->Ini->sc_page}&path_img={$this->Ini->path_img_global}&path_btn={$this->Ini->path_botoes}&sType=pdf&sAdd=__E__nmgp_tipo_pdf=\" + z + \"__E__sc_parms_pdf=\" + p + \"__E__sc_create_charts=\" + crt + \"__E__sc_graf_pdf=\" + g + \"__E__chart_level=\" + chart_level + \"__E__page_break_pdf=\" + page_break_pdf + \"__E__SC_module_export=\" + SC_module_export + \"__E__use_pass_pdf=\" + use_pass_pdf + \"__E__pdf_all_cab=\" + pdf_all_cab + \"__E__pdf_all_label=\" +  pdf_all_label + \"__E__pdf_label_group=\" +  pdf_label_group + \"__E__pdf_zip=\" +  pdf_zip + \"&nm_opc=pdf&KeepThis=true&TB_iframe=true&modal=true\", '');\r\n");
   $nm_saida->saida("           }\r\n");
   $nm_saida->saida("           else\r\n");
   $nm_saida->saida("           {\r\n");
   $nm_saida->saida("               window.location = \"" . $this->Ini->path_link . "grid_jdp_beneficiohogar_detalle/grid_jdp_beneficiohogar_detalle_iframe.php?nmgp_parms=" . $Md5_pdf . "&sc_tp_pdf=\" + z + \"&sc_parms_pdf=\" + p + \"&sc_create_charts=\" + crt + \"&sc_graf_pdf=\" + g + '&chart_level=' + chart_level + '&page_break_pdf=' + page_break_pdf + '&SC_module_export=' + SC_module_export + '&use_pass_pdf=' + use_pass_pdf + '&pdf_all_cab=' + pdf_all_cab + '&pdf_all_label=' +  pdf_all_label + '&pdf_label_group=' +  pdf_label_group + '&pdf_zip=' +  pdf_zip;\r\n");
   $nm_saida->saida("           }\r\n");
   $nm_saida->saida("       }\r\n");
   $nm_saida->saida("       else\r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           if ((x == 'igual' || x == 'edit') && NM_ancor_ult_lig != \"\")\r\n");
   $nm_saida->saida("           {\r\n");
   $nm_saida->saida("                ajax_save_ancor(\"F3\", NM_ancor_ult_lig);\r\n");
   $nm_saida->saida("                NM_ancor_ult_lig = \"\";\r\n");
   $nm_saida->saida("            } else {\r\n");
   $nm_saida->saida("                document.F3.submit() ;\r\n");
   $nm_saida->saida("            } \r\n");
   $nm_saida->saida("       }\r\n");
   $nm_saida->saida("   } \r\n");
   $nm_saida->saida("   function nm_gp_print_conf(tp, cor, SC_module_export, password, ajax, str_type, bol_param)\r\n");
   $nm_saida->saida("   {\r\n");
   $nm_saida->saida("       if (\"S\" == ajax)\r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           $('#TB_window').remove();\r\n");
   $nm_saida->saida("           $('body').append(\"<div id='TB_window'></div>\");\r\n");
   $nm_saida->saida("               nm_submit_modal(\"" . $this->Ini->path_link . "grid_jdp_beneficiohogar_detalle/grid_jdp_beneficiohogar_detalle_export_email.php?script_case_init={$this->Ini->sc_page}&path_img={$this->Ini->path_img_global}&path_btn={$this->Ini->path_botoes}&sType=\"+ str_type +\"&sAdd=__E__nmgp_tipo_print=\" + tp + \"__E__cor_print=\" + cor + \"__E__SC_module_export=\" + SC_module_export + \"__E__nmgp_password=\" + password + \"&KeepThis=true&TB_iframe=true&modal=true\", bol_param);\r\n");
   $nm_saida->saida("       }\r\n");
   $nm_saida->saida("       else\r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           document.Fprint.tp_print.value = tp;\r\n");
   $nm_saida->saida("           document.Fprint.cor_print.value = cor;\r\n");
   $nm_saida->saida("           document.Fprint.nmgp_tipo_print.value = tp;\r\n");
   $nm_saida->saida("           document.Fprint.nmgp_cor_print.value = cor;\r\n");
   $nm_saida->saida("           document.Fprint.SC_module_export.value = SC_module_export;\r\n");
   $nm_saida->saida("           document.Fprint.nmgp_password.value = password;\r\n");
   $nm_saida->saida("           if (password != \"\")\r\n");
   $nm_saida->saida("           {\r\n");
   $nm_saida->saida("               document.Fprint.target = '_self';\r\n");
   $nm_saida->saida("               document.Fprint.action = \"grid_jdp_beneficiohogar_detalle_export_ctrl.php\";\r\n");
   $nm_saida->saida("           }\r\n");
   $nm_saida->saida("           else\r\n");
   $nm_saida->saida("           {\r\n");
   $nm_saida->saida("               window.open('','jan_print','location=no,menubar=no,resizable,scrollbars,status=no,toolbar=no');\r\n");
   $nm_saida->saida("           }\r\n");
   $nm_saida->saida("           document.Fprint.submit() ;\r\n");
   $nm_saida->saida("       }\r\n");
   $nm_saida->saida("   }\r\n");
   $nm_saida->saida("   function nm_gp_xls_conf(tp_xls, SC_module_export, password, tot_xls, ajax, str_type, bol_param)\r\n");
   $nm_saida->saida("   {\r\n");
   $nm_saida->saida("       if (\"S\" == ajax)\r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           $('#TB_window').remove();\r\n");
   $nm_saida->saida("           $('body').append(\"<div id='TB_window'></div>\");\r\n");
   $nm_saida->saida("               nm_submit_modal(\"" . $this->Ini->path_link . "grid_jdp_beneficiohogar_detalle/grid_jdp_beneficiohogar_detalle_export_email.php?script_case_init={$this->Ini->sc_page}&path_img={$this->Ini->path_img_global}&path_btn={$this->Ini->path_botoes}&sType=\" + str_type +\"&sAdd=__E__SC_module_export=\" + SC_module_export + \"__E__nmgp_tp_xls=\" + tp_xls + \"__E__nmgp_tot_xls=\" + tot_xls + \"__E__nmgp_password=\" + password + \"&KeepThis=true&TB_iframe=true&modal=true\", bol_param);\r\n");
   $nm_saida->saida("       }\r\n");
   $nm_saida->saida("       else\r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           document.Fexport.nmgp_opcao.value = \"xls\";\r\n");
   $nm_saida->saida("           document.Fexport.nmgp_tp_xls.value = tp_xls;\r\n");
   $nm_saida->saida("           document.Fexport.nmgp_tot_xls.value = tot_xls;\r\n");
   $nm_saida->saida("           document.Fexport.nmgp_password.value = password;\r\n");
   $nm_saida->saida("           document.Fexport.SC_module_export.value = SC_module_export;\r\n");
   $nm_saida->saida("           document.Fexport.action = \"grid_jdp_beneficiohogar_detalle_export_ctrl.php\";\r\n");
   $nm_saida->saida("           document.Fexport.submit() ;\r\n");
   $nm_saida->saida("       }\r\n");
   $nm_saida->saida("   }\r\n");
   $nm_saida->saida("   function nm_gp_csv_conf(delim_line, delim_col, delim_dados, label_csv, SC_module_export, password, ajax, str_type, bol_param)\r\n");
   $nm_saida->saida("   {\r\n");
   $nm_saida->saida("       if (\"S\" == ajax)\r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           $('#TB_window').remove();\r\n");
   $nm_saida->saida("           $('body').append(\"<div id='TB_window'></div>\");\r\n");
   $nm_saida->saida("               nm_submit_modal(\"" . $this->Ini->path_link . "grid_jdp_beneficiohogar_detalle/grid_jdp_beneficiohogar_detalle_export_email.php?script_case_init={$this->Ini->sc_page}&path_img={$this->Ini->path_img_global}&path_btn={$this->Ini->path_botoes}&sType=\" + str_type +\"&sAdd=__E__nm_delim_line=\" + delim_line + \"__E__nm_delim_col=\" + delim_col + \"__E__nm_delim_dados=\" + delim_dados + \"__E__nm_label_csv=\" + label_csv + \"&KeepThis=true&TB_iframe=true&modal=true\", bol_param);\r\n");
   $nm_saida->saida("       }\r\n");
   $nm_saida->saida("       else\r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           document.Fexport.nmgp_opcao.value = \"csv\";\r\n");
   $nm_saida->saida("           document.Fexport.nm_delim_line.value = delim_line;\r\n");
   $nm_saida->saida("           document.Fexport.nm_delim_col.value = delim_col;\r\n");
   $nm_saida->saida("           document.Fexport.nm_delim_dados.value = delim_dados;\r\n");
   $nm_saida->saida("           document.Fexport.nm_label_csv.value = label_csv;\r\n");
   $nm_saida->saida("           document.Fexport.nmgp_password.value = password;\r\n");
   $nm_saida->saida("           document.Fexport.SC_module_export.value = SC_module_export;\r\n");
   $nm_saida->saida("           document.Fexport.action = \"grid_jdp_beneficiohogar_detalle_export_ctrl.php\";\r\n");
   $nm_saida->saida("           document.Fexport.submit() ;\r\n");
   $nm_saida->saida("       }\r\n");
   $nm_saida->saida("   }\r\n");
   $nm_saida->saida("   function nm_gp_xml_conf(xml_tag, xml_label, SC_module_export, password, ajax, str_type, bol_param)\r\n");
   $nm_saida->saida("   {\r\n");
   $nm_saida->saida("       if (\"S\" == ajax)\r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           $('#TB_window').remove();\r\n");
   $nm_saida->saida("           $('body').append(\"<div id='TB_window'></div>\");\r\n");
   $nm_saida->saida("               nm_submit_modal(\"" . $this->Ini->path_link . "grid_jdp_beneficiohogar_detalle/grid_jdp_beneficiohogar_detalle_export_email.php?script_case_init={$this->Ini->sc_page}&path_img={$this->Ini->path_img_global}&path_btn={$this->Ini->path_botoes}&sType=\" + str_type +\"&sAdd=__E__nm_xml_tag=\" + xml_tag + \"__E__nm_xml_label=\" + xml_label + \"&KeepThis=true&TB_iframe=true&modal=true\", bol_param);\r\n");
   $nm_saida->saida("       }\r\n");
   $nm_saida->saida("       else\r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           document.Fexport.nmgp_opcao.value   = \"xml\";\r\n");
   $nm_saida->saida("           document.Fexport.nm_xml_tag.value   = xml_tag;\r\n");
   $nm_saida->saida("           document.Fexport.nm_xml_label.value = xml_label;\r\n");
   $nm_saida->saida("           document.Fexport.nmgp_password.value = password;\r\n");
   $nm_saida->saida("           document.Fexport.SC_module_export.value = SC_module_export;\r\n");
   $nm_saida->saida("           document.Fexport.action = \"grid_jdp_beneficiohogar_detalle_export_ctrl.php\";\r\n");
   $nm_saida->saida("           document.Fexport.submit() ;\r\n");
   $nm_saida->saida("       }\r\n");
   $nm_saida->saida("   }\r\n");
   $nm_saida->saida("   function nm_gp_json_conf(json_format, json_label, SC_module_export, password, ajax, str_type, bol_param)\r\n");
   $nm_saida->saida("   {\r\n");
   $nm_saida->saida("       if (\"S\" == ajax)\r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           $('#TB_window').remove();\r\n");
   $nm_saida->saida("           $('body').append(\"<div id='TB_window'></div>\");\r\n");
   $nm_saida->saida("               nm_submit_modal(\"" . $this->Ini->path_link . "grid_jdp_beneficiohogar_detalle/grid_jdp_beneficiohogar_detalle_export_email.php?script_case_init={$this->Ini->sc_page}&path_img={$this->Ini->path_img_global}&path_btn={$this->Ini->path_botoes}&sType=\" + str_type +\"&sAdd=__E__nm_json_format=\" + json_format + \"__E__nm_json_label=\" + json_label + \"&KeepThis=true&TB_iframe=true&modal=true\", bol_param);\r\n");
   $nm_saida->saida("       }\r\n");
   $nm_saida->saida("       else\r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           document.Fexport.nmgp_opcao.value       = \"json\";\r\n");
   $nm_saida->saida("           document.Fexport.nm_json_format.value   = json_format;\r\n");
   $nm_saida->saida("           document.Fexport.nm_json_label.value    = json_label;\r\n");
   $nm_saida->saida("           document.Fexport.nmgp_password.value    = password;\r\n");
   $nm_saida->saida("           document.Fexport.SC_module_export.value = SC_module_export;\r\n");
   $nm_saida->saida("           document.Fexport.action = \"grid_jdp_beneficiohogar_detalle_export_ctrl.php\";\r\n");
   $nm_saida->saida("           document.Fexport.submit() ;\r\n");
   $nm_saida->saida("       }\r\n");
   $nm_saida->saida("   }\r\n");
   $nm_saida->saida("   function nm_gp_rtf_conf()\r\n");
   $nm_saida->saida("   {\r\n");
   $nm_saida->saida("       document.Fexport.nmgp_opcao.value   = \"rtf\";\r\n");
   $nm_saida->saida("       document.Fexport.action = \"grid_jdp_beneficiohogar_detalle_export_ctrl.php\";\r\n");
   $nm_saida->saida("       document.Fexport.submit() ;\r\n");
   $nm_saida->saida("   }\r\n");
   $nm_saida->saida("   nm_img = new Image();\r\n");
   $nm_saida->saida("   function nm_mostra_img(imagem, altura, largura)\r\n");
   $nm_saida->saida("   {\r\n");
   $nm_saida->saida("       tb_show(\"\", imagem, \"\");\r\n");
   $nm_saida->saida("   }\r\n");
   $nm_saida->saida("   function nm_mostra_doc(campo1, campo2)\r\n");
   $nm_saida->saida("   {\r\n");
   $nm_saida->saida("       NovaJanela = window.open (campo2 + \"?nmgp_parms=\" + campo1, \"ScriptCase\", \"resizable\");\r\n");
   $nm_saida->saida("   }\r\n");
   $nm_saida->saida("   function nm_escreve_window()\r\n");
   $nm_saida->saida("   {\r\n");
   if (!empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['form_psq_ret']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['campo_psq_ret']) )
   {
      $nm_saida->saida("      if (document.Fpesq.nm_ret_psq.value != \"\")\r\n");
      $nm_saida->saida("      {\r\n");
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['sc_modal']) && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['sc_modal'])
      {
         if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['iframe_ret_cap']))
         {
             $Iframe_cap = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['iframe_ret_cap'];
             unset($_SESSION['sc_session'][$script_case_init]['grid_jdp_beneficiohogar_detalle']['iframe_ret_cap']);
             $nm_saida->saida("           var Obj_Form  = parent.document.getElementById('" . $Iframe_cap . "').contentWindow.document." . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['form_psq_ret'] . "." . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['campo_psq_ret'] . ";\r\n");
             $nm_saida->saida("           var Obj_Form1 = parent.document.getElementById('" . $Iframe_cap . "').contentWindow.document." . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['form_psq_ret'] . "." . str_replace("_autocomp", "_", $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['campo_psq_ret']) . ";\r\n");
             $nm_saida->saida("           var Obj_Doc   = parent.document.getElementById('" . $Iframe_cap . "').contentWindow;\r\n");
             $nm_saida->saida("           if (parent.document.getElementById('" . $Iframe_cap . "').contentWindow.document.getElementById(\"id_read_on_" . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['campo_psq_ret'] . "\"))\r\n");
             $nm_saida->saida("           {\r\n");
             $nm_saida->saida("               var Obj_Readonly = parent.document.getElementById('" . $Iframe_cap . "').contentWindow.document.getElementById(\"id_read_on_" . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['campo_psq_ret'] . "\");\r\n");
             $nm_saida->saida("           }\r\n");
         }
         else
         {
             $nm_saida->saida("          var Obj_Form  = parent.document." . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['form_psq_ret'] . "." . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['campo_psq_ret'] . ";\r\n");
             $nm_saida->saida("          var Obj_Form1 = parent.document." . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['form_psq_ret'] . "." . str_replace("_autocomp", "_", $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['campo_psq_ret']) . ";\r\n");
             $nm_saida->saida("          var Obj_Doc   = parent;\r\n");
             $nm_saida->saida("          if (parent.document.getElementById(\"id_read_on_" . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['campo_psq_ret'] . "\"))\r\n");
             $nm_saida->saida("          {\r\n");
             $nm_saida->saida("              var Obj_Readonly = parent.document.getElementById(\"id_read_on_" . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['campo_psq_ret'] . "\");\r\n");
             $nm_saida->saida("          }\r\n");
         }
      }
      else
      {
          $nm_saida->saida("          var Obj_Form  = opener.document." . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['form_psq_ret'] . "." . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['campo_psq_ret'] . ";\r\n");
          $nm_saida->saida("          var Obj_Form1 = opener.document." . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['form_psq_ret'] . "." . str_replace("_autocomp", "_", $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['campo_psq_ret']) . ";\r\n");
          $nm_saida->saida("          var Obj_Doc   = opener;\r\n");
          $nm_saida->saida("          if (opener.document.getElementById(\"id_read_on_" . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['campo_psq_ret'] . "\"))\r\n");
          $nm_saida->saida("          {\r\n");
          $nm_saida->saida("              var Obj_Readonly = opener.document.getElementById(\"id_read_on_" . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['campo_psq_ret'] . "\");\r\n");
          $nm_saida->saida("          }\r\n");
      }
          $nm_saida->saida("          else\r\n");
          $nm_saida->saida("          {\r\n");
          $nm_saida->saida("              var Obj_Readonly = null;\r\n");
          $nm_saida->saida("          }\r\n");
      $nm_saida->saida("          if (Obj_Form.value != document.Fpesq.nm_ret_psq.value)\r\n");
      $nm_saida->saida("          {\r\n");
      $nm_saida->saida("              Obj_Form.value = document.Fpesq.nm_ret_psq.value;\r\n");
      $nm_saida->saida("              if (Obj_Form != Obj_Form1 && Obj_Form1)\r\n");
      $nm_saida->saida("              {\r\n");
      $nm_saida->saida("                  Obj_Form1.value = document.Fpesq.nm_ret_psq.value;\r\n");
      $nm_saida->saida("              }\r\n");
      $nm_saida->saida("              if (null != Obj_Readonly)\r\n");
      $nm_saida->saida("              {\r\n");
      $nm_saida->saida("                  Obj_Readonly.innerHTML = document.Fpesq.nm_ret_psq.value;\r\n");
      $nm_saida->saida("              }\r\n");
     if (!empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['js_apos_busca']))
     {
      $nm_saida->saida("              if (Obj_Doc." . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['js_apos_busca'] . ")\r\n");
      $nm_saida->saida("              {\r\n");
      $nm_saida->saida("                  Obj_Doc." . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['js_apos_busca'] . "();\r\n");
      $nm_saida->saida("              }\r\n");
      $nm_saida->saida("              else if (Obj_Form.onchange && Obj_Form.onchange != '')\r\n");
      $nm_saida->saida("              {\r\n");
      $nm_saida->saida("                  Obj_Form.onchange();\r\n");
      $nm_saida->saida("              }\r\n");
     }
     else
     {
      $nm_saida->saida("              if (Obj_Form.onchange && Obj_Form.onchange != '')\r\n");
      $nm_saida->saida("              {\r\n");
      $nm_saida->saida("                  Obj_Form.onchange();\r\n");
      $nm_saida->saida("              }\r\n");
     }
      $nm_saida->saida("          }\r\n");
      $nm_saida->saida("      }\r\n");
   }
   $nm_saida->saida("      document.F5.action = \"grid_jdp_beneficiohogar_detalle_fim.php\";\r\n");
   $nm_saida->saida("      document.F5.submit();\r\n");
   $nm_saida->saida("   }\r\n");
   $nm_saida->saida("   function nm_open_popup(parms)\r\n");
   $nm_saida->saida("   {\r\n");
   $nm_saida->saida("       NovaJanela = window.open (parms, '', 'resizable, scrollbars');\r\n");
   $nm_saida->saida("   }\r\n");
   if (($this->grid_emb_form || $this->grid_emb_form_full) && isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_jdp_beneficiohogar_detalle']['reg_start']))
   {
       $nm_saida->saida("      $(document).ready(function(){\r\n");
       $nm_saida->saida("         setTimeout(\"parent.scAjaxDetailStatus('grid_jdp_beneficiohogar_detalle')\",50);\r\n");
       $nm_saida->saida("         setTimeout(\"parent.scAjaxDetailHeight('grid_jdp_beneficiohogar_detalle', $(document).innerHeight())\",50);\r\n");
       $nm_saida->saida("      })\r\n");
   }
   $nm_saida->saida("   function process_hotkeys(hotkey)\r\n");
   $nm_saida->saida("   {\r\n");
   $nm_saida->saida("      if (hotkey == 'sys_format_pdf') { \r\n");
   $nm_saida->saida("         var output =  $('#pdf_top').click();\r\n");
   $nm_saida->saida("         return (0 < output.length);\r\n");
   $nm_saida->saida("      }\r\n");
   $nm_saida->saida("      if (hotkey == 'sys_format_word') { \r\n");
   $nm_saida->saida("         var output =  $('#word_top').click();\r\n");
   $nm_saida->saida("         return (0 < output.length);\r\n");
   $nm_saida->saida("      }\r\n");
   $nm_saida->saida("      if (hotkey == 'sys_format_xls') { \r\n");
   $nm_saida->saida("         var output =  $('#xls_top').click();\r\n");
   $nm_saida->saida("         return (0 < output.length);\r\n");
   $nm_saida->saida("      }\r\n");
   $nm_saida->saida("      if (hotkey == 'sys_format_csv') { \r\n");
   $nm_saida->saida("         var output =  $('#csv_top').click();\r\n");
   $nm_saida->saida("         return (0 < output.length);\r\n");
   $nm_saida->saida("      }\r\n");
   $nm_saida->saida("      if (hotkey == 'sys_format_imp') { \r\n");
   $nm_saida->saida("         var output =  $('#print_top').click();\r\n");
   $nm_saida->saida("         return (0 < output.length);\r\n");
   $nm_saida->saida("      }\r\n");
   $nm_saida->saida("      if (hotkey == 'sys_format_fil') { \r\n");
   $nm_saida->saida("         var output =  $('#pesq_top').click();\r\n");
   $nm_saida->saida("         return (0 < output.length);\r\n");
   $nm_saida->saida("      }\r\n");
   $nm_saida->saida("      if (hotkey == 'sys_format_res') { \r\n");
   $nm_saida->saida("         var output =  $('#res_top').click();\r\n");
   $nm_saida->saida("         return (0 < output.length);\r\n");
   $nm_saida->saida("      }\r\n");
   $nm_saida->saida("      if (hotkey == 'sys_format_webh') { \r\n");
   $nm_saida->saida("         var output =  $('#help_bot').click();\r\n");
   $nm_saida->saida("         return (0 < output.length);\r\n");
   $nm_saida->saida("      }\r\n");
   $nm_saida->saida("      if (hotkey == 'sys_format_sai') { \r\n");
   $nm_saida->saida("         var output =  $('#sai_top').click();\r\n");
   $nm_saida->saida("         return (0 < output.length);\r\n");
   $nm_saida->saida("      }\r\n");
   $nm_saida->saida("      if (hotkey == 'sys_format_ini') { \r\n");
   $nm_saida->saida("         var output =  $('#first_bot').click();\r\n");
   $nm_saida->saida("         return (0 < output.length);\r\n");
   $nm_saida->saida("      }\r\n");
   $nm_saida->saida("      if (hotkey == 'sys_format_ret') { \r\n");
   $nm_saida->saida("         var output =  $('#back_bot').click();\r\n");
   $nm_saida->saida("         return (0 < output.length);\r\n");
   $nm_saida->saida("      }\r\n");
   $nm_saida->saida("      if (hotkey == 'sys_format_ava') { \r\n");
   $nm_saida->saida("         var output =  $('#forward_bot').click();\r\n");
   $nm_saida->saida("         return (0 < output.length);\r\n");
   $nm_saida->saida("      }\r\n");
   $nm_saida->saida("      if (hotkey == 'sys_format_fim') { \r\n");
   $nm_saida->saida("         var output =  $('#last_bot').click();\r\n");
   $nm_saida->saida("         return (0 < output.length);\r\n");
   $nm_saida->saida("      }\r\n");
   $nm_saida->saida("   return false;\r\n");
   $nm_saida->saida("   }\r\n");
   $nm_saida->saida("   </script>\r\n");
 }
}
?>
