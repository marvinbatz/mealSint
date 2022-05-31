<?php
class grid_persona_enlaces_grid
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
   var $pa_nombre_Old;
   var $arg_sum_pa_nombre;
   var $Label_pa_nombre;
   var $sc_proc_quebra_pa_nombre;
   var $count_pa_nombre;
   var $de_nombre_Old;
   var $arg_sum_de_nombre;
   var $Label_de_nombre;
   var $sc_proc_quebra_de_nombre;
   var $count_de_nombre;
   var $mu_nombre_Old;
   var $arg_sum_mu_nombre;
   var $Label_mu_nombre;
   var $sc_proc_quebra_mu_nombre;
   var $count_mu_nombre;
   var $getario_Old;
   var $arg_sum_getario;
   var $Label_getario;
   var $sc_proc_quebra_getario;
   var $count_getario;
   var $g_genero_Old;
   var $arg_sum_g_genero;
   var $Label_g_genero;
   var $sc_proc_quebra_g_genero;
   var $count_g_genero;
   var $qrcode;
   var $td_nombre;
   var $p_foto;
   var $p_nombre;
   var $g_genero;
   var $e_nombre;
   var $p_noidentificacion;
   var $p_fechadenacimiento;
   var $anios;
   var $meses;
   var $getario;
   var $ec_nombre;
   var $l_nombre;
   var $pa_nombre;
   var $de_nombre;
   var $mu_nombre;
   var $c_nombre;
   var $p_direccion;
   var $p_email;
   var $p_telefono;
   var $p_cargo;
   var $p_institucion;
   var $p_idpersona;
//--- 
 function monta_grid($linhas = 0)
 {
   global $nm_saida;

   clearstatcache();
   $this->NM_cor_embutida();
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida_init'])
   { 
        return; 
   } 
   $this->inicializa();
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['charts_html'] = '';
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'])
   { 
       $this->Lin_impressas = 0;
       $this->Lin_final     = FALSE;
       $this->grid();
       $this->nm_fim_grid();
   } 
   else 
   { 
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'])
       { 
           include_once($this->Ini->path_embutida . "grid_persona_enlaces/" . $this->Ini->Apl_resumo); 
       } 
       else 
       { 
           include_once($this->Ini->path_aplicacao . $this->Ini->Apl_resumo); 
       } 
       $this->Res         = new grid_persona_enlaces_resumo();
       $this->Res->Db     = $this->Db;
       $this->Res->Erro   = $this->Erro;
       $this->Res->Ini    = $this->Ini;
       $this->Res->Lookup = $this->Lookup;
       if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['pdf_res'])
       {
            if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf'] || $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf_vert'])
            {
            } 
            else
            {
                $this->cabecalho();
            } 
       } 
            if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf'] || $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf_vert'])
            {
            } 
            else
            {
       $nm_saida->saida("                  <TR>\r\n");
       $nm_saida->saida("                  <TD id='sc_grid_content' style='padding: 0px;' colspan=3>\r\n");
            } 
       $nm_saida->saida("    <table width='100%' cellspacing=0 cellpadding=0>\r\n");
       $nmgrp_apl_opcao= (isset($_SESSION['sc_session']['scriptcase']['embutida_form_pdf']['grid_persona_enlaces'])) ? "pdf" : $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'];
       if ($nmgrp_apl_opcao != "pdf")
       { 
           $this->nmgp_barra_top();
       } 
       if ($nmgrp_apl_opcao != "pdf" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != 'print')
       { 
           if ($this->Ini->grid_search_change_fil)
           { 
               $seq_search = 1;
               foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['grid_pesq'] as $cmp => $def)
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
       unset ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['save_grid']);
       if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['pdf_res'] && (!isset($_GET['flash_graf']) || 'chart' != $_GET['flash_graf']))
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
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['print_all'] && empty($this->nm_grid_sem_reg) && ($Gera_res || $Gera_graf))
       { 
           $this->Res->monta_html_ini_pdf();
           $this->Res->monta_resumo();
           $this->Res->monta_html_fim_pdf();
           if ($Gera_graf)
           {
               $this->grafico_pdf();
           }
       } 
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] == "pdf")
       { 
           if (isset($_GET['flash_graf']) && 'chart' == $_GET['flash_graf'])
           {
               $this->Res->monta_resumo(true);
               require_once($this->Ini->path_aplicacao . $this->Ini->Apl_grafico); 
               $this->Graf  = new grid_persona_enlaces_grafico();
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
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['graf_pdf'] == "S")
       { 
           if (isset($_GET['flash_graf']) && 'pdf' == $_GET['flash_graf'] && $Gera_graf)
           {
               $this->grafico_pdf_flash();
               $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] = "grid";
           } 
           elseif (!$this->Print_All && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] == "pdf" && $Gera_graf)
           { 
               $this->grafico_pdf();
               $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] = "grid";
           } 
           else 
           { 
               $this->nm_fim_grid();
           } 
       } 
       else 
       { 
           $flag_apaga_pdf_log = TRUE;
           if (!$this->Print_All && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] == "pdf")
           { 
               $flag_apaga_pdf_log = FALSE;
               $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] = "igual";
           } 
           $this->nm_fim_grid($flag_apaga_pdf_log);
       } 
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] == "print")
   {
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_ant'];
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] = "";
   }
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_ant'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'];
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
   if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['Ind_lig_mult'])) {
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['Ind_lig_mult'] = 0;
   }
   $this->Img_embbed      = false;
   $this->nm_data         = new nm_data("es");
   $this->pdf_label_group = (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_pdf']['label_group'])) ? $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_pdf']['label_group'] : "N";
   $this->pdf_all_cab     = (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_pdf']['all_cab']))     ? $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_pdf']['all_cab'] : "S";
   $this->pdf_all_label   = (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_pdf']['all_label']))   ? $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_pdf']['all_label'] : "S";
   $this->Grid_body = 'id="sc_grid_body"';
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'])
   {
       $this->Grid_body = "";
   }
   $this->Css_Cmp = array();
   $NM_css = file($this->Ini->root . $this->Ini->path_link . "grid_persona_enlaces/grid_persona_enlaces_grid_" .strtolower($_SESSION['scriptcase']['reg_conf']['css_dir']) . ".css");
   foreach ($NM_css as $cada_css)
   {
       $Pos1 = strpos($cada_css, "{");
       $Pos2 = strpos($cada_css, "}");
       $Tag  = trim(substr($cada_css, 1, $Pos1 - 1));
       $Css  = substr($cada_css, $Pos1 + 1, $Pos2 - $Pos1 - 1);
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['doc_word'])
       { 
           $this->Css_Cmp[$Tag] = $Css;
       }
       else
       { 
           $this->Css_Cmp[$Tag] = "";
       }
   }
   if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['pesq_tab_label']))
   {
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['pesq_tab_label'] = "";
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['pesq_tab_label'] .= "p_idpersona?#?" . "" . "?@?";
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['pesq_tab_label'] .= "p_foto?#?" . "" . "?@?";
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['pesq_tab_label'] .= "p_nombre?#?" . "Nombre" . "?@?";
   }
   if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['grid_search_add']))
   {
       $nmgp_tab_label = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['pesq_tab_label'];
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
       $Seq_grid      = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['grid_search_add']['seq'];
       $Cmp_grid      = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['grid_search_add']['cmp'];
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
       unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['grid_search_add']);
       exit;
   }
   if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['dyn_search_aut_comp']))
   {
       $NM_func_aut_comp = "lookup_ajax_" . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['dyn_search_aut_comp']['cmp'];
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
       unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['dyn_search_aut_comp']);
       exit;
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'])
   {
       if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['Lig_Md5']))
       {
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['Lig_Md5'] = array();
       }
   }
   elseif ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != 'print')
   {
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['Lig_Md5'] = array();
   }
   $this->force_toolbar = false;
   if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['force_toolbar']))
   { 
       $this->force_toolbar = true;
       unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['force_toolbar']);
   } 
       $this->Tem_tab_vert = false;
   if (count($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_cmp']) > 1)
   {
       $this->width_tabula_quebra  = (((count($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_cmp']) - 1) * 13) + 3) . "px";
       $this->width_tabula_display = "''";
       $this->Tem_tab_vert = true;
   }
   else
   {
       $this->width_tabula_quebra  = "0px";
       $this->width_tabula_display = "none";
   }
   if (isset($_SESSION['scriptcase']['sc_apl_conf']['grid_persona_enlaces']['lig_edit']) && $_SESSION['scriptcase']['sc_apl_conf']['grid_persona_enlaces']['lig_edit'] != '')
   {
       if ($_SESSION['scriptcase']['sc_apl_conf']['grid_persona_enlaces']['lig_edit'] == "on")  {$_SESSION['scriptcase']['sc_apl_conf']['grid_persona_enlaces']['lig_edit'] = "S";}
       if ($_SESSION['scriptcase']['sc_apl_conf']['grid_persona_enlaces']['lig_edit'] == "off") {$_SESSION['scriptcase']['sc_apl_conf']['grid_persona_enlaces']['lig_edit'] = "N";}
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['mostra_edit'] = $_SESSION['scriptcase']['sc_apl_conf']['grid_persona_enlaces']['lig_edit'];
   }
   $this->grid_emb_form      = false;
   $this->grid_emb_form_full = false;
   if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida_form']) && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida_form'])
   {
       if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida_form_full']) && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida_form_full'])
       {
          $this->grid_emb_form_full = true;
       }
       else
       {
           $this->grid_emb_form = true;
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['mostra_edit'] = "N";
       }
   }
   if ($this->Ini->SC_Link_View || ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_psq'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['psq_edit'] == 'N'))
   {
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['mostra_edit'] = "N";
   }
   $nm_tem_quebra = 0;
   $this->Nm_bloco_aberto = false;
   $this->sc_proc_quebra_pa_nombre = false;
   $this->sc_proc_quebra_de_nombre = false;
   $this->sc_proc_quebra_mu_nombre = false;
   $this->sc_proc_quebra_getario = false;
   $this->sc_proc_quebra_g_genero = false;
   $this->NM_cont_body   = 0; 
   $this->NM_emb_tree_no = false; 
   if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'])
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['NM_arr_tree'] = array();
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ind_tree'] = 0;
   }
   elseif (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['emb_tree_no']) && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['emb_tree_no'])
   { 
       $this->NM_emb_tree_no = true; 
   }
   $this->aba_iframe = false;
   $this->Print_All = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['print_all'];
   if ($this->Print_All)
   {
       $this->Ini->nm_limite_lin = $this->Ini->nm_limite_lin_prt; 
   }
   if (isset($_SESSION['scriptcase']['sc_aba_iframe']))
   {
       foreach ($_SESSION['scriptcase']['sc_aba_iframe'] as $aba => $apls_aba)
       {
           if (in_array("grid_persona_enlaces", $apls_aba))
           {
               $this->aba_iframe = true;
               break;
           }
       }
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['iframe_menu'] && (!isset($_SESSION['scriptcase']['menu_mobile']) || empty($_SESSION['scriptcase']['menu_mobile'])))
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
   $this->nmgp_botoes['new']    = "on";
   $this->nmgp_botoes['insert'] = "on";
   $this->nmgp_botoes['sel_col'] = "on";
   $this->nmgp_botoes['qsearch'] = "on";
   $this->nmgp_botoes['groupby'] = "on";
   $this->nmgp_botoes['gridsave'] = "on";
   $this->nmgp_botoes['gridsavesession'] = "on";
   $this->Cmps_ord_def['p_noidentificacion'] = " asc";
   $this->Cmps_ord_def['p_idpersona'] = " desc";
   if (isset($_SESSION['scriptcase']['sc_apl_conf']['grid_persona_enlaces']['btn_display']) && !empty($_SESSION['scriptcase']['sc_apl_conf']['grid_persona_enlaces']['btn_display']))
   {
       foreach ($_SESSION['scriptcase']['sc_apl_conf']['grid_persona_enlaces']['btn_display'] as $NM_cada_btn => $NM_cada_opc)
       {
           $this->nmgp_botoes[$NM_cada_btn] = $NM_cada_opc;
       }
   }
   $this->Proc_link_res = false;
   if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_resumo']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_resumo'])) 
   { 
       $this->Proc_link_res            = true;
       $this->nmgp_botoes['filter']    = 'off';
       $this->nmgp_botoes['groupby']   = 'off';
       $this->nmgp_botoes['dynsearch'] = 'off';
       $this->nmgp_botoes['qsearch']   = 'off';
       $this->nmgp_botoes['gridsave']  = 'off';
   } 
   $this->sc_proc_grid = false; 
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['doc_word'] || $this->Ini->sc_export_ajax_img)
   { 
       $this->NM_raiz_img = $this->Ini->root; 
   } 
   else 
   { 
       $this->NM_raiz_img = ""; 
   } 
   $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
   $this->nm_where_dinamico = "";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_pesq'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_pesq_ant'];  
   if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['campos_busca']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['campos_busca']))
   { 
       $Busca_temp = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['campos_busca'];
       if ($_SESSION['scriptcase']['charset'] != "UTF-8")
       {
           $Busca_temp = NM_conv_charset($Busca_temp, $_SESSION['scriptcase']['charset'], "UTF-8");
       }
       $this->p_idpersona = $Busca_temp['p_idpersona']; 
       $tmp_pos = strpos($this->p_idpersona, "##@@");
       if ($tmp_pos !== false && !is_array($this->p_idpersona))
       {
           $this->p_idpersona = substr($this->p_idpersona, 0, $tmp_pos);
       }
       $this->p_foto = $Busca_temp['p_foto']; 
       $tmp_pos = strpos($this->p_foto, "##@@");
       if ($tmp_pos !== false && !is_array($this->p_foto))
       {
           $this->p_foto = substr($this->p_foto, 0, $tmp_pos);
       }
       $this->p_nombre = $Busca_temp['p_nombre']; 
       $tmp_pos = strpos($this->p_nombre, "##@@");
       if ($tmp_pos !== false && !is_array($this->p_nombre))
       {
           $this->p_nombre = substr($this->p_nombre, 0, $tmp_pos);
       }
   } 
   $this->nm_field_dinamico = array();
   $this->nm_order_dinamico = array();
   $this->sc_where_orig   = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_orig'];
   $this->sc_where_atual  = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_pesq'];
   $this->sc_where_filtro = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_pesq_filtro'];
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] == "muda_qt_linhas")
   { 
       unset($rec);
   } 
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] == "muda_rec_linhas")
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] = "muda_qt_linhas";
   } 

   if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['dashboard_info']['under_dashboard']) && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['dashboard_info']['under_dashboard'] && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['dashboard_info']['maximized']) {
       $tmpDashboardApp = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['dashboard_info']['dashboard_app'];
       if (isset($_SESSION['scriptcase']['dashboard_toolbar'][$tmpDashboardApp]['grid_persona_enlaces'])) {
           $tmpDashboardButtons = $_SESSION['scriptcase']['dashboard_toolbar'][$tmpDashboardApp]['grid_persona_enlaces'];

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

   if (isset($_SESSION['scriptcase']['sc_apl_conf']['form_persona']['insert']) && $_SESSION['scriptcase']['sc_apl_conf']['form_persona']['insert'] != '')
   {
       $this->nmgp_botoes['new']    = $_SESSION['scriptcase']['sc_apl_conf']['form_persona']['insert'];
       $this->nmgp_botoes['insert'] = $_SESSION['scriptcase']['sc_apl_conf']['form_persona']['insert'];
   }
   if (isset($_SESSION['scriptcase']['sc_apl_conf']['form_persona']['update']) && $_SESSION['scriptcase']['sc_apl_conf']['form_persona']['update'] != '')
   {
       $this->nmgp_botoes['update'] = $_SESSION['scriptcase']['sc_apl_conf']['form_persona']['update'];
   }
   if (isset($_SESSION['scriptcase']['sc_apl_conf']['form_persona']['delete']) && $_SESSION['scriptcase']['sc_apl_conf']['form_persona']['delete'] != '')
   {
       $this->nmgp_botoes['delete'] = $_SESSION['scriptcase']['sc_apl_conf']['form_persona']['delete'];
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'])
   {
       $nmgp_ordem = ""; 
       $rec = "ini"; 
   } 
//
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'])
   { 
       include_once($this->Ini->path_embutida . "grid_persona_enlaces/grid_persona_enlaces_total.class.php"); 
   } 
   else 
   { 
       include_once($this->Ini->path_aplicacao . "grid_persona_enlaces_total.class.php"); 
   } 
   $dir_raiz          = strrpos($_SERVER['PHP_SELF'],"/") ;  
   $dir_raiz          = substr($_SERVER['PHP_SELF'], 0, $dir_raiz + 1) ;  
   $this->nm_location = $this->Ini->sc_protocolo . $this->Ini->server . $dir_raiz; 
   if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'])
   { 
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida_pdf'] != "pdf")  
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
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida_pdf'] = $_SESSION['scriptcase']['contr_link_emb'];
   } 
   $this->Tot         = new grid_persona_enlaces_total($this->Ini->sc_page);
   $this->Tot->Db     = $this->Db;
   $this->Tot->Erro   = $this->Erro;
   $this->Tot->Ini    = $this->Ini;
   $this->Tot->Lookup = $this->Lookup;
   if (empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_lin_grid']))
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_lin_grid'] = 1;
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_col_grid'] = 1 ;  
   }   
   if (isset($_SESSION['scriptcase']['sc_apl_conf']['grid_persona_enlaces']['rows']) && !empty($_SESSION['scriptcase']['sc_apl_conf']['grid_persona_enlaces']['rows']))
   {
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_lin_grid'] = $_SESSION['scriptcase']['sc_apl_conf']['grid_persona_enlaces']['rows'];  
       unset($_SESSION['scriptcase']['sc_apl_conf']['grid_persona_enlaces']['rows']);
   }
   if (isset($_SESSION['scriptcase']['sc_apl_conf']['grid_persona_enlaces']['cols']) && !empty($_SESSION['scriptcase']['sc_apl_conf']['grid_persona_enlaces']['cols']))
   {
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_col_grid'] = $_SESSION['scriptcase']['sc_apl_conf']['grid_persona_enlaces']['cols'];  
       unset($_SESSION['scriptcase']['sc_apl_conf']['grid_persona_enlaces']['cols']);
   }
   if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_liga']['rows']))
   {
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_lin_grid'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_liga']['rows'];  
   }
   if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_liga']['cols']))
   {
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_col_grid'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_liga']['cols'];  
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] == "muda_qt_linhas") 
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao']  = "igual" ;  
       if (!empty($nmgp_quant_linhas) && !is_array($nmgp_quant_linhas)) 
       { 
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_lin_grid'] = $nmgp_quant_linhas ;  
       } 
       if (!empty($nmgp_quant_colunas)) 
       { 
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_col_grid'] = $nmgp_quant_colunas ;  
       } 
   }   
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_reg_grid'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_lin_grid'] * $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_col_grid']; 
   $this->nm_grid_slides_linha = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_col_grid'];
   $this->Ini->nm_limite_lin = $this->Ini->nm_limite_lin * $this->nm_grid_slides_linha; 
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Ind_Groupby'] == "sc_free_group_by") 
   {
       if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_select']))  
       { 
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_select'] = array(); 
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_select_orig'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_select']; 
       } 
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Ind_Groupby'] == "sc_free_group_by") 
   {
       if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_quebra']))  
       { 
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_quebra'] = array(); 
           foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_sql'] as $cmp_var => $resto)
           {
               foreach ($resto as $SC_Sql_col => $SC_Sql_order)
               {
                   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_quebra'][$cmp_var][$SC_Sql_col] = $SC_Sql_order;
               }
           }
       } 
   }
   if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_grid']))  
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_grid'] = "" ; 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_ant']  = ""; 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_desc'] = ""; 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_cmp']  = ""; 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_label'] = "";  
   }   
   if (!empty($nmgp_ordem))  
   { 
       $nmgp_ordem = str_replace('\"', '"', $nmgp_ordem); 
       if (!isset($this->Cmps_ord_def[$nmgp_ordem])) 
       { 
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] = "igual" ;  
       }
       else
       { 
           $Ordem_tem_quebra = false;
           foreach($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_quebra'] as $campo => $resto) 
           {
               foreach($resto as $sqldef => $ordem) 
               {
                   if ($sqldef == $nmgp_ordem) 
                   { 
                       $Ordem_tem_quebra = true;
                       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] = "inicio" ;  
                       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_grid'] = ""; 
                       $ordem = ($ordem == "asc") ? "desc" : "asc";
                       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_quebra'][$campo][$nmgp_ordem] = $ordem;
                       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_cmp'] = $nmgp_ordem;
                       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_label'] = trim($ordem);
                   }   
               }   
           }   
           if (!$Ordem_tem_quebra)
           {
               $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_grid'] = $nmgp_ordem  ; 
           }
       }
   }   
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] == "ordem")  
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] = "inicio" ;  
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_ant'] == $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_grid'])  
       { 
           if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_desc'] != " desc")  
           { 
               $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_desc'] = " desc" ; 
           } 
           else   
           { 
               $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_desc'] = " asc" ;  
           } 
       } 
       else 
       { 
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_desc'] = $this->Cmps_ord_def[$nmgp_ordem];  
       } 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_label'] = trim($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_desc']);  
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_ant'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_grid'];  
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_cmp'] = $nmgp_ordem;  
   }  
   if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['inicio']))  
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['inicio'] = 0 ;  
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['final']  = 0 ;  
   }   
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_edit'])  
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_edit'] = false;  
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "inicio") 
       { 
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] = "edit" ; 
       } 
   }   
   if (!empty($nmgp_parms) && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf")   
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] = "igual";
       $rec = "ini";
   }
   if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_orig']) || $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['prim_cons'] || !empty($nmgp_parms))  
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['prim_cons'] = false;  
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_orig'] = " where p.idTipoDeDocumento=td.idTipoDeDocumento AND p.idGenero=g.idGenero AND  	 p.idEtnia=e.idEtnia AND p.idEstadoCivil=ec.idEstadoCivil AND p.idComunidad=c.idComunidad AND c.idMunicipio=mu.idMunicipio AND mu.idDepartamento=de.idDepartamento AND de.idPais=pa.idPais AND p.idLgbt=l.idLgbt";  
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_pesq']        = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_orig'];  
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_pesq_ant']    = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_orig'];  
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['cond_pesq']         = ""; 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_pesq_filtro'] = "";
   }   
   if  (!empty($this->nm_where_dinamico)) 
   {   
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_pesq'] .= $this->nm_where_dinamico;
   }   
   $this->sc_where_orig   = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_orig'];
   $this->sc_where_atual  = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_pesq'];
   $this->sc_where_filtro = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_pesq_filtro'];
   $this->sc_where_atual_f = (!empty($this->sc_where_atual)) ? "(" . trim(substr($this->sc_where_atual, 6)) . ")" : "";
   $this->sc_where_atual_f = str_replace("%", "@percent@", $this->sc_where_atual_f);
   $this->sc_where_atual_f = "NM_where_filter*scin" . str_replace("'", "@aspass@", $this->sc_where_atual_f) . "*scout";
//
//--------- 
//
   $nmgp_opc_orig = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao']; 
   if (isset($rec)) 
   { 
       if ($rec == "ini") 
       { 
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] = "inicio" ; 
       } 
       elseif ($rec == "fim") 
       { 
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] = "final" ; 
       } 
       else 
       { 
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] = "avanca" ; 
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['final'] = $rec; 
           if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['final'] > 0) 
           { 
               $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['final']-- ; 
           } 
       } 
   } 
   $this->NM_opcao = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao']; 
   if ($this->NM_opcao == "print") 
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] = "print" ; 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao']       = "igual" ; 
       if ($this->Ini->sc_export_ajax) 
       { 
           $this->Img_embbed = true;
       } 
   } 
// 
   $this->count_ger = 0;
   $this->arg_sum_pa_nombre = "";
   $this->count_pa_nombre = 0;
   $this->arg_sum_de_nombre = "";
   $this->count_de_nombre = 0;
   $this->arg_sum_mu_nombre = "";
   $this->count_mu_nombre = 0;
   $this->arg_sum_getario = "";
   $this->count_getario = 0;
   $this->arg_sum_g_genero = "";
   $this->count_g_genero = 0;
   if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['tot_geral'][1])) 
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['sc_total'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['tot_geral'][1] ;  
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] == "final" || $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_reg_grid'] == "all") 
   { 
       $Gb_geral = "quebra_geral_" . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Ind_Groupby'];
       $this->Tot->$Gb_geral();
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['sc_total'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['tot_geral'][1] ;  
       $this->count_ger = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['tot_geral'][1];
   } 
   if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_dinamic']) && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_dinamic'] != $this->nm_where_dinamico)  
   { 
       unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['tot_geral']);
   } 
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_dinamic'] = $this->nm_where_dinamico;  
   if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['tot_geral']) || $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_pesq'] != $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_pesq_ant'] || $nmgp_opc_orig == "edit") 
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['contr_total_geral'] = "NAO";
       unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['sc_total']);
       $Gb_geral = "quebra_geral_" . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Ind_Groupby'];
       $this->Tot->$Gb_geral();
       if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['contr_array_resumo']))  
       { 
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['contr_array_resumo'] = "NAO";
       } 
   } 
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['sc_total'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['tot_geral'][1] ;  
   $this->count_ger = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['tot_geral'][1];
   if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_resumo']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_resumo'])) 
   { 
       $nmgp_select = "SELECT count(*) AS countTest from " . $this->Ini->nm_tabela; 
       $nmgp_select .= " " . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_pesq']; 
       if (empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_pesq'])) 
       { 
           $nmgp_select .= " where " . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_resumo']; 
       } 
       else
       { 
           $nmgp_select .= " and (" . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_resumo'] . ")"; 
       } 
       $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nmgp_select; 
       $rt_grid = $this->Db->Execute($nmgp_select) ; 
       if ($rt_grid === false && !$rt_grid->EOF && $GLOBALS["NM_ERRO_IBASE"] != 1) 
       { 
           $this->Erro->mensagem(__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg()); 
           exit ; 
       }  
       $this->count_ger = $rt_grid->fields[0];
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['sc_total'] = $rt_grid->fields[0];  
       
   } 
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_reg_grid'] == "all") 
   { 
        $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_reg_grid'] = $this->count_ger;
        $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao']       = "inicio";
   } 
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] == "inicio" || $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] == "pesq") 
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['inicio'] = 0 ; 
   } 
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] == "final") 
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['inicio'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['sc_total'] - $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_reg_grid']; 
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['inicio'] < 0) 
       { 
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['inicio'] = 0 ; 
       } 
   } 
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] == "retorna") 
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['inicio'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['inicio'] - $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_reg_grid']; 
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['inicio'] < 0) 
       { 
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['inicio'] = 0 ; 
       } 
   } 
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] == "avanca" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['sc_total'] >  $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['final']) 
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['inicio'] = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['final']; 
   } 
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != "print" && substr($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'], 0, 7) != "detalhe" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf") 
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] = "igual"; 
   } 
   $this->Rec_ini = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['inicio'] - $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_reg_grid']; 
   if ($this->Rec_ini < 0) 
   { 
       $this->Rec_ini = 0; 
   } 
   $this->Rec_fim = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['inicio'] + $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_reg_grid'] + 1; 
   if ($this->Rec_fim > $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['sc_total']) 
   { 
       $this->Rec_fim = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['sc_total']; 
   } 
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['inicio'] > 0) 
   { 
       $this->Rec_ini++ ; 
   } 
   $this->nmgp_reg_start = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['inicio']; 
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['inicio'] > 0) 
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
       $nmgp_select = "SELECT td.nombre as td_nombre, p.foto as p_foto, p.nombre as p_nombre, g.genero as g_genero, e.nombre as e_nombre, p.noIdentificacion as p_noidentificacion, p.fechaDeNacimiento as p_fechadenacimiento, YEAR( CURDATE( ) ) - YEAR( fechaDeNacimiento ) - IF( MONTH( CURDATE( ) ) < MONTH( fechaDeNacimiento),1,IF ( MONTH(CURDATE( )) = MONTH(fechaDeNacimiento),IF (DAY( CURDATE( ) ) < DAY( fechaDeNacimiento ),1,0 ),0)) as anios, MONTH(CURDATE()) - MONTH( fechaDeNacimiento) + 12 * IF( MONTH(CURDATE())<MONTH(fechaDeNacimiento),1,IF(MONTH(CURDATE())=MONTH(fechaDeNacimiento),IF (DAY(CURDATE())<DAY(fechaDeNacimiento),1,0),0)
    ) - IF(MONTH(CURDATE())<>MONTH(fechaDeNacimiento),(DAY(CURDATE())<DAY(fechaDeNacimiento)),IF (DAY(CURDATE())<DAY(fechaDeNacimiento),1,0 ) ) as meses, IF(YEAR( CURDATE( ) ) - YEAR( fechaDeNacimiento ) - IF( MONTH( CURDATE( ) ) < MONTH( fechaDeNacimiento),1,IF ( MONTH(CURDATE( )) = MONTH(fechaDeNacimiento),IF (DAY( CURDATE( ) ) < DAY( fechaDeNacimiento ),1,0 ),0))>59,'60 años o más',IF(YEAR( CURDATE( ) ) - YEAR( fechaDeNacimiento ) - IF( MONTH( CURDATE( ) ) < MONTH( fechaDeNacimiento),1,IF ( MONTH(CURDATE( )) = MONTH(fechaDeNacimiento),IF (DAY( CURDATE( ) ) < DAY( fechaDeNacimiento ),1,0 ),0))>49,'50 a 59 años',IF(YEAR( CURDATE( ) ) - YEAR( fechaDeNacimiento ) - IF( MONTH( CURDATE( ) ) < MONTH( fechaDeNacimiento),1,IF ( MONTH(CURDATE( )) = MONTH(fechaDeNacimiento),IF (DAY( CURDATE( ) ) < DAY( fechaDeNacimiento ),1,0 ),0))>17,'18 a 49 años',IF(YEAR( CURDATE( ) ) - YEAR( fechaDeNacimiento ) - IF( MONTH( CURDATE( ) ) < MONTH( fechaDeNacimiento),1,IF ( MONTH(CURDATE( )) = MONTH(fechaDeNacimiento),IF (DAY( CURDATE( ) ) < DAY( fechaDeNacimiento ),1,0 ),0))>4,'5 a 17 años',IF(YEAR( CURDATE( ) ) - YEAR( fechaDeNacimiento ) - IF( MONTH( CURDATE( ) ) < MONTH( fechaDeNacimiento),1,IF ( MONTH(CURDATE( )) = MONTH(fechaDeNacimiento),IF (DAY( CURDATE( ) ) < DAY( fechaDeNacimiento ),1,0 ),0))>2,'25 a 59 meses','0 a 24 meses'))))) as getario, ec.nombre as ec_nombre, l.nombre as l_nombre, pa.nombre as pa_nombre, de.nombre as de_nombre, mu.nombre as mu_nombre, c.nombre as c_nombre, p.direccion as p_direccion, p.email as p_email, p.telefono as p_telefono, p.cargo as p_cargo, p.institucion as p_institucion, p.idPersona as p_idpersona from " . $this->Ini->nm_tabela; 
   } 
   else 
   { 
       $nmgp_select = "SELECT td.nombre as td_nombre, p.foto as p_foto, p.nombre as p_nombre, g.genero as g_genero, e.nombre as e_nombre, p.noIdentificacion as p_noidentificacion, p.fechaDeNacimiento as p_fechadenacimiento, YEAR( CURDATE( ) ) - YEAR( fechaDeNacimiento ) - IF( MONTH( CURDATE( ) ) < MONTH( fechaDeNacimiento),1,IF ( MONTH(CURDATE( )) = MONTH(fechaDeNacimiento),IF (DAY( CURDATE( ) ) < DAY( fechaDeNacimiento ),1,0 ),0)) as anios, MONTH(CURDATE()) - MONTH( fechaDeNacimiento) + 12 * IF( MONTH(CURDATE())<MONTH(fechaDeNacimiento),1,IF(MONTH(CURDATE())=MONTH(fechaDeNacimiento),IF (DAY(CURDATE())<DAY(fechaDeNacimiento),1,0),0)
    ) - IF(MONTH(CURDATE())<>MONTH(fechaDeNacimiento),(DAY(CURDATE())<DAY(fechaDeNacimiento)),IF (DAY(CURDATE())<DAY(fechaDeNacimiento),1,0 ) ) as meses, IF(YEAR( CURDATE( ) ) - YEAR( fechaDeNacimiento ) - IF( MONTH( CURDATE( ) ) < MONTH( fechaDeNacimiento),1,IF ( MONTH(CURDATE( )) = MONTH(fechaDeNacimiento),IF (DAY( CURDATE( ) ) < DAY( fechaDeNacimiento ),1,0 ),0))>59,'60 años o más',IF(YEAR( CURDATE( ) ) - YEAR( fechaDeNacimiento ) - IF( MONTH( CURDATE( ) ) < MONTH( fechaDeNacimiento),1,IF ( MONTH(CURDATE( )) = MONTH(fechaDeNacimiento),IF (DAY( CURDATE( ) ) < DAY( fechaDeNacimiento ),1,0 ),0))>49,'50 a 59 años',IF(YEAR( CURDATE( ) ) - YEAR( fechaDeNacimiento ) - IF( MONTH( CURDATE( ) ) < MONTH( fechaDeNacimiento),1,IF ( MONTH(CURDATE( )) = MONTH(fechaDeNacimiento),IF (DAY( CURDATE( ) ) < DAY( fechaDeNacimiento ),1,0 ),0))>17,'18 a 49 años',IF(YEAR( CURDATE( ) ) - YEAR( fechaDeNacimiento ) - IF( MONTH( CURDATE( ) ) < MONTH( fechaDeNacimiento),1,IF ( MONTH(CURDATE( )) = MONTH(fechaDeNacimiento),IF (DAY( CURDATE( ) ) < DAY( fechaDeNacimiento ),1,0 ),0))>4,'5 a 17 años',IF(YEAR( CURDATE( ) ) - YEAR( fechaDeNacimiento ) - IF( MONTH( CURDATE( ) ) < MONTH( fechaDeNacimiento),1,IF ( MONTH(CURDATE( )) = MONTH(fechaDeNacimiento),IF (DAY( CURDATE( ) ) < DAY( fechaDeNacimiento ),1,0 ),0))>2,'25 a 59 meses','0 a 24 meses'))))) as getario, ec.nombre as ec_nombre, l.nombre as l_nombre, pa.nombre as pa_nombre, de.nombre as de_nombre, mu.nombre as mu_nombre, c.nombre as c_nombre, p.direccion as p_direccion, p.email as p_email, p.telefono as p_telefono, p.cargo as p_cargo, p.institucion as p_institucion, p.idPersona as p_idpersona from " . $this->Ini->nm_tabela; 
   } 
   $nmgp_select .= " " . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_pesq']; 
   if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_resumo']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_resumo'])) 
   { 
       if (empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_pesq'])) 
       { 
           $nmgp_select .= " where " . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_resumo']; 
       } 
       else
       { 
           $nmgp_select .= " and (" . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_resumo'] . ")"; 
       } 
   } 
   $nmgp_order_by = ""; 
   $campos_order_select = "";
   foreach($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_select'] as $campo => $ordem) 
   {
        if ($campo != $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_grid']) 
        {
           if (!empty($campos_order_select)) 
           {
               $campos_order_select .= ", ";
           }
           $campos_order_select .= $campo . " " . $ordem;
        }
   }
   $campos_order = "";
   foreach($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_quebra'] as $campo => $resto) 
   {
       foreach($resto as $sqldef => $ordem) 
       {
           $format       = $this->Ini->Get_Gb_date_format($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Ind_Groupby'], $campo);
           $campos_order = $this->Ini->Get_date_order_groupby($sqldef, $ordem, $format, $campos_order);
       }
   }
   if (!empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_grid'])) 
   { 
       if (!empty($campos_order)) 
       { 
           $campos_order .= ", ";
       } 
       $nmgp_order_by = " order by " . $campos_order . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_grid'] . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_desc']; 
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
   $nmgp_select .= $nmgp_order_by; 
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['order_grid'] = $nmgp_order_by;
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] || $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] == "pdf" || $this->Ini->Apl_paginacao == "FULL")
   {
       $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nmgp_select; 
       $this->rs_grid = $this->Db->Execute($nmgp_select) ; 
   }
   else  
   {
       $_SESSION['scriptcase']['sc_sql_ult_comando'] = "SelectLimit($nmgp_select, " . ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_reg_grid'] + 2) . ", $this->nmgp_reg_start)" ; 
       $this->rs_grid = $this->Db->SelectLimit($nmgp_select, $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_reg_grid'] + 2, $this->nmgp_reg_start) ; 
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
       $this->td_nombre = $this->rs_grid->fields[0] ;  
       $this->p_foto = $this->rs_grid->fields[1] ;  
       $this->p_nombre = $this->rs_grid->fields[2] ;  
       $this->g_genero = $this->rs_grid->fields[3] ;  
       $this->e_nombre = $this->rs_grid->fields[4] ;  
       $this->p_noidentificacion = $this->rs_grid->fields[5] ;  
       $this->p_fechadenacimiento = $this->rs_grid->fields[6] ;  
       $this->anios = $this->rs_grid->fields[7] ;  
       $this->anios = (string)$this->anios;
       $this->meses = $this->rs_grid->fields[8] ;  
       $this->meses = (string)$this->meses;
       $this->getario = $this->rs_grid->fields[9] ;  
       $this->ec_nombre = $this->rs_grid->fields[10] ;  
       $this->l_nombre = $this->rs_grid->fields[11] ;  
       $this->pa_nombre = $this->rs_grid->fields[12] ;  
       $this->de_nombre = $this->rs_grid->fields[13] ;  
       $this->mu_nombre = $this->rs_grid->fields[14] ;  
       $this->c_nombre = $this->rs_grid->fields[15] ;  
       $this->p_direccion = $this->rs_grid->fields[16] ;  
       $this->p_email = $this->rs_grid->fields[17] ;  
       $this->p_telefono = $this->rs_grid->fields[18] ;  
       $this->p_cargo = $this->rs_grid->fields[19] ;  
       $this->p_institucion = $this->rs_grid->fields[20] ;  
       $this->p_idpersona = $this->rs_grid->fields[21] ;  
       $this->p_idpersona = (string)$this->p_idpersona;
       if (!isset($this->pa_nombre)) { $this->pa_nombre = ""; }
       if (!isset($this->de_nombre)) { $this->de_nombre = ""; }
       if (!isset($this->mu_nombre)) { $this->mu_nombre = ""; }
       if (!isset($this->getario)) { $this->getario = ""; }
       if (!isset($this->g_genero)) { $this->g_genero = ""; }
       $this->arg_sum_g_genero = " = " . $this->Db->qstr($this->g_genero);
       $this->arg_sum_getario = " = " . $this->Db->qstr($this->getario);
       $this->arg_sum_pa_nombre = " = " . $this->Db->qstr($this->pa_nombre);
       $this->arg_sum_de_nombre = " = " . $this->Db->qstr($this->de_nombre);
       $this->arg_sum_mu_nombre = " = " . $this->Db->qstr($this->mu_nombre);
       $this->SC_seq_register = $this->nmgp_reg_start ; 
       $this->SC_seq_page = 0;
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Ind_Groupby'] == "sc_free_group_by") 
       {
           foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_cmp'] as $cmp => $sql)
           {
               $Cmp_orig   = (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_orig'][$cmp])) ? $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_orig'][$cmp] : $cmp;
               $Format_tst = $this->Ini->Get_Gb_date_format('sc_free_group_by', $cmp);
               $Cmp_Old    = $cmp . '_Old';
               $TP_Time = (in_array($Cmp_orig, $this->Ini->Cmp_Sql_Time)) ? "0000-00-00 " : "";
               $this->$Cmp_Old = $this->Ini->Get_arg_groupby($TP_Time . $this->$Cmp_orig, $Format_tst); 
           }
           $sql_where = "";
           foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_cmp'] as $cmp => $sql)
           {
               $Format_tst = $this->Ini->Get_Gb_date_format('sc_free_group_by', $cmp);
               if (!empty($Format_tst))
               {
                   $tmp = $this->$cmp;
                   if (!empty($tmp))
                   {
                       $sql = $this->Ini->Get_sql_date_groupby($sql, $Format_tst);
                   }
               }
               $cmp_qb     = $this->$cmp;
               $tmp        = "arg_sum_" . $cmp;
               $sql_where .= (!empty($sql_where)) ? " and " : "";
               $sql_where .= $sql . $this->$tmp;
               $tmp        = "quebra_" . $cmp . "_sc_free_group_by";
               $this->$tmp($cmp_qb, $sql_where, $cmp);
           }
       }
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['final'] = $this->nmgp_reg_start ; 
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['inicio'] != 0 && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf") 
       { 
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['final']++ ; 
           $this->SC_seq_register = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['final']; 
           $this->rs_grid->MoveNext(); 
           $this->td_nombre = $this->rs_grid->fields[0] ;  
           $this->p_foto = $this->rs_grid->fields[1] ;  
           $this->p_nombre = $this->rs_grid->fields[2] ;  
           $this->g_genero = $this->rs_grid->fields[3] ;  
           $this->e_nombre = $this->rs_grid->fields[4] ;  
           $this->p_noidentificacion = $this->rs_grid->fields[5] ;  
           $this->p_fechadenacimiento = $this->rs_grid->fields[6] ;  
           $this->anios = $this->rs_grid->fields[7] ;  
           $this->meses = $this->rs_grid->fields[8] ;  
           $this->getario = $this->rs_grid->fields[9] ;  
           $this->ec_nombre = $this->rs_grid->fields[10] ;  
           $this->l_nombre = $this->rs_grid->fields[11] ;  
           $this->pa_nombre = $this->rs_grid->fields[12] ;  
           $this->de_nombre = $this->rs_grid->fields[13] ;  
           $this->mu_nombre = $this->rs_grid->fields[14] ;  
           $this->c_nombre = $this->rs_grid->fields[15] ;  
           $this->p_direccion = $this->rs_grid->fields[16] ;  
           $this->p_email = $this->rs_grid->fields[17] ;  
           $this->p_telefono = $this->rs_grid->fields[18] ;  
           $this->p_cargo = $this->rs_grid->fields[19] ;  
           $this->p_institucion = $this->rs_grid->fields[20] ;  
           $this->p_idpersona = $this->rs_grid->fields[21] ;  
           if (!isset($this->pa_nombre)) { $this->pa_nombre = ""; }
           if (!isset($this->de_nombre)) { $this->de_nombre = ""; }
           if (!isset($this->mu_nombre)) { $this->mu_nombre = ""; }
           if (!isset($this->getario)) { $this->getario = ""; }
           if (!isset($this->g_genero)) { $this->g_genero = ""; }
       } 
   } 
   $this->nmgp_reg_inicial = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['final'] + 1;
   $this->nmgp_reg_final   = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['final'] + $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_reg_grid'];
   $this->nmgp_reg_final   = ($this->nmgp_reg_final > $this->count_ger) ? $this->count_ger : $this->nmgp_reg_final;
// 
   if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'])
   { 
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['doc_word'] && !$this->Ini->sc_export_ajax)
       {
           require_once($this->Ini->path_lib_php . "/sc_progress_bar.php");
           $this->pb = new scProgressBar();
           $this->pb->setRoot($this->Ini->root);
           $this->pb->setDir($_SESSION['scriptcase']['grid_persona_enlaces']['glo_nm_path_imag_temp'] . "/");
           $this->pb->setProgressbarMd5($_GET['pbmd5']);
           $this->pb->initialize();
           $this->pb->setReturnUrl("./");
           $this->pb->setReturnOption($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['word_return']);
           $this->pb->setTotalSteps($this->count_ger);
       }
       if ($this->Ini->Proc_print && $this->Ini->Export_html_zip  && !$this->Ini->sc_export_ajax)
       {
           require_once($this->Ini->path_lib_php . "/sc_progress_bar.php");
           $this->pb = new scProgressBar();
           $this->pb->setRoot($this->Ini->root);
           $this->pb->setDir($_SESSION['scriptcase']['grid_persona_enlaces']['glo_nm_path_imag_temp'] . "/");
           $this->pb->setProgressbarMd5($_GET['pbmd5']);
           $this->pb->initialize();
           $this->pb->setReturnUrl("./");
           $this->pb->setReturnOption($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['print_return']);
           $this->pb->setTotalSteps($this->count_ger);
       }
       if (!$this->Ini->sc_export_ajax && !$this->Print_All && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] == "pdf" && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['pdf_res'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida_pdf'] != "pdf")
       {
           //---------- Gauge ----------
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
            "http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML<?php echo $_SESSION['scriptcase']['reg_conf']['html_dir'] ?>>
<HEAD>
 <TITLE><?php echo $this->Ini->Nm_lang['lang_othr_grid_title'] ?> Personas :: PDF</TITLE>
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
           $this->progress_res     = isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['pivot_charts']) ? sizeof($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['pivot_charts']) : 0;
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
               grid_persona_enlaces_pdf_progress_call("PDF\n", $this->Ini->Nm_lang);
               grid_persona_enlaces_pdf_progress_call($this->Ini->path_js   . "\n", $this->Ini->Nm_lang);
               grid_persona_enlaces_pdf_progress_call($this->Ini->path_prod . "/img/\n", $this->Ini->Nm_lang);
               grid_persona_enlaces_pdf_progress_call($this->progress_tot   . "\n", $this->Ini->Nm_lang);
               fwrite($this->progress_fp, "PDF\n");
               fwrite($this->progress_fp, $this->Ini->path_js   . "\n");
               fwrite($this->progress_fp, $this->Ini->path_prod . "/img/\n");
               fwrite($this->progress_fp, $this->progress_tot   . "\n");
               $lang_protect = $this->Ini->Nm_lang['lang_pdff_strt'];
               if (!NM_is_utf8($lang_protect))
               {
                   $lang_protect = sc_convert_encoding($lang_protect, "UTF-8", $_SESSION['scriptcase']['charset']);
               }
               grid_persona_enlaces_pdf_progress_call($this->progress_tot . "_#NM#_" . "1_#NM#_" . $lang_protect . "...\n", $this->Ini->Nm_lang);
               fwrite($this->progress_fp, "1_#NM#_" . $lang_protect . "...\n");
               flush();
           }
       }
       $nm_fundo_pagina = ""; 
       header("X-XSS-Protection: 1; mode=block");
       header("X-Frame-Options: SAMEORIGIN");
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['doc_word'])
       {
           $nm_saida->saida("  <html xmlns:v=\"urn:schemas-microsoft-com:vml\" xmlns:o=\"urn:schemas-microsoft-com:office:office\" xmlns:w=\"urn:schemas-microsoft-com:office:word\" xmlns:m=\"http://schemas.microsoft.com/office/2004/12/omml\" xmlns=\"http://www.w3.org/TR/REC-html40\">\r\n");
       }
       $nm_saida->saida("<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\"\r\n");
       $nm_saida->saida("            \"http://www.w3.org/TR/1999/REC-html401-19991224/loose.dtd\">\r\n");
       $nm_saida->saida("  <HTML" . $_SESSION['scriptcase']['reg_conf']['html_dir'] . ">\r\n");
       $nm_saida->saida("  <HEAD>\r\n");
       $nm_saida->saida("   <TITLE>" . $this->Ini->Nm_lang['lang_othr_grid_title'] . " Personas</TITLE>\r\n");
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
       if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['doc_word'])
       {
           $nm_saida->saida("   <META http-equiv=\"Expires\" content=\"Fri, Jan 01 1900 00:00:00 GMT\"/>\r\n");
           $nm_saida->saida("   <META http-equiv=\"Last-Modified\" content=\"" . gmdate('D, d M Y H:i:s') . " GMT\"/>\r\n");
           $nm_saida->saida("   <META http-equiv=\"Cache-Control\" content=\"no-store, no-cache, must-revalidate\"/>\r\n");
           $nm_saida->saida("   <META http-equiv=\"Cache-Control\" content=\"post-check=0, pre-check=0\"/>\r\n");
           $nm_saida->saida("   <META http-equiv=\"Pragma\" content=\"no-cache\"/>\r\n");
       }
       $nm_saida->saida("   <link rel=\"shortcut icon\" href=\"../_lib/img/scriptcase__NM__ico__NM__favicon.ico\">\r\n");
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf" && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'])
       { 
           $css_body = "";
       } 
       else 
       { 
           $css_body = "margin-left:0px;margin-right:0px;margin-top:0px;margin-bottom:0px;";
       } 
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf" && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'] && !$this->Ini->sc_export_ajax)
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
           $nm_saida->saida("   <script type=\"text/javascript\" src=\"grid_persona_enlaces_jquery-3.6.0.min.js\"></script>\r\n");
           $nm_saida->saida("   <script type=\"text/javascript\" src=\"grid_persona_enlaces_ajax.js\"></script>\r\n");
           $nm_saida->saida("   <script type=\"text/javascript\" src=\"grid_persona_enlaces_message.js\"></script>\r\n");
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
           if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'])
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
           if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] || $this->Ini->Apl_paginacao == "FULL")
           {
               $nm_saida->saida("   var scQtReg  = " . NM_encode_input($this->count_ger) . ";\r\n");
           }
           else
           {
               $nm_saida->saida("   var scQtReg  = " . NM_encode_input($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_reg_grid']) . ";\r\n");
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
           $nm_saida->saida("        let cells = $(\".sc-ui-grid-header-row-grid_persona_enlaces-1\").find(\"td\");\r\n");
           $nm_saida->saida("        cells.filter(\".sc-col-is-fixed\").css(\"z-index\", 5);\r\n");
           $nm_saida->saida("        cells.filter(\".sc-col-is-fixed\").filter(\".sc-col-actions\").css(\"z-index\", 6);\r\n");
           $nm_saida->saida("    }\r\n");
           $nm_saida->saida("    function scSetFixedHeadersCss(baseTop)\r\n");
           $nm_saida->saida("    {\r\n");
           $nm_saida->saida("        let rows, cols, i, j, thisTop;\r\n");
           $nm_saida->saida("        rows = $(\".sc-ui-grid-header-row-grid_persona_enlaces-1\");\r\n");
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
           $nm_saida->saida("   var gridHeaders = $(\".sc-ui-grid-header-row-grid_persona_enlaces-1\"), headerDisplayed = true;\r\n");
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
           $nm_saida->saida("   tableOriginal = document.getElementById(\"sc-ui-grid-body-f4251bc2\");\r\n");
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
           if ($nmgrp_apl_opcao != "pdf" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != 'print' && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['grid_pesq']))
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
           if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ancor_save']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ancor_save']))
           {
               $nm_saida->saida("       var catTopPosition = jQuery('#SC_ancor" . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ancor_save'] . "').offset().top;\r\n");
               $nm_saida->saida("       jQuery('html, body').animate({scrollTop:catTopPosition}, 'fast');\r\n");
               unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ancor_save']);
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
       if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['num_css']))
       {
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['num_css'] = rand(0, 1000);
       }
       $write_css = true;
       if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && !$this->Print_All && $this->NM_opcao != "print" && $this->NM_opcao != "pdf")
       {
           $write_css = false;
       }
       if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida_pdf']) && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida_pdf'])
       {
           $write_css = true;
       }
       if ($write_css) {$NM_css = @fopen($this->Ini->root . $this->Ini->path_imag_temp . '/sc_css_grid_persona_enlaces_grid_' . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['num_css'] . '.css', 'w');}
       if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'])
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
           $NM_css = file($this->Ini->root . $this->Ini->path_imag_temp . '/sc_css_grid_persona_enlaces_grid_' . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['num_css'] . '.css');
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
           $nm_saida->saida("   <link rel=\"stylesheet\" href=\"" . $this->Ini->path_imag_temp . "/sc_css_grid_persona_enlaces_grid_" . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['num_css'] . ".css\" type=\"text/css\" media=\"screen\" />\r\n");
           $nm_saida->saida("   <link rel=\"stylesheet\" href=\"../_lib/css/" . $_SESSION['scriptcase']['erro']['str_schema'] . "\" type=\"text/css\" media=\"screen\" />\r\n");
           $nm_saida->saida("   <link rel=\"stylesheet\" href=\"../_lib/css/" . $_SESSION['scriptcase']['erro']['str_schema_dir'] . "\" type=\"text/css\" media=\"screen\" />\r\n");
       }
       $str_iframe_body = ($this->aba_iframe) ? 'marginwidth="0px" marginheight="0px" topmargin="0px" leftmargin="0px"' : '';
       $nm_saida->saida("  <style type=\"text/css\">\r\n");
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida_pdf'] != "pdf")
       {
           $nm_saida->saida("  .css_iframes   { margin-bottom: 0px; margin-left: 0px;  margin-right: 0px;  margin-top: 0px; }\r\n");
       }
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf" && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'])
       { 
           $nm_saida->saida("       .ttip {border:1px solid black;font-size:12px;layer-background-color:lightyellow;background-color:lightyellow;color:black;}\r\n");
       } 
       $nm_saida->saida("  </style>\r\n");
           $nm_saida->saida("   <link rel=\"stylesheet\" href=\"../_lib/css/" . $this->Ini->str_schema_all . "_btngrp.css\" type=\"text/css\" media=\"screen\" />\r\n");
           $nm_saida->saida("   <link rel=\"stylesheet\" href=\"../_lib/css/" . $this->Ini->str_schema_all . "_btngrp" . $_SESSION['scriptcase']['reg_conf']['css_dir'] . ".css\" type=\"text/css\" media=\"screen\" />\r\n");
       if (!$write_css)
       {
           $nm_saida->saida("   <link rel=\"stylesheet\" type=\"text/css\" href=\"" . $this->Ini->path_link . "grid_persona_enlaces/grid_persona_enlaces_grid_" . strtolower($_SESSION['scriptcase']['reg_conf']['css_dir']) . ".css\" />\r\n");
       }
       else
       {
           $nm_saida->saida("  <style type=\"text/css\">\r\n");
           $NM_css = file($this->Ini->root . $this->Ini->path_link . "grid_persona_enlaces/grid_persona_enlaces_grid_" .strtolower($_SESSION['scriptcase']['reg_conf']['css_dir']) . ".css");
           foreach ($NM_css as $cada_css)
           {
              $nm_saida->saida("  " . str_replace("\r\n", "", $cada_css) . "\r\n");
           }
  if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf'] || $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf_vert'])
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
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $this->Ini->nm_ger_css_emb)
   {
       $this->Ini->nm_ger_css_emb = false;
           $nm_saida->saida("  <style type=\"text/css\">\r\n");
       $NM_css = file($this->Ini->root . $this->Ini->path_link . "grid_persona_enlaces/grid_persona_enlaces_grid_" .strtolower($_SESSION['scriptcase']['reg_conf']['css_dir']) . ".css");
       foreach ($NM_css as $cada_css)
       {
           $cada_css = ".grid_persona_enlaces_" . substr($cada_css, 1);
              $nm_saida->saida("  " . str_replace("\r\n", "", $cada_css) . "\r\n");
       }
           $nm_saida->saida("  </style>\r\n");
   }
   if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'])
   { 
       if (!$this->Ini->Export_html_zip && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['doc_word'] && ($this->Print_All || $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] == "print")) 
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
          $remove_margin = isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['dashboard_info']['remove_margin']) && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['dashboard_info']['remove_margin'] ? 'margin: 0; ' : '';
          $remove_border = isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['dashboard_info']['remove_border']) && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['dashboard_info']['remove_border'] ? 'border-width: 0; ' : '';
          $vertical_center = '';
           $nm_saida->saida("  <body id=\"grid_slide\" class=\"" . $this->css_scGridPage . "\" " . $str_iframe_body . " style=\"" . $remove_margin . $vertical_center . $css_body . "\">\r\n");
       }
       $nm_saida->saida("  " . $this->Ini->Ajax_result_set . "\r\n");
       if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf" && !$this->Print_All)
       { 
           $Cod_Btn = nmButtonOutput($this->arr_buttons, "berrm_clse", "nmAjaxHideDebug()", "nmAjaxHideDebug()", "", "", "", "", "", "", "", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
           $nm_saida->saida("<div id=\"id_debug_window\" style=\"display: none;\" class='scDebugWindow'><table class=\"scFormMessageTable\">\r\n");
           $nm_saida->saida("<tr><td class=\"scFormMessageTitle\">" . $Cod_Btn . "&nbsp;&nbsp;Output</td></tr>\r\n");
           $nm_saida->saida("<tr><td class=\"scFormMessageMessage\" style=\"padding: 0px; vertical-align: top\"><div style=\"padding: 2px; height: 200px; width: 350px; overflow: auto\" id=\"id_debug_text\"></div></td></tr>\r\n");
           $nm_saida->saida("</table></div>\r\n");
       } 
       if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] == "pdf" && !$this->Print_All)
       { 
           if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Ind_Groupby'] == "sc_free_group_by")
           {
               if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['pdf_res'])
               {
                   $nm_saida->saida("          <div style=\"height:1px;overflow:hidden\"><H1 style=\"font-size:0;padding:1px\">" . $this->Ini->Nm_lang['lang_othr_smry_msge'] . "</H1></div>\r\n");
               } 
               else
               {
                   $groupByLabel = sprintf("País", "pa.nombre");
                   $nm_saida->saida("          <div style=\"height:1px;overflow:hidden\"><H1 style=\"font-size:0;padding:1px\">{$groupByLabel}</H1></div>\r\n");
               } 
           }
       } 
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf" && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['doc_word'])
       { 
           $nm_saida->saida("      <div id=\"tooltip\" style=\"position:absolute;visibility:hidden;border:1px solid black;font-size:12px;layer-background-color:lightyellow;background-color:lightyellow;padding:1px;color:black;\"></div>\r\n");
       } 
       $this->Tab_align  = "center";
       $this->Tab_valign = "top";
       $this->Tab_width = " width=\"90%\"";
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['pdf_res'])
       {
           return;
       } 
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf" && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'])
       { 
           $this->form_navegacao();
           if ($NM_run_iframe != 1) {$this->check_btns();}
       } 
       $nm_saida->saida("   <TABLE id=\"main_table_grid\" cellspacing=0 cellpadding=0 align=\"" . $this->Tab_align . "\" valign=\"" . $this->Tab_valign . "\" " . $this->Tab_width . ">\r\n");
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf'] || $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf_vert'])
   {
   }
   else
   {
       $nm_saida->saida("     <TR>\r\n");
       $nm_saida->saida("       <TD>\r\n");
       $nm_saida->saida("       <div class=\"scGridBorder\" style=\"" . (isset($remove_border) ? $remove_border : '') . "\">\r\n");
       if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['doc_word'])
       { 
           $nm_saida->saida("  <div id=\"id_div_process\" style=\"display: none; margin: 10px; whitespace: nowrap\" class=\"scFormProcessFixed\"><span class=\"scFormProcess\"><img border=\"0\" src=\"" . $this->Ini->path_icones . "/scriptcase__NM__ajax_load.gif\" align=\"absmiddle\" />&nbsp;" . $this->Ini->Nm_lang['lang_othr_prcs'] . "...</span></div>\r\n");
           $nm_saida->saida("  <div id=\"id_div_process_block\" style=\"display: none; margin: 10px; whitespace: nowrap\"><span class=\"scFormProcess\"><img border=\"0\" src=\"" . $this->Ini->path_icones . "/scriptcase__NM__ajax_load.gif\" align=\"absmiddle\" />&nbsp;" . $this->Ini->Nm_lang['lang_othr_prcs'] . "...</span></div>\r\n");
           $nm_saida->saida("  <div id=\"id_fatal_error\" class=\"" . $this->css_scGridLabel . "\" style=\"display: none; position: absolute\"></div>\r\n");
       } 
       $nm_saida->saida("       <TABLE width='100%' cellspacing=0 cellpadding=0>\r\n");
   }
       if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf" && 
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "print" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != "print") 
       { 
           $nm_saida->saida("    <TR>\r\n");
           $nm_saida->saida("    <TD  colspan=3 style=\"padding: 0px; border-width: 0px; vertical-align: top;\">\r\n");
           $nm_saida->saida("     <iframe class=\"css_iframes\" id=\"nmsc_iframe_liga_A_grid_persona_enlaces\" marginWidth=\"0px\" marginHeight=\"0px\" frameborder=\"0\" valign=\"top\" height=\"0px\" width=\"0px\" name=\"nm_iframe_liga_A_grid_persona_enlaces\" scrolling=\"auto\" src=\"NM_Blank_Page.htm\"></iframe>\r\n");
           $nm_saida->saida("    </TD>\r\n");
           $nm_saida->saida("    </TR>\r\n");
           $nm_saida->saida("    <TR>\r\n");
           $nm_saida->saida("    <TD style=\"padding: 0px; border-width: 0px; vertical-align: top;\">\r\n");
           $nm_saida->saida("     <iframe class=\"css_iframes\" id=\"nmsc_iframe_liga_E_grid_persona_enlaces\" marginWidth=\"0px\" marginHeight=\"0px\" frameborder=\"0\" valign=\"top\" height=\"0px\" width=\"0px\" name=\"nm_iframe_liga_E_grid_persona_enlaces\" scrolling=\"auto\" src=\"NM_Blank_Page.htm\"></iframe>\r\n");
           $nm_saida->saida("    </TD>\r\n");
           $nm_saida->saida("    <td style=\"padding: 0px;  vertical-align: top;\"><table style=\"padding: 0px; border-spacing: 0px; border-width: 0px; vertical-align: top;\" width=\"100%\"><tr>\r\n");
           $nm_saida->saida("    <TD colspan=3 style=\"padding: 0px; border-width: 0px; vertical-align: top;\" width=1>\r\n");
      $nm_saida->saida("     <iframe class=\"css_iframes\" id=\"nmsc_iframe_liga_AL_grid_persona_enlaces\" marginWidth=\"0px\" marginHeight=\"0px\" frameborder=\"0\" valign=\"top\" height=\"0px\" width=\"0px\" name=\"nm_iframe_liga_AL_grid_persona_enlaces\" scrolling=\"auto\" src=\"NM_Blank_Page.htm\"></iframe>\r\n");
           $nm_saida->saida("    </TD>\r\n");
           $nm_saida->saida("    </TR>\r\n");
        } 
   }  
 }  
 function NM_cor_embutida()
 {  
   $compl_css = "";
   include($this->Ini->path_btn . $this->Ini->Str_btn_grid);
   if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'])
   {
       $this->NM_css_val_embed = "sznmxizkjnvl";
       $this->NM_css_ajx_embed = "Ajax_res";
   }
   elseif ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_herda_css'] == "N")
   {
       if (($this->NM_opcao == "print" && $GLOBALS['nmgp_cor_print'] == "PB") || ($this->NM_opcao == "pdf" &&  $GLOBALS['nmgp_tipo_pdf'] == "pb") || ($_SESSION['scriptcase']['contr_link_emb'] == "pdf" &&  $GLOBALS['nmgp_tipo_pdf'] == "pb")) 
       { 
           if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['SC_sub_css_bw']['grid_persona_enlaces']))
           {
               $compl_css = str_replace(".", "_", $_SESSION['sc_session'][$this->Ini->sc_page]['SC_sub_css_bw']['grid_persona_enlaces']) . "_";
           } 
       } 
       else 
       { 
           if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['SC_sub_css']['grid_persona_enlaces']))
           {
               $compl_css = str_replace(".", "_", $_SESSION['sc_session'][$this->Ini->sc_page]['SC_sub_css']['grid_persona_enlaces']) . "_";
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
   $this->css_scGridLabelNowrap    = "white-space:nowrap;";
   $this->css_scAppDivMoldura      = $compl_css . "scAppDivMoldura";
   $this->css_scAppDivHeader       = $compl_css . "scAppDivHeader";
   $this->css_scAppDivHeaderText   = $compl_css . "scAppDivHeaderText";
   $this->css_scAppDivContent      = $compl_css . "scAppDivContent";
   $this->css_scAppDivContentText  = $compl_css . "scAppDivContentText";
   $this->css_scAppDivToolbar      = $compl_css . "scAppDivToolbar";
   $this->css_scAppDivToolbarInput = $compl_css . "scAppDivToolbarInput";
   $this->css_inherit_bg           = "scInheritBg";

   $compl_css_emb = ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida']) ? "grid_persona_enlaces_" : "";
   $this->css_sep = " ";
   $this->css_td_nombre_label = $compl_css_emb . "css_td_nombre_label";
   $this->css_td_nombre_grid_line = $compl_css_emb . "css_td_nombre_grid_line";
   $this->css_qrcode_label = $compl_css_emb . "css_qrcode_label";
   $this->css_qrcode_grid_line = $compl_css_emb . "css_qrcode_grid_line";
   $this->css_p_foto_label = $compl_css_emb . "css_p_foto_label";
   $this->css_p_foto_grid_line = $compl_css_emb . "css_p_foto_grid_line";
   $this->css_p_nombre_label = $compl_css_emb . "css_p_nombre_label";
   $this->css_p_nombre_grid_line = $compl_css_emb . "css_p_nombre_grid_line";
   $this->css_g_genero_label = $compl_css_emb . "css_g_genero_label";
   $this->css_g_genero_grid_line = $compl_css_emb . "css_g_genero_grid_line";
   $this->css_e_nombre_label = $compl_css_emb . "css_e_nombre_label";
   $this->css_e_nombre_grid_line = $compl_css_emb . "css_e_nombre_grid_line";
   $this->css_p_noidentificacion_label = $compl_css_emb . "css_p_noidentificacion_label";
   $this->css_p_noidentificacion_grid_line = $compl_css_emb . "css_p_noidentificacion_grid_line";
   $this->css_p_fechadenacimiento_label = $compl_css_emb . "css_p_fechadenacimiento_label";
   $this->css_p_fechadenacimiento_grid_line = $compl_css_emb . "css_p_fechadenacimiento_grid_line";
   $this->css_anios_label = $compl_css_emb . "css_anios_label";
   $this->css_anios_grid_line = $compl_css_emb . "css_anios_grid_line";
   $this->css_meses_label = $compl_css_emb . "css_meses_label";
   $this->css_meses_grid_line = $compl_css_emb . "css_meses_grid_line";
   $this->css_getario_label = $compl_css_emb . "css_getario_label";
   $this->css_getario_grid_line = $compl_css_emb . "css_getario_grid_line";
   $this->css_ec_nombre_label = $compl_css_emb . "css_ec_nombre_label";
   $this->css_ec_nombre_grid_line = $compl_css_emb . "css_ec_nombre_grid_line";
   $this->css_l_nombre_label = $compl_css_emb . "css_l_nombre_label";
   $this->css_l_nombre_grid_line = $compl_css_emb . "css_l_nombre_grid_line";
   $this->css_pa_nombre_label = $compl_css_emb . "css_pa_nombre_label";
   $this->css_pa_nombre_grid_line = $compl_css_emb . "css_pa_nombre_grid_line";
   $this->css_de_nombre_label = $compl_css_emb . "css_de_nombre_label";
   $this->css_de_nombre_grid_line = $compl_css_emb . "css_de_nombre_grid_line";
   $this->css_mu_nombre_label = $compl_css_emb . "css_mu_nombre_label";
   $this->css_mu_nombre_grid_line = $compl_css_emb . "css_mu_nombre_grid_line";
   $this->css_c_nombre_label = $compl_css_emb . "css_c_nombre_label";
   $this->css_c_nombre_grid_line = $compl_css_emb . "css_c_nombre_grid_line";
   $this->css_p_direccion_label = $compl_css_emb . "css_p_direccion_label";
   $this->css_p_direccion_grid_line = $compl_css_emb . "css_p_direccion_grid_line";
   $this->css_p_email_label = $compl_css_emb . "css_p_email_label";
   $this->css_p_email_grid_line = $compl_css_emb . "css_p_email_grid_line";
   $this->css_p_telefono_label = $compl_css_emb . "css_p_telefono_label";
   $this->css_p_telefono_grid_line = $compl_css_emb . "css_p_telefono_grid_line";
   $this->css_p_cargo_label = $compl_css_emb . "css_p_cargo_label";
   $this->css_p_cargo_grid_line = $compl_css_emb . "css_p_cargo_grid_line";
   $this->css_p_institucion_label = $compl_css_emb . "css_p_institucion_label";
   $this->css_p_institucion_grid_line = $compl_css_emb . "css_p_institucion_grid_line";
   $this->css_p_idpersona_label = $compl_css_emb . "css_p_idpersona_label";
   $this->css_p_idpersona_grid_line = $compl_css_emb . "css_p_idpersona_grid_line";
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
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['dashboard_info']['under_dashboard'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['dashboard_info']['compact_mode'] && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['dashboard_info']['maximized'])
   {
       return; 
   }
   if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_liga']['cab']))
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
   $this->sc_where_orig   = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_orig'];
   $this->sc_where_atual  = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_pesq'];
   $this->sc_where_filtro = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_pesq_filtro'];
   if (!empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['cond_pesq']))
   {  
       $pos       = 0;
       $trab_pos  = false;
       $pos_tmp   = true; 
       $tmp       = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['cond_pesq'];
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
       $nm_cond_filtro_or  = (substr($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['cond_pesq'], $trab_pos + 5) == "or")  ? " " . trim($this->Ini->Nm_lang['lang_srch_orr_cond']) . " " : "";
       $nm_cond_filtro_and = (substr($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['cond_pesq'], $trab_pos + 5) == "and") ? " " . trim($this->Ini->Nm_lang['lang_srch_and_cond']) . " " : "";
       $nm_cab_filtro   = substr($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['cond_pesq'], 0, $trab_pos);
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
   if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['sv_dt_head']))
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['sv_dt_head'] = array();
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['sv_dt_head']['fix'] = $nm_data_fixa;
       $nm_refresch_cab_rod = true;
   } 
   else 
   { 
       $nm_refresch_cab_rod = false;
   } 
   foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['sv_dt_head'] as $ind => $val)
   {
       $tmp_var = "sc_data_cab" . $ind;
       if ($$tmp_var != $val)
       {
           $nm_refresch_cab_rod = true;
           break;
       }
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['sv_dt_head']['fix'] != $nm_data_fixa)
   {
       $nm_refresch_cab_rod = true;
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'] && $nm_refresch_cab_rod)
   { 
       $_SESSION['scriptcase']['saida_html'] = "";
   } 
      $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['sv_dt_head']['fix'] = $nm_data_fixa;
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf")
   { 
       $nm_saida->saida("  <TD class=\"" . $this->css_scGridTabelaTd . " " . $this->css_scGridPage . "\" colspan=3 style=\"vertical-align: top\">\r\n");
   } 
   else 
   { 
     if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf']) 
     { 
         $this->NM_calc_span();
           $nm_saida->saida("   <TD colspan=\"" . $this->NM_colspan . "\" class=\"" . $this->css_scGridTabelaTd . "\" style=\"vertical-align: top\">\r\n");
     } 
     else if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf_vert']) 
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
   $nm_saida->saida("    <div class=\"" . $this->css_scGridHeaderFont . "\" style=\"float: left; text-transform: uppercase;\">" . $this->Ini->Nm_lang['lang_othr_grid_title'] . " Personas</div>\r\n");
   $nm_saida->saida("    <div class=\"" . $this->css_scGridHeaderFont . "\" style=\"float: right;\">" . $nm_data_fixa . "</div>\r\n");
   $nm_saida->saida("</div>\r\n");
   $nm_saida->saida("  </TD>\r\n");
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'] && $nm_refresch_cab_rod)
   { 
       $this->Ini->Arr_result['setValue'][] = array('field' => 'sc_grid_head', 'value' => NM_charset_to_utf8($_SESSION['scriptcase']['saida_html']));
       $_SESSION['scriptcase']['saida_html'] = "";
   } 
   $nm_saida->saida(" </TR>\r\n");
 }
    function scGetColumnOrderRule($fieldName)
    {
        $sortRule = 'nosort';
        if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_cmp'] == $fieldName) {
            if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_label'] == 'desc') {
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
            case "anios":
                return true;
            case "meses":
                return true;
            case "p_idpersona":
                return true;
        }
        return false;
    }

    function scGetDefaultFieldOrder($fieldName)
    {
        switch ($fieldName) {
            case "p_fechadenacimiento":
                return 'desc';
            case "anios":
                return 'desc';
            case "meses":
                return 'desc';
            case "p_idpersona":
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
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['rows_emb'] = 0;
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'])
   {
       if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ini_cor_grid']) && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ini_cor_grid'] == "impar")
       {
           $this->Ini->qual_linha = "impar";
           unset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ini_cor_grid']);
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
   $this->sc_where_orig    = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_orig'];
   $this->sc_where_atual   = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_pesq'];
   $this->sc_where_filtro  = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['where_pesq_filtro'];
// 
   $SC_Label = (isset($this->New_label['td_nombre'])) ? $this->New_label['td_nombre'] : "Tipo de Identificación";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['labels']['td_nombre'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['qrcode'])) ? $this->New_label['qrcode'] : "Código QR";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['labels']['qrcode'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['p_foto'])) ? $this->New_label['p_foto'] : "";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['labels']['p_foto'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['p_nombre'])) ? $this->New_label['p_nombre'] : "Nombre";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['labels']['p_nombre'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['g_genero'])) ? $this->New_label['g_genero'] : "Género";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['labels']['g_genero'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['e_nombre'])) ? $this->New_label['e_nombre'] : "Étnia";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['labels']['e_nombre'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['p_noidentificacion'])) ? $this->New_label['p_noidentificacion'] : "No Identificación";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['labels']['p_noidentificacion'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['p_fechadenacimiento'])) ? $this->New_label['p_fechadenacimiento'] : "Fecha De Nacimiento";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['labels']['p_fechadenacimiento'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['anios'])) ? $this->New_label['anios'] : "Años";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['labels']['anios'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['meses'])) ? $this->New_label['meses'] : "Meses";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['labels']['meses'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['getario'])) ? $this->New_label['getario'] : "Getario";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['labels']['getario'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['ec_nombre'])) ? $this->New_label['ec_nombre'] : "Estado Civil";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['labels']['ec_nombre'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['l_nombre'])) ? $this->New_label['l_nombre'] : "LGBT";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['labels']['l_nombre'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['pa_nombre'])) ? $this->New_label['pa_nombre'] : "País";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['labels']['pa_nombre'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['de_nombre'])) ? $this->New_label['de_nombre'] : "Departamento";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['labels']['de_nombre'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['mu_nombre'])) ? $this->New_label['mu_nombre'] : "Municipio";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['labels']['mu_nombre'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['c_nombre'])) ? $this->New_label['c_nombre'] : "Comunidad";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['labels']['c_nombre'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['p_direccion'])) ? $this->New_label['p_direccion'] : "Direccion";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['labels']['p_direccion'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['p_email'])) ? $this->New_label['p_email'] : "Email";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['labels']['p_email'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['p_telefono'])) ? $this->New_label['p_telefono'] : "Teléfono";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['labels']['p_telefono'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['p_cargo'])) ? $this->New_label['p_cargo'] : "Cargo";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['labels']['p_cargo'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['p_institucion'])) ? $this->New_label['p_institucion'] : "Institucion";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['labels']['p_institucion'] = $SC_Label; 
   $SC_Label = (isset($this->New_label['p_idpersona'])) ? $this->New_label['p_idpersona'] : "";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['labels']['p_idpersona'] = $SC_Label; 
   if (!$this->grid_emb_form && isset($_SESSION['scriptcase']['sc_apl_conf']['grid_persona_enlaces']['lig_edit']) && $_SESSION['scriptcase']['sc_apl_conf']['grid_persona_enlaces']['lig_edit'] != '')
   {
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['mostra_edit'] = $_SESSION['scriptcase']['sc_apl_conf']['grid_persona_enlaces']['lig_edit'];
   }
   if (!empty($this->nm_grid_sem_reg))
   {
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'])
       {
           $this->Lin_impressas++;
           if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida_grid'])
           {
               if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['cols_emb']) || empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['cols_emb']))
               {
                   $cont_col = 0;
                   foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['field_order'] as $cada_field)
                   {
                       $cont_col++;
                   }
                   $NM_span_sem_reg = $cont_col - 1;
               }
               else
               {
                   $NM_span_sem_reg  = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['cols_emb'];
               }
               $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['rows_emb']++;
               $nm_saida->saida("  <TR> <TD class=\"" . $this->css_scGridTabelaTd . " " . "\" colspan = \"$NM_span_sem_reg\" align=\"center\" style=\"vertical-align: top;font-family:" . $this->Ini->texto_fonte_tipo_impar . ";font-size:12px;\">\r\n");
               $nm_saida->saida("     " . $this->nm_grid_sem_reg . "</TD> </TR>\r\n");
               $nm_saida->saida("##NM@@\r\n");
               $this->rs_grid->Close();
           }
           else
           {
               $nm_saida->saida("<table id=\"apl_grid_persona_enlaces#?#$nm_seq_execucoes\" width=\"100%\" style=\"padding: 0px; border-spacing: 0px; border-width: 0px; vertical-align: top;\">\r\n");
               $nm_saida->saida("  <tr><td class=\"" . $this->css_scGridTabelaTd . " " . "\" style=\"font-family:" . $this->Ini->texto_fonte_tipo_impar . ";font-size:12px;\"><table style=\"padding: 0px; border-spacing: 0px; border-width: 0px; vertical-align: top;\" width=\"100%\">\r\n");
               $nm_id_aplicacao = "";
               $nm_saida->saida("  <tr><td class=\"" . $this->css_scGridFieldOdd . "\"  style=\"padding: 0px; font-family:" . $this->Ini->texto_fonte_tipo_impar . ";font-size:12px;\" colspan = \"24\" align=\"center\">\r\n");
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
           if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf" && 
               $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "print" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != "print") 
           { 
           $nm_saida->saida("    <TD >\r\n");
           $nm_saida->saida("    <TABLE cellspacing=0 cellpadding=0 width='100%'>\r\n");
               $nm_saida->saida("    <TD style=\"padding: 0px; border-width: 0px; vertical-align: top;\" width=1>\r\n");
      $nm_saida->saida("     <iframe class=\"css_iframes\" id=\"nmsc_iframe_liga_EL_grid_persona_enlaces\" marginWidth=\"0px\" marginHeight=\"0px\" frameborder=\"0\" valign=\"top\" height=\"0px\" width=\"0px\" name=\"nm_iframe_liga_EL_grid_persona_enlaces\" scrolling=\"auto\" src=\"NM_Blank_Page.htm\"></iframe>\r\n");
               $nm_saida->saida("    </TD>\r\n");
               $nm_saida->saida("    <TD style=\"padding: 0px; border-width: 0px; vertical-align: top;\"><TABLE style=\"padding: 0px; border-spacing: 0px; border-width: 0px;\" width=\"100%\"><TR>\r\n");
           } 
           $nm_saida->saida("  <td " . $this->Grid_body . " class=\"" . $this->css_scGridTabelaTd . " " . $this->css_scGridFieldOdd . "\" align=\"center\" style=\"vertical-align: top;font-family:" . $this->Ini->texto_fonte_tipo_impar . ";font-size:12px;\">\r\n");
           if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['force_toolbar']))
           { 
               $this->force_toolbar = true;
               $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['force_toolbar'] = true;
           } 
           if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
           { 
               $_SESSION['scriptcase']['saida_html'] = "";
           } 
           $nm_saida->saida("  " . $this->nm_grid_sem_reg . "\r\n");
           if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
           { 
               $this->Ini->Arr_result['setValue'][] = array('field' => 'sc_grid_body', 'value' => NM_charset_to_utf8($_SESSION['scriptcase']['saida_html']));
               $this->Ini->Arr_result['setSrc'][] = array('field' => 'nmsc_iframe_liga_A_grid_persona_enlaces', 'value' => 'NM_Blank_Page.htm');
               $this->Ini->Arr_result['setSrc'][] = array('field' => 'nmsc_iframe_liga_D_grid_persona_enlaces', 'value' => 'NM_Blank_Page.htm');
               $this->Ini->Arr_result['setSrc'][] = array('field' => 'nmsc_iframe_liga_E_grid_persona_enlaces', 'value' => 'NM_Blank_Page.htm');
               $_SESSION['scriptcase']['saida_html'] = "";
           } 
           $nm_saida->saida("  </td></tr>\r\n");
           if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf" &&
               $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "print" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != "print") 
           { 
               $nm_saida->saida("</TABLE></TD>\r\n");
               $nm_saida->saida("<TD style=\"padding: 0px; border-width: 0px;\" valign=\"top\" width=1>\r\n");
      $nm_saida->saida("     <iframe class=\"css_iframes\" id=\"nmsc_iframe_liga_DL_grid_persona_enlaces\" marginWidth=\"0px\" marginHeight=\"0px\" frameborder=\"0\" valign=\"top\" height=\"0px\" width=\"0px\" name=\"nm_iframe_liga_DL_grid_persona_enlaces\" scrolling=\"auto\" src=\"NM_Blank_Page.htm\"></iframe>\r\n");
               $nm_saida->saida("</TD>\r\n");
               $nm_saida->saida("    <TD style=\"padding: 0px; border-width: 0px; vertical-align: top;\">\r\n");
               $nm_saida->saida("     <iframe class=\"css_iframes\" id=\"nmsc_iframe_liga_D_grid_persona_enlaces\" marginWidth=\"0px\" marginHeight=\"0px\" frameborder=\"0\" valign=\"top\" height=\"0px\" width=\"0px\" name=\"nm_iframe_liga_D_grid_persona_enlaces\" scrolling=\"auto\" src=\"NM_Blank_Page.htm\"></iframe>\r\n");
               $nm_saida->saida("    </TD>\r\n");
               $nm_saida->saida("    </TR>\r\n");
           } 
       $nm_saida->saida("</TABLE>\r\n");
       }
       return;
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'])
   { 
       $nm_saida->saida("<table id=\"apl_grid_persona_enlaces#?#$nm_seq_execucoes\" width=\"100%\" style=\"padding: 0px; border-spacing: 0px; border-width: 0px; vertical-align: top;\">\r\n");
       $nm_saida->saida(" <TR> \r\n");
       $nm_id_aplicacao = "";
   } 
   else 
   { 
if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf'])
{
}
else
{
       $nm_saida->saida("    <TR> \r\n");
}
       if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf" && 
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "print" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != "print") 
       { 
           $nm_saida->saida("    <TD  colspan=3>\r\n");
           $nm_saida->saida("    <TABLE cellspacing=0 cellpadding=0 width='100%'>\r\n");
           $nm_saida->saida("    <TD style=\"padding: 0px; border-width: 0px; vertical-align: top;\" width=1>\r\n");
      $nm_saida->saida("     <iframe class=\"css_iframes\" id=\"nmsc_iframe_liga_EL_grid_persona_enlaces\" marginWidth=\"0px\" marginHeight=\"0px\" frameborder=\"0\" valign=\"top\" height=\"0px\" width=\"0px\" name=\"nm_iframe_liga_EL_grid_persona_enlaces\" scrolling=\"auto\" src=\"NM_Blank_Page.htm\"></iframe>\r\n");
           $nm_saida->saida("    </TD>\r\n");
           $nm_saida->saida("    <TD style=\"padding: 0px; border-width: 0px; vertical-align: top;\"><TABLE style=\"padding: 0px; border-spacing: 0px; border-width: 0px;\" width=\"100%\"><TR>\r\n");
       } 
       $nm_id_aplicacao = " id=\"apl_grid_persona_enlaces#?#1\"";
   } 
   $TD_padding = (!$this->Print_All && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] == "pdf") ? "padding: 0px !important;" : "";
if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf'] || $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf_vert'])
{
}
else
{
   $nm_saida->saida("  <TD " . $this->Grid_body . " class=\"" . $this->css_scGridTabelaTd . "\" style=\"vertical-align: top;text-align: center;" . $TD_padding . "\" width=\"100%\">\r\n");
}
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
   { 
       $_SESSION['scriptcase']['saida_html'] = "";
   } 
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_psq'])
   { 
       $nm_saida->saida("        <div id=\"div_FBtn_Run\" style=\"display: none\"> \r\n");
       $nm_saida->saida("        <form name=\"Fpesq\" method=post>\r\n");
       $nm_saida->saida("         <input type=hidden name=\"nm_ret_psq\"> \r\n");
       $nm_saida->saida("        </div> \r\n");
   } 
if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf'] || $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf_vert'] )
{
}
else
{
   $nm_saida->saida("    <TABLE class=\"" . $this->css_scGridTabela . "\" id=\"sc-ui-grid-body-f4251bc2\" align=\"center\" width=\"100%\">\r\n");
}
if (($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf'] || $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf_vert']) && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] )
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
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] == "pdf")
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['final'] = 0;
   } 
   $this->nmgp_prim_pag_pdf = true;
   $this->Break_pag_pdf = array();
   $this->Break_pag_prt = array();
   $this->Break_pag_pdf['sc_free_group_by']['pa_nombre'] = "N";
   $this->Break_pag_prt['sc_free_group_by']['pa_nombre'] = "N";
   $this->Break_pag_pdf['sc_free_group_by']['de_nombre'] = "N";
   $this->Break_pag_prt['sc_free_group_by']['de_nombre'] = "N";
   $this->Break_pag_pdf['sc_free_group_by']['mu_nombre'] = "N";
   $this->Break_pag_prt['sc_free_group_by']['mu_nombre'] = "N";
   $this->Break_pag_pdf['sc_free_group_by']['getario'] = "N";
   $this->Break_pag_prt['sc_free_group_by']['getario'] = "N";
   $this->Break_pag_pdf['sc_free_group_by']['g_genero'] = "N";
   $this->Break_pag_prt['sc_free_group_by']['g_genero'] = "N";
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['Config_Page_break_PDF'] = "S";
   if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['Page_break_PDF']))
   {
       if (isset($this->Break_pag_pdf[$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Ind_Groupby']]))
       {
           if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Ind_Groupby'] == "sc_free_group_by")
           {
               foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_cmp'] as $Cmp_gb => $resto)
               {
                   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['Page_break_PDF'][$Cmp_gb] = $this->Break_pag_pdf['sc_free_group_by'][$Cmp_gb];
               }
           }
           else
           {
               $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['Page_break_PDF'] = $this->Break_pag_pdf[$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Ind_Groupby']];
           }
       }
       else
       {
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['Page_break_PDF'] = array();
       }
   }
   $this->SC_top       = array();
   $this->SC_bot       = array();
   $this->SC_top[]     = "pa_nombre"; 
   $this->SC_top[]     = "de_nombre"; 
   $this->SC_top[]     = "mu_nombre"; 
   $this->SC_top[]     = "getario"; 
   $this->SC_top[]     = "g_genero"; 
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Ind_Groupby'] == "sc_free_group_by") 
   {
       $Nivel_gb = 1;
       $this->Tab_Nv_tree = array();
       $this->Nivel_gbBot = count($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_cmp']);
       $this->Ult_qb_free = $this->Nivel_gbBot;
       foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_cmp'] as $cmp => $sql)
       {
           if (!isset($this->Prim_cmp_gb))
           {
               $this->Prim_cmp_gb = $cmp;
           }
           $this->Tab_Nv_tree[$cmp] = $Nivel_gb;
           $Nivel_gb++;
           if (in_array($cmp, $this->SC_top))
           {
               $tmp = "quebra_" . $cmp . "_sc_free_group_by_top";
               $this->$tmp($cmp);
           }
       }
       $this->nmgp_prim_pag_pdf = false;
   }
   $this->Ini->cor_link_dados = $this->css_scGridFieldEvenLink;
   $this->NM_flag_antigo = FALSE;
   $nm_prog_barr = 0;
   $PB_tot       = "/" . $this->count_ger;;
   $this->nm_contr_album = 0;
   while (!$this->rs_grid->EOF && $nm_quant_linhas < $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_reg_grid'] && ($linhas == 0 || $linhas > $this->Lin_impressas)) 
   {  
          $this->NM_field_color = array();
          $this->NM_field_style = array();
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['doc_word'] && !$this->Ini->sc_export_ajax)
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
          if (!$this->Ini->sc_export_ajax && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] == "pdf" && -1 < $this->progress_grid)
          {
              $this->progress_now++;
              if (0 == $this->progress_lim_now)
              {
               $lang_protect = $this->Ini->Nm_lang['lang_pdff_rows'];
               if (!NM_is_utf8($lang_protect))
               {
                   $lang_protect = sc_convert_encoding($lang_protect, "UTF-8", $_SESSION['scriptcase']['charset']);
               }
                  grid_persona_enlaces_pdf_progress_call($this->progress_tot . "_#NM#_" . $this->progress_now . "_#NM#_" . $lang_protect . " " . $this->progress_now . "...\n", $this->Ini->Nm_lang);
                  fwrite($this->progress_fp, $this->progress_now . "_#NM#_" . $lang_protect . " " . $this->progress_now . "...\n");
              }
              $this->progress_lim_now++;
              if ($this->progress_lim_tot == $this->progress_lim_now)
              {
                  $this->progress_lim_now = 0;
              }
          }
          $this->Lin_impressas++;
          $this->td_nombre = $this->rs_grid->fields[0] ;  
          $this->p_foto = $this->rs_grid->fields[1] ;  
          $this->p_nombre = $this->rs_grid->fields[2] ;  
          $this->g_genero = $this->rs_grid->fields[3] ;  
          $this->e_nombre = $this->rs_grid->fields[4] ;  
          $this->p_noidentificacion = $this->rs_grid->fields[5] ;  
          $this->p_fechadenacimiento = $this->rs_grid->fields[6] ;  
          $this->anios = $this->rs_grid->fields[7] ;  
          $this->anios = (string)$this->anios;
          $this->meses = $this->rs_grid->fields[8] ;  
          $this->meses = (string)$this->meses;
          $this->getario = $this->rs_grid->fields[9] ;  
          $this->ec_nombre = $this->rs_grid->fields[10] ;  
          $this->l_nombre = $this->rs_grid->fields[11] ;  
          $this->pa_nombre = $this->rs_grid->fields[12] ;  
          $this->de_nombre = $this->rs_grid->fields[13] ;  
          $this->mu_nombre = $this->rs_grid->fields[14] ;  
          $this->c_nombre = $this->rs_grid->fields[15] ;  
          $this->p_direccion = $this->rs_grid->fields[16] ;  
          $this->p_email = $this->rs_grid->fields[17] ;  
          $this->p_telefono = $this->rs_grid->fields[18] ;  
          $this->p_cargo = $this->rs_grid->fields[19] ;  
          $this->p_institucion = $this->rs_grid->fields[20] ;  
          $this->p_idpersona = $this->rs_grid->fields[21] ;  
          $this->p_idpersona = (string)$this->p_idpersona;
          if (!isset($this->pa_nombre)) { $this->pa_nombre = ""; }
          if (!isset($this->de_nombre)) { $this->de_nombre = ""; }
          if (!isset($this->mu_nombre)) { $this->mu_nombre = ""; }
          if (!isset($this->getario)) { $this->getario = ""; }
          if (!isset($this->g_genero)) { $this->g_genero = ""; }
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] == "pdf")
          {
              $this->Res->nm_acum_res_unit($this->rs_grid);
          }
          $this->arg_sum_g_genero = " = " . $this->Db->qstr($this->g_genero);
          $this->arg_sum_getario = " = " . $this->Db->qstr($this->getario);
          $this->arg_sum_pa_nombre = " = " . $this->Db->qstr($this->pa_nombre);
          $this->arg_sum_de_nombre = " = " . $this->Db->qstr($this->de_nombre);
          $this->arg_sum_mu_nombre = " = " . $this->Db->qstr($this->mu_nombre);
          $this->SC_seq_page++; 
          $this->SC_seq_register = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['final'] + 1; 
          $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['rows_emb']++;
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Ind_Groupby'] == "sc_free_group_by") 
          {  
              $SC_arg_Gby = array();
              $SC_arg_Sql = array();
              foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_cmp'] as $cmp => $sql)
              {
                  $Cmp_orig   = (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_orig'][$cmp])) ? $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_orig'][$cmp] : $cmp;
                  $Format_tst = $this->Ini->Get_Gb_date_format('sc_free_group_by', $cmp);
                  $TP_Time = (in_array($Cmp_orig, $this->Ini->Cmp_Sql_Time)) ? "0000-00-00 " : "";
                  $SC_arg_Gby[$cmp] = $this->Ini->Get_arg_groupby($TP_Time . $this->$Cmp_orig, $Format_tst); 
              }
              $SC_lst_Gby = array();
              $gb_ok      = false;
              foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_cmp'] as $cmp => $sql)
              {
                  $Format_tst = $this->Ini->Get_Gb_date_format('sc_free_group_by', $cmp);
                  $SC_arg_Sql[$cmp] = $sql;
                  $Fun_GB  = (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_orig'][$cmp])) ? $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_orig'][$cmp] : $cmp;
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
              $this->Nivel_gbBot = count($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_cmp']);
              krsort ($SC_lst_Gby);
              $Qb_page = true;
              foreach ($SC_lst_Gby as $Ind => $cmp)
              {
                  if (in_array($cmp, $this->SC_bot))
                  {
                      $tmp = "quebra_" . $cmp . "_sc_free_group_by_bot";
                      $this->$tmp($cmp);
                      $this->Nivel_gbBot--;
                  }
                  $sql_where = "";
                  $cmp_qb     = $this->$cmp;
                  foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_cmp'] as $Col_Gb => $Sql)
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
              if (!empty($SC_lst_Gby))
              {
                  $cmp = $SC_lst_Gby[0];
                  if ($this->Print_All && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['doc_word'] && $this->Break_pag_prt[$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Ind_Groupby']][$cmp] == "S" && $Qb_page)
                  {
                      $this->nm_quebra_pagina("pagina"); 
                  }
                  elseif (!$this->Print_All && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] == "pdf" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['Page_break_PDF'][$cmp] == "S" && $Qb_page)
                  {
                      $this->nm_quebra_pagina("pagina"); 
                  }
                  $Qb_page = false;
              }
              $this->Nivel_gbBot = count($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_cmp']);
              ksort ($SC_lst_Gby);
              foreach ($SC_lst_Gby as $Ind => $cmp)
              {
                  if (in_array($cmp, $this->SC_top))
                  {
                      $tmp = "quebra_" . $cmp . "_sc_free_group_by_top";
                      $this->$tmp($cmp);
                  }
              }
              if (!empty($SC_lst_Gby))
              {
                  $nm_houve_quebra = "S";
                  foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_cmp'] as $cmp => $sql)
                  {
                      $Cmp_orig   = (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_orig'][$cmp])) ? $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_orig'][$cmp] : $cmp;
                      $Format_tst = $this->Ini->Get_Gb_date_format('sc_free_group_by', $cmp);
                      $Cmp_Old   = $cmp . '_Old';
                      $TP_Time = (in_array($Cmp_orig, $this->Ini->Cmp_Sql_Time)) ? "0000-00-00 " : "";
                      $this->$Cmp_Old = $this->Ini->Get_arg_groupby($TP_Time . $this->$Cmp_orig, $Format_tst); 
                  }
              }
          }  
          $this->sc_proc_grid = true;
          $_SESSION['scriptcase']['grid_persona_enlaces']['contr_erro'] = 'on';
 $this->qrcode  = $this->p_noidentificacion ." ".$this->p_nombre ;
$_SESSION['scriptcase']['grid_persona_enlaces']['contr_erro'] = 'off';
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf'])
          {
              if (($nm_houve_quebra == "S" || $this->nm_inicio_pag == 0) && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida_grid'])
              { 
                 if ($this->pdf_label_group == "S") 
                 {
                     $this->label_grid($linhas);
                 } 
                 $nm_houve_quebra = "N";
             } 
          } 
          $this->nm_inicio_pag++;
          if (!$this->NM_flag_antigo)
          {
             $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['final']++ ; 
          }
          $seq_det =  $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['final']; 
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
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_psq'])
          {
              $temp = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['dado_psq_ret'];
              eval("\$teste = \$this->$temp;");
              if ($temp == "p_fechadenacimiento")
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
 if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_psq']) { 
$nm_saida->saida("     &nbsp;\r\n");
 } 
 if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_psq']) { 
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
     if ('' != $this->Ini->Block_img_exp && '' != $this->Ini->Block_img_col && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf")
     {
         $Img_tit_blk_i = "<table style=\"border-collapse: collapse; height: 100%; width: 100%\"><tr><td style=\"vertical-align: middle; border-width: 0px; padding: 0px 2px 0px 0px\"><img src=\"" . $this->Ini->path_icones . "/" . $this->Ini->Block_img_col . "\" style=\"border: 0px; float: left\" class=\"sc-ui-block-control\"></td><td class=\"" . $this->css_scGridBlockAlign . " css_blk_0\" style=\"border-width: 0px; padding: 0px; width: 100%;@STYBLK@\">";
         $Img_tit_blk_f = "</td></tr></table>";
     }
$nm_saida->saida("  <TABLE class=\"" . $this->css_scGridTabela . "\"  style=\"border-collapse:collapse;\" cellspacing=0px cellpadding=0px align=\"center\" id=\"grid_persona_enlaces_hidden_bloco_0_" . $this->nm_contr_album . "\" width=\"100%\" style=\"height: 100%\">\r\n");
$nm_saida->saida("   <TR>\r\n");
$nm_saida->saida("    <TD  style=\"border-width: 0px; border-style: none; \" height=\"\" valign=\"top\" width=\"100%\">\r\n");
$nm_saida->saida("     <TABLE style=\"padding: 0px; spacing: 0px; border-width: 0px; border-collapse:collapse;\" width=\"100%\">\r\n");
$nm_saida->saida("      <TR>\r\n");
 if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != "print") { 
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . "\"   align=\"center\" valign=\"\"  >\r\n");
$nm_saida->saida("     &nbsp;\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . "\"  NOWRAP align=\"center\" valign=\"\" width=\"25%\" >\r\n");
 if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != "print" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['mostra_edit'] != "N"){ 
              $Sc_parent = ($this->grid_emb_form || $this->grid_emb_form_full) ? "S" : "";
              $Parms_Det  = "nmgp_chave_det?#?" . $this->td_nombre . "*PDet*" . $this->p_foto . "*PDet*" . $this->p_nombre . "*PDet*" . $this->g_genero . "*PDet*" . $this->e_nombre . "*PDet*" . $this->p_noidentificacion . "*PDet*" . $this->anios . "*PDet*" . $this->meses . "*PDet*" . $this->getario . "*PDet*" . $this->ec_nombre . "*PDet*" . $this->l_nombre . "*PDet*" . $this->pa_nombre . "*PDet*" . $this->de_nombre . "*PDet*" . $this->mu_nombre . "*PDet*" . $this->c_nombre . "*PDet*" . $this->p_direccion . "*PDet*" . $this->p_email . "*PDet*" . $this->p_telefono . "*PDet*" . $this->p_cargo . "*PDet*" . $this->p_institucion . "*PDet*" . $this->p_idpersona . "?@?Sc_seq_det?#?" . $this->SC_seq_register . "?#?";
              $Md5_Det    = "@SC_par@" . NM_encode_input($this->Ini->sc_page) . "@SC_par@grid_persona_enlaces@SC_par@" . md5($Parms_Det);
              $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['Lig_Md5'][md5($Parms_Det)] = $Parms_Det;
     $Link_Det  = nmButtonOutput($this->arr_buttons, "bcons_detalhes", "nm_gp_submit3('" . $Md5_Det . "', '', 'detalhe', '" . $this->SC_ancora . "')", "nm_gp_submit3('" . $Md5_Det . "', '', 'detalhe', '" . $this->SC_ancora . "')", "", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
              if ($_SESSION['scriptcase']['proc_mobile']) {
                  $Link_Det  = nmButtonOutput($this->arr_buttons, "bcons_detalhes", "nm_submit_modal('" . $this->Ini->path_link . "grid_persona_enlaces/index.php?nmgp_parms=" . $Md5_Det . "&nmgp_parm_acum=&script_case_init=" . NM_encode_input($this->Ini->sc_page) . "&SC_lig_apl_orig=grid_persona_enlaces&nmgp_opcao=detalhe&KeepThis=true&TB_iframe=true&height=440&width=630&modal=true', '" . $Sc_parent . "')", "nm_submit_modal('" . $this->Ini->path_link . "grid_persona_enlaces/index.php?nmgp_parms=" . $Md5_Det . "&nmgp_parm_acum=&script_case_init=" . NM_encode_input($this->Ini->sc_page) . "&SC_lig_apl_orig=grid_persona_enlaces&nmgp_opcao=detalhe&KeepThis=true&TB_iframe=true&height=440&width=630&modal=true', '" . $Sc_parent . "')", "", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
              }
              $Sc_parent = ($this->grid_emb_form_full) ? "S" : "";
              if (isset($this->Ini->sc_lig_md5["form_persona"]) && $this->Ini->sc_lig_md5["form_persona"] == "S")
              {
                  $Parms_Edt  = "idpersona?#?" . str_replace('"', "@aspasd@", $this->p_idpersona) . "?@?NM_btn_insert?#?S?@?NM_btn_update?#?S?@?NM_btn_delete?#?S?@?NM_btn_navega?#?N?@?nmgp_opcao?#?igual?@?";
                  $Md5_Edt    = "@SC_par@" . NM_encode_input($this->Ini->sc_page) . "@SC_par@grid_persona_enlaces@SC_par@" . md5($Parms_Edt);
                  $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['Lig_Md5'][md5($Parms_Edt)] = $Parms_Edt;
              }
              else
              {
                  $Md5_Edt  = "idpersona?#?" . str_replace('"', "@aspasd@", $this->p_idpersona) . "?@?NM_btn_insert?#?S?@?NM_btn_update?#?S?@?NM_btn_delete?#?S?@?NM_btn_navega?#?N?@?nmgp_opcao?#?igual?@?";
              }
     $Link_Edit = nmButtonOutput($this->arr_buttons, "bform_editar", "nm_gp_submit4('" .  $this->Ini->link_form_persona . "', '$this->nm_location',  '$Md5_Edt' , '". (isset($linkTarget) ? $linkTarget : '_self') . "', '', 'form_persona', '" . $this->SC_ancora . "')", "nm_gp_submit4('" .  $this->Ini->link_form_persona . "', '$this->nm_location',  '$Md5_Edt' , '". (isset($linkTarget) ? $linkTarget : '_self') . "', '', 'form_persona', '" . $this->SC_ancora . "')", "bedit", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
$nm_saida->saida("     " . $Link_Det . " " . $Link_Edit . " \r\n");
 } 
 if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != "print" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['mostra_edit'] == "N"){ 
$nm_saida->saida("     " . $Link_Det . " \r\n");
 } 
$nm_saida->saida("    </TD>\r\n");
 } 
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_td_nombre_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['td_nombre']) && $this->NM_cmp_hidden['td_nombre'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['td_nombre'])) ? $this->New_label['td_nombre'] : "Tipo de Identificación";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_td_nombre_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_td_nombre_grid_line . "\"  style=\"" . $this->Css_Cmp['css_td_nombre_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = sc_strip_script($this->td_nombre); 
          $conteudo_original = sc_strip_script($this->td_nombre); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['td_nombre']) && $this->NM_cmp_hidden['td_nombre'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_td_nombre_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("   </tr><tr>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_qrcode_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['qrcode']) && $this->NM_cmp_hidden['qrcode'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['qrcode'])) ? $this->New_label['qrcode'] : "Código QR";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_qrcode_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_qrcode_grid_line . "\"  style=\"" . $this->Css_Cmp['css_qrcode_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"middle\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = $this->qrcode; 
          $conteudo_original = $this->qrcode; 
          if ($conteudo == "" || empty($this->qrcode) || $this->qrcode == "none" || $this->qrcode == "*nm*") 
          { 
              $conteudo = "&nbsp;" ;  
              $out_qrcode = "" ; 
          } 
          elseif ($this->Ini->Gd_missing)
          { 
              $conteudo = "<span class=\"scErrorLine\">" . $this->Ini->Nm_lang['lang_errm_gd'] . "</span>";
              $out_qrcode = "" ; 
          } 
          else   
          { 
              $out_qrcode = $this->Ini->path_imag_temp . "/sc_qrcode_" . $_SESSION['scriptcase']['sc_num_img'] . session_id() . ".png";   
              QRcode::png($conteudo, $this->Ini->root . $out_qrcode, 3,8,0);
              $_SESSION['scriptcase']['sc_num_img']++;
          } 
          if (!empty($out_qrcode)) 
          { 
              if ($this->Ini->Export_img_zip)
              {
                  $this->Ini->Img_export_zip[] = $this->Ini->root . "/" . $out_qrcode;
                  $Clear_path_img = str_replace($this->Ini->path_imag_temp . "/", "", $out_qrcode);
                  $conteudo = "<img border=\"\" src=\"" . $Clear_path_img . "\"/>"; 
              }
              elseif ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['doc_word'] || $this->Img_embbed || $this->Ini->sc_export_ajax_img) 
              { 
                  $loc_img_word = $this->NM_raiz_img . $out_qrcode;
                  $tmp_qrcode = fopen($loc_img_word, "rb"); 
                  $reg_qrcode = fread($tmp_qrcode, filesize($loc_img_word)); 
                  fclose($tmp_qrcode);
                  $conteudo = "<img border=\"0\" src=\"data:image/png;base64," . base64_encode($reg_qrcode) . "\"/>" ; 
              } 
              else 
              { 
                  $conteudo = "<img src=\"" . $this->NM_raiz_img . $out_qrcode . "\" BORDER=\"0\"/>" ; 
              } 
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['qrcode']) && $this->NM_cmp_hidden['qrcode'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_qrcode_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_p_foto_label . "\"  NOWRAP align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['p_foto']) && $this->NM_cmp_hidden['p_foto'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['p_foto'])) ? $this->New_label['p_foto'] : "";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_p_foto_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_p_foto_grid_line . "\"  style=\"" . $this->Css_Cmp['css_p_foto_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = $this->p_foto; 
          $conteudo_original = $this->p_foto; 
          if ($conteudo == "" || empty($this->p_foto) || $this->p_foto == "none" || $this->p_foto == "*nm*") 
          { 
              $conteudo = "&nbsp;" ;  
              $out_p_foto = "" ; 
          } 
          elseif ($this->Ini->Gd_missing)
          { 
              $conteudo = "<span class=\"scErrorLine\">" . $this->Ini->Nm_lang['lang_errm_gd'] . "</span>";
          } 
          else 
          { 
              $nm_local_img = $this->Ini->path_imagens .'/'. "fotosBeneficiarios" . "/"; 
              nm_fix_SubDirUpload($conteudo, $this->Ini->root . $this->Ini->path_imagens,  "fotosBeneficiarios"); 
              $md5_p_foto  = md5("fotosBeneficiarios" . $conteudo);
              $in_p_foto = $this->Ini->root . $nm_local_img . $conteudo;
              $nm_tmp_ver_bk = strpos($conteudo, " "); 
              if ($nm_tmp_ver_bk === false)
              {
                  if (is_file($in_p_foto))  
                  { 
                     $NM_ler_img = true;
                     $out_p_foto = $this->Ini->path_imag_temp . "/sc_p_foto_" . $md5_p_foto . ".jpg" ;  
                     if (is_file($this->Ini->root . $out_p_foto))  
                     { 
                         $NM_img_time = filemtime($this->Ini->root . $out_p_foto) + 0; 
                         if ($this->Ini->nm_timestamp < $NM_img_time)  
                         { 
                             $NM_ler_img = false;
                             $in_p_foto = $this->Ini->root . $out_p_foto;
                         } 
                     } 
                     if ($NM_ler_img) 
                     { 
                         $tmp_p_foto = fopen($in_p_foto, "r") ; 
                         $reg_p_foto = fread($tmp_p_foto, filesize($in_p_foto)) ; 
                         fclose($tmp_p_foto) ;  
                         $arq_p_foto = fopen($this->Ini->root . $out_p_foto, "w") ;  
                         fwrite($arq_p_foto, $reg_p_foto); 
                         fclose($arq_p_foto) ;  
                         $in_p_foto = $this->Ini->root . $out_p_foto;
                     } 
                     $nm_local_img = ""; 
                     $conteudo     = $out_p_foto; 
                  } 
              }
              $nm_image_largura = 0;
              $nm_image_altura  = 0;
              if (is_file($in_p_foto))  
              { 
                  $sc_obj_img = new nm_trata_img($file_get);
                  $nm_image_largura = $sc_obj_img->getWidth();
                  $nm_image_altura  = $sc_obj_img->getHeight();
              } 
              $NM_redim_img = true;
              $out_p_foto = $this->Ini->path_imag_temp . "/sc_p_foto_250250" . $md5_p_foto . ".jpg" ;  
              if (is_file($this->Ini->root . $out_p_foto))  
              { 
                  $NM_img_time = filemtime($this->Ini->root . $out_p_foto) + 0; 
                  if ($this->Ini->nm_timestamp < $NM_img_time)  
                  { 
                      $NM_redim_img = false;
                  } 
              } 
              if ($NM_redim_img && is_file($in_p_foto)) 
              { 
                  $sc_obj_img = new nm_trata_img($in_p_foto);
                  $sc_obj_img->setWidth(250);
                  $sc_obj_img->setHeight(250);
                  $sc_obj_img->setManterAspecto(true);
                  $sc_obj_img->createImg($this->Ini->root . $out_p_foto);
              } 
              $loc_img_word = $in_p_foto;
              if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['doc_word'] || $this->Ini->sc_export_ajax_img) 
              { 
                  $tmp_p_foto = fopen($loc_img_word, "rb"); 
                  $reg_p_foto = fread($tmp_p_foto, filesize($loc_img_word)); 
                  fclose($tmp_p_foto);  
              } 
              if ($this->Ini->Export_img_zip)
              {
                  $this->Ini->Img_export_zip[] = $this->Ini->root . "/" . $out_p_foto;
                  $Clear_path_img = str_replace($this->Ini->path_imag_temp . "/", "", $out_p_foto);
                  $conteudo = "<img border=\"0\" src=\"" . $Clear_path_img . "\"/>"; 
              }
              elseif ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['doc_word'] || $this->Img_embbed || $this->Ini->sc_export_ajax_img) 
              { 
                  $conteudo = "<img border=\"0\" src=\"data:image/jpeg;base64," . base64_encode($reg_p_foto) . "\"/>" ; 
              } 
              elseif ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida_pdf'] != "pdf") 
              { 
                  $conteudo = "<a href=\"javascript:nm_mostra_img('" . $nm_local_img . $conteudo . "', $nm_image_altura, $nm_image_largura)\"><img border=\"0\" src=\"" . $out_p_foto . "\"/></a>" ; 
              }  
              else 
              { 
                  $conteudo = "<img border=\"0\" src=\"" . $this->NM_raiz_img . $out_p_foto . "\"/>" ; 
              }  
          }  
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['p_foto']) && $this->NM_cmp_hidden['p_foto'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf'])
          {
              $this->SC_nowrap = "NOWRAP";
          }
          else
          {
              $this->SC_nowrap = "NOWRAP";
          }
$nm_saida->saida("     <span id=\"id_sc_field_p_foto_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("   </tr><tr>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_p_nombre_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['p_nombre']) && $this->NM_cmp_hidden['p_nombre'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['p_nombre'])) ? $this->New_label['p_nombre'] : "Nombre";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_p_nombre_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_p_nombre_grid_line . "\"  style=\"" . $this->Css_Cmp['css_p_nombre_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = sc_strip_script($this->p_nombre); 
          $conteudo_original = sc_strip_script($this->p_nombre); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['p_nombre']) && $this->NM_cmp_hidden['p_nombre'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_p_nombre_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_g_genero_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['g_genero']) && $this->NM_cmp_hidden['g_genero'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['g_genero'])) ? $this->New_label['g_genero'] : "Género";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_g_genero_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_g_genero_grid_line . "\"  style=\"" . $this->Css_Cmp['css_g_genero_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = sc_strip_script($this->g_genero); 
          $conteudo_original = sc_strip_script($this->g_genero); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['g_genero']) && $this->NM_cmp_hidden['g_genero'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_g_genero_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("   </tr><tr>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_e_nombre_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['e_nombre']) && $this->NM_cmp_hidden['e_nombre'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['e_nombre'])) ? $this->New_label['e_nombre'] : "Étnia";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_e_nombre_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_e_nombre_grid_line . "\"  style=\"" . $this->Css_Cmp['css_e_nombre_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = sc_strip_script($this->e_nombre); 
          $conteudo_original = sc_strip_script($this->e_nombre); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['e_nombre']) && $this->NM_cmp_hidden['e_nombre'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_e_nombre_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_p_noidentificacion_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['p_noidentificacion']) && $this->NM_cmp_hidden['p_noidentificacion'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['p_noidentificacion'])) ? $this->New_label['p_noidentificacion'] : "No Identificación";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     \r\n");
   if (isset($this->NM_cmp_hidden['p_noidentificacion']) && $this->NM_cmp_hidden['p_noidentificacion'] == "off")
   {
   
$nm_saida->saida("&nbsp;\r\n");
   }
   else
   {
      if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf") 
      {
          $NM_cmp_class =  "p_noidentificacion";
      $link_img = "";
      $nome_img = $this->Ini->Label_sort;
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_cmp'] == $NM_cmp_class)
      {
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_desc'] == " desc")
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
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_p_noidentificacion_grid_line . "\"  style=\"" . $this->Css_Cmp['css_p_noidentificacion_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = sc_strip_script($this->p_noidentificacion); 
          $conteudo_original = sc_strip_script($this->p_noidentificacion); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['p_noidentificacion']) && $this->NM_cmp_hidden['p_noidentificacion'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_p_noidentificacion_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("   </tr><tr>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_p_fechadenacimiento_label . "\"  NOWRAP align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['p_fechadenacimiento']) && $this->NM_cmp_hidden['p_fechadenacimiento'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['p_fechadenacimiento'])) ? $this->New_label['p_fechadenacimiento'] : "Fecha De Nacimiento";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_p_fechadenacimiento_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_p_fechadenacimiento_grid_line . "\"  style=\"" . $this->Css_Cmp['css_p_fechadenacimiento_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = NM_encode_input(sc_strip_script($this->p_fechadenacimiento)); 
          $conteudo_original = NM_encode_input(sc_strip_script($this->p_fechadenacimiento)); 
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
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['p_fechadenacimiento']) && $this->NM_cmp_hidden['p_fechadenacimiento'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf'])
          {
              $this->SC_nowrap = "NOWRAP";
          }
          else
          {
              $this->SC_nowrap = "NOWRAP";
          }
$nm_saida->saida("     <span id=\"id_sc_field_p_fechadenacimiento_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_anios_label . "\"  NOWRAP align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['anios']) && $this->NM_cmp_hidden['anios'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['anios'])) ? $this->New_label['anios'] : "Años";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_anios_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_anios_grid_line . "\"  style=\"" . $this->Css_Cmp['css_anios_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = NM_encode_input(sc_strip_script($this->anios)); 
          $conteudo_original = NM_encode_input(sc_strip_script($this->anios)); 
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
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['anios']) && $this->NM_cmp_hidden['anios'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf'])
          {
              $this->SC_nowrap = "NOWRAP";
          }
          else
          {
              $this->SC_nowrap = "NOWRAP";
          }
$nm_saida->saida("     <span id=\"id_sc_field_anios_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("   </tr><tr>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_meses_label . "\"  NOWRAP align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['meses']) && $this->NM_cmp_hidden['meses'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['meses'])) ? $this->New_label['meses'] : "Meses";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_meses_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_meses_grid_line . "\"  style=\"" . $this->Css_Cmp['css_meses_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = NM_encode_input(sc_strip_script($this->meses)); 
          $conteudo_original = NM_encode_input(sc_strip_script($this->meses)); 
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
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['meses']) && $this->NM_cmp_hidden['meses'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf'])
          {
              $this->SC_nowrap = "NOWRAP";
          }
          else
          {
              $this->SC_nowrap = "NOWRAP";
          }
$nm_saida->saida("     <span id=\"id_sc_field_meses_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_getario_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['getario']) && $this->NM_cmp_hidden['getario'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['getario'])) ? $this->New_label['getario'] : "Getario";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_getario_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_getario_grid_line . "\"  style=\"" . $this->Css_Cmp['css_getario_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = sc_strip_script($this->getario); 
          $conteudo_original = sc_strip_script($this->getario); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['getario']) && $this->NM_cmp_hidden['getario'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_getario_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("   </tr><tr>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_ec_nombre_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['ec_nombre']) && $this->NM_cmp_hidden['ec_nombre'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['ec_nombre'])) ? $this->New_label['ec_nombre'] : "Estado Civil";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_ec_nombre_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_ec_nombre_grid_line . "\"  style=\"" . $this->Css_Cmp['css_ec_nombre_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = sc_strip_script($this->ec_nombre); 
          $conteudo_original = sc_strip_script($this->ec_nombre); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['ec_nombre']) && $this->NM_cmp_hidden['ec_nombre'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_ec_nombre_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_l_nombre_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['l_nombre']) && $this->NM_cmp_hidden['l_nombre'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['l_nombre'])) ? $this->New_label['l_nombre'] : "LGBT";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_l_nombre_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_l_nombre_grid_line . "\"  style=\"" . $this->Css_Cmp['css_l_nombre_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = sc_strip_script($this->l_nombre); 
          $conteudo_original = sc_strip_script($this->l_nombre); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['l_nombre']) && $this->NM_cmp_hidden['l_nombre'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_l_nombre_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("   </tr><tr>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_pa_nombre_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['pa_nombre']) && $this->NM_cmp_hidden['pa_nombre'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['pa_nombre'])) ? $this->New_label['pa_nombre'] : "País";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_pa_nombre_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_pa_nombre_grid_line . "\"  style=\"" . $this->Css_Cmp['css_pa_nombre_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = sc_strip_script($this->pa_nombre); 
          $conteudo_original = sc_strip_script($this->pa_nombre); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['pa_nombre']) && $this->NM_cmp_hidden['pa_nombre'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_pa_nombre_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_de_nombre_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['de_nombre']) && $this->NM_cmp_hidden['de_nombre'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['de_nombre'])) ? $this->New_label['de_nombre'] : "Departamento";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_de_nombre_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_de_nombre_grid_line . "\"  style=\"" . $this->Css_Cmp['css_de_nombre_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = sc_strip_script($this->de_nombre); 
          $conteudo_original = sc_strip_script($this->de_nombre); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['de_nombre']) && $this->NM_cmp_hidden['de_nombre'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_de_nombre_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("   </tr><tr>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_mu_nombre_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['mu_nombre']) && $this->NM_cmp_hidden['mu_nombre'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['mu_nombre'])) ? $this->New_label['mu_nombre'] : "Municipio";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_mu_nombre_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_mu_nombre_grid_line . "\"  style=\"" . $this->Css_Cmp['css_mu_nombre_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = sc_strip_script($this->mu_nombre); 
          $conteudo_original = sc_strip_script($this->mu_nombre); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['mu_nombre']) && $this->NM_cmp_hidden['mu_nombre'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_mu_nombre_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_c_nombre_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['c_nombre']) && $this->NM_cmp_hidden['c_nombre'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['c_nombre'])) ? $this->New_label['c_nombre'] : "Comunidad";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_c_nombre_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_c_nombre_grid_line . "\"  style=\"" . $this->Css_Cmp['css_c_nombre_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = sc_strip_script($this->c_nombre); 
          $conteudo_original = sc_strip_script($this->c_nombre); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['c_nombre']) && $this->NM_cmp_hidden['c_nombre'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_c_nombre_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("   </tr><tr>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_p_direccion_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['p_direccion']) && $this->NM_cmp_hidden['p_direccion'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['p_direccion'])) ? $this->New_label['p_direccion'] : "Direccion";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_p_direccion_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_p_direccion_grid_line . "\"  style=\"" . $this->Css_Cmp['css_p_direccion_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = sc_strip_script($this->p_direccion); 
          $conteudo_original = sc_strip_script($this->p_direccion); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['p_direccion']) && $this->NM_cmp_hidden['p_direccion'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_p_direccion_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_p_email_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['p_email']) && $this->NM_cmp_hidden['p_email'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['p_email'])) ? $this->New_label['p_email'] : "Email";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_p_email_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_p_email_grid_line . "\"  style=\"" . $this->Css_Cmp['css_p_email_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = sc_strip_script($this->p_email); 
          $conteudo_original = sc_strip_script($this->p_email); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['p_email']) && $this->NM_cmp_hidden['p_email'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_p_email_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("   </tr><tr>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_p_telefono_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['p_telefono']) && $this->NM_cmp_hidden['p_telefono'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['p_telefono'])) ? $this->New_label['p_telefono'] : "Teléfono";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_p_telefono_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_p_telefono_grid_line . "\"  style=\"" . $this->Css_Cmp['css_p_telefono_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = sc_strip_script($this->p_telefono); 
          $conteudo_original = sc_strip_script($this->p_telefono); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['p_telefono']) && $this->NM_cmp_hidden['p_telefono'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_p_telefono_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_p_cargo_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['p_cargo']) && $this->NM_cmp_hidden['p_cargo'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['p_cargo'])) ? $this->New_label['p_cargo'] : "Cargo";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_p_cargo_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_p_cargo_grid_line . "\"  style=\"" . $this->Css_Cmp['css_p_cargo_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = sc_strip_script($this->p_cargo); 
          $conteudo_original = sc_strip_script($this->p_cargo); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['p_cargo']) && $this->NM_cmp_hidden['p_cargo'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_p_cargo_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("   </tr><tr>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_p_institucion_label . "\"   align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['p_institucion']) && $this->NM_cmp_hidden['p_institucion'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['p_institucion'])) ? $this->New_label['p_institucion'] : "Institucion";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     <span style=\"" . $this->Css_Cmp['css_p_institucion_label'] . "\">" . nl2br($SC_Label) . "</span>\r\n");
   } 
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_p_institucion_grid_line . "\"  style=\"" . $this->Css_Cmp['css_p_institucion_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = sc_strip_script($this->p_institucion); 
          $conteudo_original = sc_strip_script($this->p_institucion); 
          if ($conteudo === "") 
          { 
              $conteudo = "&nbsp;" ;  
              $graf = "" ;  
          } 
          $str_tem_display = $conteudo;
          $classColFld = "";
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['p_institucion']) && $this->NM_cmp_hidden['p_institucion'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf'])
          {
              $this->SC_nowrap = "";
          }
          else
          {
              $this->SC_nowrap = "";
          }
$nm_saida->saida("     <span id=\"id_sc_field_p_institucion_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("     <TD class=\"" . $this->css_scGridLabelVert . $this->css_sep . $this->css_p_idpersona_label . "\"  NOWRAP align=\"\" valign=\"\" width=\"25%\" >\r\n");
   if (isset($this->NM_cmp_hidden['p_idpersona']) && $this->NM_cmp_hidden['p_idpersona'] == "off")
   {
       $SC_Label = "&nbsp;"; 
   }
   else
   {
       $SC_Label = (isset($this->New_label['p_idpersona'])) ? $this->New_label['p_idpersona'] : "";
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['exibe_titulos'] != "S")
   { 
   } 
   else 
   { 
$nm_saida->saida("     \r\n");
   if (isset($this->NM_cmp_hidden['p_idpersona']) && $this->NM_cmp_hidden['p_idpersona'] == "off")
   {
   
$nm_saida->saida("&nbsp;\r\n");
   }
   else
   {
      if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf") 
      {
          $NM_cmp_class =  "p_idpersona";
      $link_img = "";
      $nome_img = $this->Ini->Label_sort;
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_cmp'] == $NM_cmp_class)
      {
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ordem_desc'] == " desc")
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
$nm_saida->saida("     <TD class=\"" . $this->css_line_back . $this->css_sep . $this->css_p_idpersona_grid_line . "\"  style=\"" . $this->Css_Cmp['css_p_idpersona_grid_line'] . "\" " . $this->SC_nowrap . " align=\"\" valign=\"top\" width=\"25%\"  HEIGHT=\"0px\">\r\n");
          $conteudo = NM_encode_input(sc_strip_script($this->p_idpersona)); 
          $conteudo_original = NM_encode_input(sc_strip_script($this->p_idpersona)); 
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
          if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != 'print' && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != 'pdf') {
              $classColFld = " sc-col-fld sc-col-fld-" . $this->grid_fixed_column_no;
          }
          if (isset($this->NM_cmp_hidden['p_idpersona']) && $this->NM_cmp_hidden['p_idpersona'] == "off")
          {
              $conteudo = "&nbsp;";
          }
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf'])
          {
              $this->SC_nowrap = "NOWRAP";
          }
          else
          {
              $this->SC_nowrap = "NOWRAP";
          }
$nm_saida->saida("     <span id=\"id_sc_field_p_idpersona_" . $this->SC_seq_page . "\"><span >" . $conteudo . "</span></span>\r\n");
$nm_saida->saida("    </TD>\r\n");
$nm_saida->saida("   </tr></table></td>\r\n");
$nm_saida->saida("    </tr></table>\r\n");
 }
$nm_saida->saida("    </td></tr></table></td>\r\n");
          $this->rs_grid->MoveNext();
          $this->sc_proc_grid = false;
          $nm_quant_linhas++ ;
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] || $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] == "pdf" || $this->Ini->Apl_paginacao == "FULL")
          { 
              $nm_quant_linhas = 0; 
          } 
   }  
   $this->NM_Fecha_bloco("fim");
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'])
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
   if (!$this->rs_grid->EOF) 
   { 
       if (isset($this->NM_tbody_open) && $this->NM_tbody_open)
       {
           $nm_saida->saida("    </TBODY>");
       }
   } 
   if ($this->rs_grid->EOF) 
   { 
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Ind_Groupby'] == "sc_free_group_by")
       {
           $SC_lst_Gby = array();
           foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_cmp'] as $cmp => $sql)
           {
               $SC_lst_Gby[] = $cmp;
           }
           $this->Nivel_gbBot = count($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_cmp']);
           krsort ($SC_lst_Gby);
           foreach ($SC_lst_Gby as $Ind => $cmp)
           {
               if (in_array($cmp, $this->SC_bot))
               {
                   $tmp = "quebra_" . $cmp . "_sc_free_group_by_bot";
                   $this->$tmp($cmp);
                   $this->Nivel_gbBot--;
               }
           }
       }
  
       if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] || $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['exibe_total'] == "S")
       { 
           $Gb_geral = "quebra_geral_" . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Ind_Groupby'] . "_top";
           $this->$Gb_geral() ;
       } 
   }  
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida_grid'])
   {
       $nm_saida->saida("X##NM@@X");
   }
   $nm_saida->saida("</TABLE>");
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_psq'])
   { 
          $nm_saida->saida("       </form>\r\n");
   } 
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
   { 
       $this->Ini->Arr_result['setValue'][] = array('field' => 'sc_grid_body', 'value' => NM_charset_to_utf8($_SESSION['scriptcase']['saida_html']));
       $_SESSION['scriptcase']['saida_html'] = "";
   } 
   $nm_saida->saida("</TD>");
   $nm_saida->saida($fecha_tr);
   if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'])
   { 
       $_SESSION['scriptcase']['contr_link_emb'] = "";   
   } 
   if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf" && empty($this->nm_grid_sem_reg) && 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "print" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != "print") 
   { 
       $nm_saida->saida("</TABLE></TD>\r\n");
       $nm_saida->saida("<TD style=\"padding: 0px; border-width: 0px;\" valign=\"top\" width=1>\r\n");
      $nm_saida->saida("     <iframe class=\"css_iframes\" id=\"nmsc_iframe_liga_DL_grid_persona_enlaces\" marginWidth=\"0px\" marginHeight=\"0px\" frameborder=\"0\" valign=\"top\" height=\"0px\" width=\"0px\" name=\"nm_iframe_liga_DL_grid_persona_enlaces\" scrolling=\"auto\" src=\"NM_Blank_Page.htm\"></iframe>\r\n");
       $nm_saida->saida("</TD>\r\n");
           $nm_saida->saida("    <TD style=\"padding: 0px; border-width: 0px; vertical-align: top;\">\r\n");
           $nm_saida->saida("     <iframe class=\"css_iframes\" id=\"nmsc_iframe_liga_D_grid_persona_enlaces\" marginWidth=\"0px\" marginHeight=\"0px\" frameborder=\"0\" valign=\"top\" height=\"0px\" width=\"0px\" name=\"nm_iframe_liga_D_grid_persona_enlaces\" scrolling=\"auto\" src=\"NM_Blank_Page.htm\"></iframe>\r\n");
           $nm_saida->saida("    </TD>\r\n");
           $nm_saida->saida("    </TR>\r\n");
           $nm_saida->saida("    </TABLE>\r\n");
           $nm_saida->saida("    </TD>\r\n");
   } 
           $nm_saida->saida("    </TR>\r\n");
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'])
   {
       $nm_saida->saida("</TABLE>\r\n");
   }
   if ($this->Print_All) 
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao']       = "igual" ; 
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
            if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['print_navigator']) && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['print_navigator'] == "Netscape")
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
        if ($nm_parms != "resumo" && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'])
        {
           if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf']) { 
           }
           else
           {
               if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf_vert']) { 
                $nm_saida->saida("     <thead>\r\n");
               }
               $this->cabecalho();
               if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf_vert']) { 
                $nm_saida->saida("     </thead>\r\n");
               }
           }
        }
   $nm_saida->saida("    <TABLE align=\"center\" width=\"100%\" style=\"padding: 0px; border-spacing: 0px; border-width: 0px;\">\r\n");
   $nm_saida->saida("     <TR> \r\n");
    }
 }
 function quebra_pa_nombre_sc_free_group_by($Cmp_qb, $Where_qb, $Cmp_Name) 
 {
   $Var_name_gb  = "SC_tot_" . $Cmp_Name;
   $Cmps_Gb_Free = "campos_quebra_" . $Cmp_Name;
   $Desc_Gb_Ant  = $Cmp_Name . "_ant_desc";
   global $$Var_name_gb, $Desc_Gb_Ant;
   $this->sc_proc_quebra_de_nombre = false;
   $this->sc_proc_quebra_mu_nombre = false;
   $this->sc_proc_quebra_getario = false;
   $this->sc_proc_quebra_g_genero = false;
   $this->sc_proc_quebra_pa_nombre = true; 
   $this->Tot->quebra_pa_nombre_sc_free_group_by($Cmp_qb, $Where_qb, $Cmp_Name);
   $tot_pa_nombre = $$Var_name_gb;
   $conteudo = $tot_pa_nombre[0] ;  
   $this->count_pa_nombre = $tot_pa_nombre[1];
   $Temp_cmp_quebra = array(); 
   $conteudo = sc_strip_script($this->pa_nombre); 
   $Temp_cmp_quebra[0]['cmp'] = $conteudo; 
   if (isset($this->nmgp_label_quebras['pa_nombre']))
   {
       $Temp_cmp_quebra[0]['lab'] = $this->nmgp_label_quebras['pa_nombre']; 
   }
   else
   {
       $Temp_cmp_quebra[0]['lab'] = "País"; 
   }
   $this->$Cmps_Gb_Free = $Temp_cmp_quebra;
   $this->sc_proc_quebra_pa_nombre = false; 
 } 
 function quebra_de_nombre_sc_free_group_by($Cmp_qb, $Where_qb, $Cmp_Name) 
 {
   $Var_name_gb  = "SC_tot_" . $Cmp_Name;
   $Cmps_Gb_Free = "campos_quebra_" . $Cmp_Name;
   $Desc_Gb_Ant  = $Cmp_Name . "_ant_desc";
   global $$Var_name_gb, $Desc_Gb_Ant;
   $this->sc_proc_quebra_pa_nombre = false;
   $this->sc_proc_quebra_mu_nombre = false;
   $this->sc_proc_quebra_getario = false;
   $this->sc_proc_quebra_g_genero = false;
   $this->sc_proc_quebra_de_nombre = true; 
   $this->Tot->quebra_de_nombre_sc_free_group_by($Cmp_qb, $Where_qb, $Cmp_Name);
   $tot_de_nombre = $$Var_name_gb;
   $conteudo = $tot_de_nombre[0] ;  
   $this->count_de_nombre = $tot_de_nombre[1];
   $Temp_cmp_quebra = array(); 
   $conteudo = sc_strip_script($this->de_nombre); 
   $Temp_cmp_quebra[0]['cmp'] = $conteudo; 
   if (isset($this->nmgp_label_quebras['de_nombre']))
   {
       $Temp_cmp_quebra[0]['lab'] = $this->nmgp_label_quebras['de_nombre']; 
   }
   else
   {
       $Temp_cmp_quebra[0]['lab'] = "Departamento"; 
   }
   $this->$Cmps_Gb_Free = $Temp_cmp_quebra;
   $this->sc_proc_quebra_de_nombre = false; 
 } 
 function quebra_mu_nombre_sc_free_group_by($Cmp_qb, $Where_qb, $Cmp_Name) 
 {
   $Var_name_gb  = "SC_tot_" . $Cmp_Name;
   $Cmps_Gb_Free = "campos_quebra_" . $Cmp_Name;
   $Desc_Gb_Ant  = $Cmp_Name . "_ant_desc";
   global $$Var_name_gb, $Desc_Gb_Ant;
   $this->sc_proc_quebra_pa_nombre = false;
   $this->sc_proc_quebra_de_nombre = false;
   $this->sc_proc_quebra_getario = false;
   $this->sc_proc_quebra_g_genero = false;
   $this->sc_proc_quebra_mu_nombre = true; 
   $this->Tot->quebra_mu_nombre_sc_free_group_by($Cmp_qb, $Where_qb, $Cmp_Name);
   $tot_mu_nombre = $$Var_name_gb;
   $conteudo = $tot_mu_nombre[0] ;  
   $this->count_mu_nombre = $tot_mu_nombre[1];
   $Temp_cmp_quebra = array(); 
   $conteudo = sc_strip_script($this->mu_nombre); 
   $Temp_cmp_quebra[0]['cmp'] = $conteudo; 
   if (isset($this->nmgp_label_quebras['mu_nombre']))
   {
       $Temp_cmp_quebra[0]['lab'] = $this->nmgp_label_quebras['mu_nombre']; 
   }
   else
   {
       $Temp_cmp_quebra[0]['lab'] = "Municipio"; 
   }
   $this->$Cmps_Gb_Free = $Temp_cmp_quebra;
   $this->sc_proc_quebra_mu_nombre = false; 
 } 
 function quebra_getario_sc_free_group_by($Cmp_qb, $Where_qb, $Cmp_Name) 
 {
   $Var_name_gb  = "SC_tot_" . $Cmp_Name;
   $Cmps_Gb_Free = "campos_quebra_" . $Cmp_Name;
   $Desc_Gb_Ant  = $Cmp_Name . "_ant_desc";
   global $$Var_name_gb, $Desc_Gb_Ant;
   $this->sc_proc_quebra_pa_nombre = false;
   $this->sc_proc_quebra_de_nombre = false;
   $this->sc_proc_quebra_mu_nombre = false;
   $this->sc_proc_quebra_g_genero = false;
   $this->sc_proc_quebra_getario = true; 
   $this->Tot->quebra_getario_sc_free_group_by($Cmp_qb, $Where_qb, $Cmp_Name);
   $tot_getario = $$Var_name_gb;
   $conteudo = $tot_getario[0] ;  
   $this->count_getario = $tot_getario[1];
   $Temp_cmp_quebra = array(); 
   $conteudo = sc_strip_script($this->getario); 
   $Temp_cmp_quebra[0]['cmp'] = $conteudo; 
   if (isset($this->nmgp_label_quebras['getario']))
   {
       $Temp_cmp_quebra[0]['lab'] = $this->nmgp_label_quebras['getario']; 
   }
   else
   {
       $Temp_cmp_quebra[0]['lab'] = "Getario"; 
   }
   $this->$Cmps_Gb_Free = $Temp_cmp_quebra;
   $this->sc_proc_quebra_getario = false; 
 } 
 function quebra_g_genero_sc_free_group_by($Cmp_qb, $Where_qb, $Cmp_Name) 
 {
   $Var_name_gb  = "SC_tot_" . $Cmp_Name;
   $Cmps_Gb_Free = "campos_quebra_" . $Cmp_Name;
   $Desc_Gb_Ant  = $Cmp_Name . "_ant_desc";
   global $$Var_name_gb, $Desc_Gb_Ant;
   $this->sc_proc_quebra_pa_nombre = false;
   $this->sc_proc_quebra_de_nombre = false;
   $this->sc_proc_quebra_mu_nombre = false;
   $this->sc_proc_quebra_getario = false;
   $this->sc_proc_quebra_g_genero = true; 
   $this->Tot->quebra_g_genero_sc_free_group_by($Cmp_qb, $Where_qb, $Cmp_Name);
   $tot_g_genero = $$Var_name_gb;
   $conteudo = $tot_g_genero[0] ;  
   $this->count_g_genero = $tot_g_genero[1];
   $Temp_cmp_quebra = array(); 
   $conteudo = sc_strip_script($this->g_genero); 
   $Temp_cmp_quebra[0]['cmp'] = $conteudo; 
   if (isset($this->nmgp_label_quebras['g_genero']))
   {
       $Temp_cmp_quebra[0]['lab'] = $this->nmgp_label_quebras['g_genero']; 
   }
   else
   {
       $Temp_cmp_quebra[0]['lab'] = "Género"; 
   }
   $this->$Cmps_Gb_Free = $Temp_cmp_quebra;
   $this->sc_proc_quebra_g_genero = false; 
 } 
 function quebra_pa_nombre_sc_free_group_by_top($Cmp_Name) 
 {
   $Var_name_gb  = "SC_tot_" . $Cmp_Name;
   $Cmps_Gb_Free = "campos_quebra_" . $Cmp_Name;
   $Desc_Gb_Ant  = $Cmp_Name . "_ant_desc";
   global
          $Desc_Gb_Ant, 
          $nm_saida, $$Var_name_gb;
   $tot_pa_nombre = $$Var_name_gb;
   $this->SC_tab_quebra = (count($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_cmp']) > 1) ? 10 * $this->Tab_Nv_tree['pa_nombre'] : 0;
   $Desc_Gb_Ant = $this->$Cmps_Gb_Free[0]['cmp'];
   static $cont_quebra_pa_nombre = 0; 
   $cont_quebra_pa_nombre++;
   $nm_nivel_book_pdf = "";
   $nm_fecha_pdf_old = "";
   $nm_fecha_pdf_new = "";
   $this->NM_Fecha_bloco();
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['rows_emb']++;
   $link_div   = "";
   $link_div_2 = "";
   if ('' != $this->Ini->Tree_img_col && '' != $this->Ini->Tree_img_exp && !$this->Ini->Proc_print && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf" && !$this->NM_emb_tree_no)
   {
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ind_tree']++;
       $this->NM_cont_body = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ind_tree'];
       $link_div  = "<table style=\"border-collapse: collapse\"><tr>";
       if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida_grid']) {
          $link_div .= "<td class=\"" . $this->css_scGridBlockLineBg . "\" style=\"width: " . $this->SC_tab_quebra . "px;\">&nbsp;</td>"; 
       }
       $link_div .= "<td style=\"padding: 0px\"><span align=\"left\">";
       $link_div .= "<img id=\"b_open_grid_persona_enlaces_" . $this->NM_cont_body . "\" style=\"display:none\" onclick=\"document.getElementById('b_open_grid_persona_enlaces_" . $this->NM_cont_body . "').style.display = 'none'; document.getElementById('b_close_grid_persona_enlaces_" . $this->NM_cont_body . "').style.display = ''; NM_liga_tbody(" . $this->NM_cont_body . ", NM_tab_grid_persona_enlaces, 'grid_persona_enlaces'); return false;\" src=\"" . $this->Ini->path_img_global . "/" . $this->Ini->Tree_img_exp . "\">";
       $link_div .= "<img id=\"b_close_grid_persona_enlaces_" . $this->NM_cont_body . "\" style=\"display:''\" onclick=\"document.getElementById('b_close_grid_persona_enlaces_" . $this->NM_cont_body . "').style.display = 'none'; document.getElementById('b_open_grid_persona_enlaces_" . $this->NM_cont_body . "').style.display = ''; NM_apaga_tbody(" . $this->NM_cont_body . ", NM_tab_grid_persona_enlaces, 'grid_persona_enlaces'); return false;\" src=\"" . $this->Ini->path_img_global . "/" . $this->Ini->Tree_img_col . "\">";
       $link_div .= "</span></td><td  class=\"scGridBlockFont\">";
       $link_div_2 = "</td></tr></table>";
       if (isset($this->NM_tbody_open) && $this->NM_tbody_open)
       {
           $this->NM_tbody_open = false;
           $nm_saida->saida("    </TBODY>");
       }
       $_SESSION['sc_session'][$this->Ini->sc_page]['NM_arr_tree']['grid_persona_enlaces'][$this->NM_cont_body][$this->Tab_Nv_tree['pa_nombre']] = 'top';
       $nm_saida->saida("    <TBODY id=\"tbody_grid_persona_enlaces_" . $this->NM_cont_body . "_top\" style=\"display:''\">");
   }
   $nm_nivel_book_pdf = "";
   $nm_fecha_pdf_new  = "";
   if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] == "pdf" && !$this->Print_All)
   {
       $nm_nivel_book_pdf = "<div style=\"height:1px;overflow:hidden\"><H2 style=\"font-size:0;padding:1px\">" .  $this->$Cmps_Gb_Free[0]['cmp'] ;
       $nm_fecha_pdf_new = "</H2></div>";
   }
   $conteudo = $tot_pa_nombre[0] ;  
   $this->Label_pa_nombre = "<table>"; 
   $Cmps_gb = $this->$Cmps_Gb_Free;
   foreach ($Cmps_gb as $cada_campo) 
   { 
       $this->Label_pa_nombre .= "<tr>"; 
       $this->Label_pa_nombre .= "<td>" . $cada_campo['lab'] . "</td><td> => </td>";
       $this->Label_pa_nombre .= "<td>" . $cada_campo['cmp'] . "</td>";
       $this->Label_pa_nombre .= "</tr>"; 
   } 
   $this->Label_pa_nombre .= "</table>"; 
   $nm_saida->saida("    <TR >\r\n");
   $nm_saida->saida("     <TD class=\"" . $this->css_scGridBlock . "\" style=\"text-align:left;\"  style=\"text-align: left;\"  " . "colspan=\"" . ($this->nm_grid_slides_linha + 1) . "\"" . " align=\"\">\r\n");
   $nm_saida->saida("       " . $link_div . "\r\n");
   $nm_saida->saida("        " . $nm_nivel_book_pdf . $nm_fecha_pdf_new  . $this->Label_pa_nombre . $nm_fecha_pdf_old . "\r\n");
   $nm_saida->saida("       " . $link_div_2 . "\r\n");
   $nm_saida->saida("     </TD>\r\n");
   $nm_saida->saida("    </TR>\r\n");
   if ('' != $this->Ini->Tree_img_col && '' != $this->Ini->Tree_img_exp && !$this->Ini->Proc_print && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf" && !$this->NM_emb_tree_no)
   {
       $nm_saida->saida("    </TBODY>");
       if ($this->Ult_qb_free == $this->Tab_Nv_tree['pa_nombre'])
       {
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ind_tree']++;
           $this->NM_cont_body = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ind_tree'];
           $_SESSION['sc_session'][$this->Ini->sc_page]['NM_arr_tree']['grid_persona_enlaces'][$this->NM_cont_body][$this->Tab_Nv_tree['pa_nombre']] = 'bot';
           $nm_saida->saida("    <TBODY id=\"tbody_grid_persona_enlaces_" . $this->NM_cont_body . "_bot\" style=\"display:''\">");
           $this->NM_tbody_open = true;
       }
   }
 } 
 function quebra_de_nombre_sc_free_group_by_top($Cmp_Name) 
 {
   $Var_name_gb  = "SC_tot_" . $Cmp_Name;
   $Cmps_Gb_Free = "campos_quebra_" . $Cmp_Name;
   $Desc_Gb_Ant  = $Cmp_Name . "_ant_desc";
   global
          $Desc_Gb_Ant, 
          $nm_saida, $$Var_name_gb;
   $tot_de_nombre = $$Var_name_gb;
   $this->SC_tab_quebra = (count($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_cmp']) > 1) ? 10 * $this->Tab_Nv_tree['de_nombre'] : 0;
   $Desc_Gb_Ant = $this->$Cmps_Gb_Free[0]['cmp'];
   static $cont_quebra_de_nombre = 0; 
   $cont_quebra_de_nombre++;
   $nm_nivel_book_pdf = "";
   $nm_fecha_pdf_old = "";
   $nm_fecha_pdf_new = "";
   $this->NM_Fecha_bloco();
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['rows_emb']++;
   $link_div   = "";
   $link_div_2 = "";
   if ('' != $this->Ini->Tree_img_col && '' != $this->Ini->Tree_img_exp && !$this->Ini->Proc_print && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf" && !$this->NM_emb_tree_no)
   {
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ind_tree']++;
       $this->NM_cont_body = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ind_tree'];
       $link_div  = "<table style=\"border-collapse: collapse\"><tr>";
       if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida_grid']) {
          $link_div .= "<td class=\"" . $this->css_scGridBlockLineBg . "\" style=\"width: " . $this->SC_tab_quebra . "px;\">&nbsp;</td>"; 
       }
       $link_div .= "<td style=\"padding: 0px\"><span align=\"left\">";
       $link_div .= "<img id=\"b_open_grid_persona_enlaces_" . $this->NM_cont_body . "\" style=\"display:none\" onclick=\"document.getElementById('b_open_grid_persona_enlaces_" . $this->NM_cont_body . "').style.display = 'none'; document.getElementById('b_close_grid_persona_enlaces_" . $this->NM_cont_body . "').style.display = ''; NM_liga_tbody(" . $this->NM_cont_body . ", NM_tab_grid_persona_enlaces, 'grid_persona_enlaces'); return false;\" src=\"" . $this->Ini->path_img_global . "/" . $this->Ini->Tree_img_exp . "\">";
       $link_div .= "<img id=\"b_close_grid_persona_enlaces_" . $this->NM_cont_body . "\" style=\"display:''\" onclick=\"document.getElementById('b_close_grid_persona_enlaces_" . $this->NM_cont_body . "').style.display = 'none'; document.getElementById('b_open_grid_persona_enlaces_" . $this->NM_cont_body . "').style.display = ''; NM_apaga_tbody(" . $this->NM_cont_body . ", NM_tab_grid_persona_enlaces, 'grid_persona_enlaces'); return false;\" src=\"" . $this->Ini->path_img_global . "/" . $this->Ini->Tree_img_col . "\">";
       $link_div .= "</span></td><td  class=\"scGridBlockFont\">";
       $link_div_2 = "</td></tr></table>";
       if (isset($this->NM_tbody_open) && $this->NM_tbody_open)
       {
           $this->NM_tbody_open = false;
           $nm_saida->saida("    </TBODY>");
       }
       $_SESSION['sc_session'][$this->Ini->sc_page]['NM_arr_tree']['grid_persona_enlaces'][$this->NM_cont_body][$this->Tab_Nv_tree['de_nombre']] = 'top';
       $nm_saida->saida("    <TBODY id=\"tbody_grid_persona_enlaces_" . $this->NM_cont_body . "_top\" style=\"display:''\">");
   }
   $nm_nivel_book_pdf = "";
   $nm_fecha_pdf_new  = "";
   if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] == "pdf" && !$this->Print_All)
   {
       $nm_nivel_book_pdf = "<div style=\"height:1px;overflow:hidden\"><H3 style=\"font-size:0;padding:1px\">" .  $this->$Cmps_Gb_Free[0]['cmp'] ;
       $nm_fecha_pdf_new = "</H3></div>";
   }
   $conteudo = $tot_de_nombre[0] ;  
   $this->Label_de_nombre = "<table>"; 
   $Cmps_gb = $this->$Cmps_Gb_Free;
   foreach ($Cmps_gb as $cada_campo) 
   { 
       $this->Label_de_nombre .= "<tr>"; 
       $this->Label_de_nombre .= "<td>" . $cada_campo['lab'] . "</td><td> => </td>";
       $this->Label_de_nombre .= "<td>" . $cada_campo['cmp'] . "</td>";
       $this->Label_de_nombre .= "</tr>"; 
   } 
   $this->Label_de_nombre .= "</table>"; 
   $nm_saida->saida("    <TR >\r\n");
   $nm_saida->saida("     <TD class=\"" . $this->css_scGridBlock . "\" style=\"text-align:left;\"  style=\"text-align: left;\"  " . "colspan=\"" . ($this->nm_grid_slides_linha + 1) . "\"" . " align=\"\">\r\n");
   $nm_saida->saida("       " . $link_div . "\r\n");
   $nm_saida->saida("        " . $nm_nivel_book_pdf . $nm_fecha_pdf_new  . $this->Label_de_nombre . $nm_fecha_pdf_old . "\r\n");
   $nm_saida->saida("       " . $link_div_2 . "\r\n");
   $nm_saida->saida("     </TD>\r\n");
   $nm_saida->saida("    </TR>\r\n");
   if ('' != $this->Ini->Tree_img_col && '' != $this->Ini->Tree_img_exp && !$this->Ini->Proc_print && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf" && !$this->NM_emb_tree_no)
   {
       $nm_saida->saida("    </TBODY>");
       if ($this->Ult_qb_free == $this->Tab_Nv_tree['de_nombre'])
       {
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ind_tree']++;
           $this->NM_cont_body = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ind_tree'];
           $_SESSION['sc_session'][$this->Ini->sc_page]['NM_arr_tree']['grid_persona_enlaces'][$this->NM_cont_body][$this->Tab_Nv_tree['de_nombre']] = 'bot';
           $nm_saida->saida("    <TBODY id=\"tbody_grid_persona_enlaces_" . $this->NM_cont_body . "_bot\" style=\"display:''\">");
           $this->NM_tbody_open = true;
       }
   }
 } 
 function quebra_mu_nombre_sc_free_group_by_top($Cmp_Name) 
 {
   $Var_name_gb  = "SC_tot_" . $Cmp_Name;
   $Cmps_Gb_Free = "campos_quebra_" . $Cmp_Name;
   $Desc_Gb_Ant  = $Cmp_Name . "_ant_desc";
   global
          $Desc_Gb_Ant, 
          $nm_saida, $$Var_name_gb;
   $tot_mu_nombre = $$Var_name_gb;
   $this->SC_tab_quebra = (count($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_cmp']) > 1) ? 10 * $this->Tab_Nv_tree['mu_nombre'] : 0;
   $Desc_Gb_Ant = $this->$Cmps_Gb_Free[0]['cmp'];
   static $cont_quebra_mu_nombre = 0; 
   $cont_quebra_mu_nombre++;
   $nm_nivel_book_pdf = "";
   $nm_fecha_pdf_old = "";
   $nm_fecha_pdf_new = "";
   $this->NM_Fecha_bloco();
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['rows_emb']++;
   $link_div   = "";
   $link_div_2 = "";
   if ('' != $this->Ini->Tree_img_col && '' != $this->Ini->Tree_img_exp && !$this->Ini->Proc_print && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf" && !$this->NM_emb_tree_no)
   {
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ind_tree']++;
       $this->NM_cont_body = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ind_tree'];
       $link_div  = "<table style=\"border-collapse: collapse\"><tr>";
       if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida_grid']) {
          $link_div .= "<td class=\"" . $this->css_scGridBlockLineBg . "\" style=\"width: " . $this->SC_tab_quebra . "px;\">&nbsp;</td>"; 
       }
       $link_div .= "<td style=\"padding: 0px\"><span align=\"left\">";
       $link_div .= "<img id=\"b_open_grid_persona_enlaces_" . $this->NM_cont_body . "\" style=\"display:none\" onclick=\"document.getElementById('b_open_grid_persona_enlaces_" . $this->NM_cont_body . "').style.display = 'none'; document.getElementById('b_close_grid_persona_enlaces_" . $this->NM_cont_body . "').style.display = ''; NM_liga_tbody(" . $this->NM_cont_body . ", NM_tab_grid_persona_enlaces, 'grid_persona_enlaces'); return false;\" src=\"" . $this->Ini->path_img_global . "/" . $this->Ini->Tree_img_exp . "\">";
       $link_div .= "<img id=\"b_close_grid_persona_enlaces_" . $this->NM_cont_body . "\" style=\"display:''\" onclick=\"document.getElementById('b_close_grid_persona_enlaces_" . $this->NM_cont_body . "').style.display = 'none'; document.getElementById('b_open_grid_persona_enlaces_" . $this->NM_cont_body . "').style.display = ''; NM_apaga_tbody(" . $this->NM_cont_body . ", NM_tab_grid_persona_enlaces, 'grid_persona_enlaces'); return false;\" src=\"" . $this->Ini->path_img_global . "/" . $this->Ini->Tree_img_col . "\">";
       $link_div .= "</span></td><td  class=\"scGridBlockFont\">";
       $link_div_2 = "</td></tr></table>";
       if (isset($this->NM_tbody_open) && $this->NM_tbody_open)
       {
           $this->NM_tbody_open = false;
           $nm_saida->saida("    </TBODY>");
       }
       $_SESSION['sc_session'][$this->Ini->sc_page]['NM_arr_tree']['grid_persona_enlaces'][$this->NM_cont_body][$this->Tab_Nv_tree['mu_nombre']] = 'top';
       $nm_saida->saida("    <TBODY id=\"tbody_grid_persona_enlaces_" . $this->NM_cont_body . "_top\" style=\"display:''\">");
   }
   $nm_nivel_book_pdf = "";
   $nm_fecha_pdf_new  = "";
   if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] == "pdf" && !$this->Print_All)
   {
       $nm_nivel_book_pdf = "<div style=\"height:1px;overflow:hidden\"><H4 style=\"font-size:0;padding:1px\">" .  $this->$Cmps_Gb_Free[0]['cmp'] ;
       $nm_fecha_pdf_new = "</H4></div>";
   }
   $conteudo = $tot_mu_nombre[0] ;  
   $this->Label_mu_nombre = "<table>"; 
   $Cmps_gb = $this->$Cmps_Gb_Free;
   foreach ($Cmps_gb as $cada_campo) 
   { 
       $this->Label_mu_nombre .= "<tr>"; 
       $this->Label_mu_nombre .= "<td>" . $cada_campo['lab'] . "</td><td> => </td>";
       $this->Label_mu_nombre .= "<td>" . $cada_campo['cmp'] . "</td>";
       $this->Label_mu_nombre .= "</tr>"; 
   } 
   $this->Label_mu_nombre .= "</table>"; 
   $nm_saida->saida("    <TR >\r\n");
   $nm_saida->saida("     <TD class=\"" . $this->css_scGridBlock . "\" style=\"text-align:left;\"  style=\"text-align: left;\"  " . "colspan=\"" . ($this->nm_grid_slides_linha + 1) . "\"" . " align=\"\">\r\n");
   $nm_saida->saida("       " . $link_div . "\r\n");
   $nm_saida->saida("        " . $nm_nivel_book_pdf . $nm_fecha_pdf_new  . $this->Label_mu_nombre . $nm_fecha_pdf_old . "\r\n");
   $nm_saida->saida("       " . $link_div_2 . "\r\n");
   $nm_saida->saida("     </TD>\r\n");
   $nm_saida->saida("    </TR>\r\n");
   if ('' != $this->Ini->Tree_img_col && '' != $this->Ini->Tree_img_exp && !$this->Ini->Proc_print && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf" && !$this->NM_emb_tree_no)
   {
       $nm_saida->saida("    </TBODY>");
       if ($this->Ult_qb_free == $this->Tab_Nv_tree['mu_nombre'])
       {
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ind_tree']++;
           $this->NM_cont_body = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ind_tree'];
           $_SESSION['sc_session'][$this->Ini->sc_page]['NM_arr_tree']['grid_persona_enlaces'][$this->NM_cont_body][$this->Tab_Nv_tree['mu_nombre']] = 'bot';
           $nm_saida->saida("    <TBODY id=\"tbody_grid_persona_enlaces_" . $this->NM_cont_body . "_bot\" style=\"display:''\">");
           $this->NM_tbody_open = true;
       }
   }
 } 
 function quebra_getario_sc_free_group_by_top($Cmp_Name) 
 {
   $Var_name_gb  = "SC_tot_" . $Cmp_Name;
   $Cmps_Gb_Free = "campos_quebra_" . $Cmp_Name;
   $Desc_Gb_Ant  = $Cmp_Name . "_ant_desc";
   global
          $Desc_Gb_Ant, 
          $nm_saida, $$Var_name_gb;
   $tot_getario = $$Var_name_gb;
   $this->SC_tab_quebra = (count($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_cmp']) > 1) ? 10 * $this->Tab_Nv_tree['getario'] : 0;
   $Desc_Gb_Ant = $this->$Cmps_Gb_Free[0]['cmp'];
   static $cont_quebra_getario = 0; 
   $cont_quebra_getario++;
   $nm_nivel_book_pdf = "";
   $nm_fecha_pdf_old = "";
   $nm_fecha_pdf_new = "";
   $this->NM_Fecha_bloco();
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['rows_emb']++;
   $link_div   = "";
   $link_div_2 = "";
   if ('' != $this->Ini->Tree_img_col && '' != $this->Ini->Tree_img_exp && !$this->Ini->Proc_print && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf" && !$this->NM_emb_tree_no)
   {
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ind_tree']++;
       $this->NM_cont_body = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ind_tree'];
       $link_div  = "<table style=\"border-collapse: collapse\"><tr>";
       if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida_grid']) {
          $link_div .= "<td class=\"" . $this->css_scGridBlockLineBg . "\" style=\"width: " . $this->SC_tab_quebra . "px;\">&nbsp;</td>"; 
       }
       $link_div .= "<td style=\"padding: 0px\"><span align=\"left\">";
       $link_div .= "<img id=\"b_open_grid_persona_enlaces_" . $this->NM_cont_body . "\" style=\"display:none\" onclick=\"document.getElementById('b_open_grid_persona_enlaces_" . $this->NM_cont_body . "').style.display = 'none'; document.getElementById('b_close_grid_persona_enlaces_" . $this->NM_cont_body . "').style.display = ''; NM_liga_tbody(" . $this->NM_cont_body . ", NM_tab_grid_persona_enlaces, 'grid_persona_enlaces'); return false;\" src=\"" . $this->Ini->path_img_global . "/" . $this->Ini->Tree_img_exp . "\">";
       $link_div .= "<img id=\"b_close_grid_persona_enlaces_" . $this->NM_cont_body . "\" style=\"display:''\" onclick=\"document.getElementById('b_close_grid_persona_enlaces_" . $this->NM_cont_body . "').style.display = 'none'; document.getElementById('b_open_grid_persona_enlaces_" . $this->NM_cont_body . "').style.display = ''; NM_apaga_tbody(" . $this->NM_cont_body . ", NM_tab_grid_persona_enlaces, 'grid_persona_enlaces'); return false;\" src=\"" . $this->Ini->path_img_global . "/" . $this->Ini->Tree_img_col . "\">";
       $link_div .= "</span></td><td  class=\"scGridBlockFont\">";
       $link_div_2 = "</td></tr></table>";
       if (isset($this->NM_tbody_open) && $this->NM_tbody_open)
       {
           $this->NM_tbody_open = false;
           $nm_saida->saida("    </TBODY>");
       }
       $_SESSION['sc_session'][$this->Ini->sc_page]['NM_arr_tree']['grid_persona_enlaces'][$this->NM_cont_body][$this->Tab_Nv_tree['getario']] = 'top';
       $nm_saida->saida("    <TBODY id=\"tbody_grid_persona_enlaces_" . $this->NM_cont_body . "_top\" style=\"display:''\">");
   }
   $nm_nivel_book_pdf = "";
   $nm_fecha_pdf_new  = "";
   if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] == "pdf" && !$this->Print_All)
   {
       $nm_nivel_book_pdf = "<div style=\"height:1px;overflow:hidden\"><H5 style=\"font-size:0;padding:1px\">" .  $this->$Cmps_Gb_Free[0]['cmp'] ;
       $nm_fecha_pdf_new = "</H5></div>";
   }
   $conteudo = $tot_getario[0] ;  
   $this->Label_getario = "<table>"; 
   $Cmps_gb = $this->$Cmps_Gb_Free;
   foreach ($Cmps_gb as $cada_campo) 
   { 
       $this->Label_getario .= "<tr>"; 
       $this->Label_getario .= "<td>" . $cada_campo['lab'] . "</td><td> => </td>";
       $this->Label_getario .= "<td>" . $cada_campo['cmp'] . "</td>";
       $this->Label_getario .= "</tr>"; 
   } 
   $this->Label_getario .= "</table>"; 
   $nm_saida->saida("    <TR >\r\n");
   $nm_saida->saida("     <TD class=\"" . $this->css_scGridBlock . "\" style=\"text-align:left;\"  style=\"text-align: left;\"  " . "colspan=\"" . ($this->nm_grid_slides_linha + 1) . "\"" . " align=\"\">\r\n");
   $nm_saida->saida("       " . $link_div . "\r\n");
   $nm_saida->saida("        " . $nm_nivel_book_pdf . $nm_fecha_pdf_new  . $this->Label_getario . $nm_fecha_pdf_old . "\r\n");
   $nm_saida->saida("       " . $link_div_2 . "\r\n");
   $nm_saida->saida("     </TD>\r\n");
   $nm_saida->saida("    </TR>\r\n");
   if ('' != $this->Ini->Tree_img_col && '' != $this->Ini->Tree_img_exp && !$this->Ini->Proc_print && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf" && !$this->NM_emb_tree_no)
   {
       $nm_saida->saida("    </TBODY>");
       if ($this->Ult_qb_free == $this->Tab_Nv_tree['getario'])
       {
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ind_tree']++;
           $this->NM_cont_body = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ind_tree'];
           $_SESSION['sc_session'][$this->Ini->sc_page]['NM_arr_tree']['grid_persona_enlaces'][$this->NM_cont_body][$this->Tab_Nv_tree['getario']] = 'bot';
           $nm_saida->saida("    <TBODY id=\"tbody_grid_persona_enlaces_" . $this->NM_cont_body . "_bot\" style=\"display:''\">");
           $this->NM_tbody_open = true;
       }
   }
 } 
 function quebra_g_genero_sc_free_group_by_top($Cmp_Name) 
 {
   $Var_name_gb  = "SC_tot_" . $Cmp_Name;
   $Cmps_Gb_Free = "campos_quebra_" . $Cmp_Name;
   $Desc_Gb_Ant  = $Cmp_Name . "_ant_desc";
   global
          $Desc_Gb_Ant, 
          $nm_saida, $$Var_name_gb;
   $tot_g_genero = $$Var_name_gb;
   $this->SC_tab_quebra = (count($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_cmp']) > 1) ? 10 * $this->Tab_Nv_tree['g_genero'] : 0;
   $Desc_Gb_Ant = $this->$Cmps_Gb_Free[0]['cmp'];
   static $cont_quebra_g_genero = 0; 
   $cont_quebra_g_genero++;
   $nm_nivel_book_pdf = "";
   $nm_fecha_pdf_old = "";
   $nm_fecha_pdf_new = "";
   $this->NM_Fecha_bloco();
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['rows_emb']++;
   $link_div   = "";
   $link_div_2 = "";
   if ('' != $this->Ini->Tree_img_col && '' != $this->Ini->Tree_img_exp && !$this->Ini->Proc_print && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf" && !$this->NM_emb_tree_no)
   {
       $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ind_tree']++;
       $this->NM_cont_body = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ind_tree'];
       $link_div  = "<table style=\"border-collapse: collapse\"><tr>";
       if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida_grid']) {
          $link_div .= "<td class=\"" . $this->css_scGridBlockLineBg . "\" style=\"width: " . $this->SC_tab_quebra . "px;\">&nbsp;</td>"; 
       }
       $link_div .= "<td style=\"padding: 0px\"><span align=\"left\">";
       $link_div .= "<img id=\"b_open_grid_persona_enlaces_" . $this->NM_cont_body . "\" style=\"display:none\" onclick=\"document.getElementById('b_open_grid_persona_enlaces_" . $this->NM_cont_body . "').style.display = 'none'; document.getElementById('b_close_grid_persona_enlaces_" . $this->NM_cont_body . "').style.display = ''; NM_liga_tbody(" . $this->NM_cont_body . ", NM_tab_grid_persona_enlaces, 'grid_persona_enlaces'); return false;\" src=\"" . $this->Ini->path_img_global . "/" . $this->Ini->Tree_img_exp . "\">";
       $link_div .= "<img id=\"b_close_grid_persona_enlaces_" . $this->NM_cont_body . "\" style=\"display:''\" onclick=\"document.getElementById('b_close_grid_persona_enlaces_" . $this->NM_cont_body . "').style.display = 'none'; document.getElementById('b_open_grid_persona_enlaces_" . $this->NM_cont_body . "').style.display = ''; NM_apaga_tbody(" . $this->NM_cont_body . ", NM_tab_grid_persona_enlaces, 'grid_persona_enlaces'); return false;\" src=\"" . $this->Ini->path_img_global . "/" . $this->Ini->Tree_img_col . "\">";
       $link_div .= "</span></td><td  class=\"scGridBlockFont\">";
       $link_div_2 = "</td></tr></table>";
       if (isset($this->NM_tbody_open) && $this->NM_tbody_open)
       {
           $this->NM_tbody_open = false;
           $nm_saida->saida("    </TBODY>");
       }
       $_SESSION['sc_session'][$this->Ini->sc_page]['NM_arr_tree']['grid_persona_enlaces'][$this->NM_cont_body][$this->Tab_Nv_tree['g_genero']] = 'top';
       $nm_saida->saida("    <TBODY id=\"tbody_grid_persona_enlaces_" . $this->NM_cont_body . "_top\" style=\"display:''\">");
   }
   $nm_nivel_book_pdf = "";
   $nm_fecha_pdf_new  = "";
   if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] == "pdf" && !$this->Print_All)
   {
       $nm_nivel_book_pdf = "<div style=\"height:1px;overflow:hidden\"><H6 style=\"font-size:0;padding:1px\">" .  $this->$Cmps_Gb_Free[0]['cmp'] ;
       $nm_fecha_pdf_new = "</H6></div>";
   }
   $conteudo = $tot_g_genero[0] ;  
   $this->Label_g_genero = "<table>"; 
   $Cmps_gb = $this->$Cmps_Gb_Free;
   foreach ($Cmps_gb as $cada_campo) 
   { 
       $this->Label_g_genero .= "<tr>"; 
       $this->Label_g_genero .= "<td>" . $cada_campo['lab'] . "</td><td> => </td>";
       $this->Label_g_genero .= "<td>" . $cada_campo['cmp'] . "</td>";
       $this->Label_g_genero .= "</tr>"; 
   } 
   $this->Label_g_genero .= "</table>"; 
   $nm_saida->saida("    <TR >\r\n");
   $nm_saida->saida("     <TD class=\"" . $this->css_scGridBlock . "\" style=\"text-align:left;\"  style=\"text-align: left;\"  " . "colspan=\"" . ($this->nm_grid_slides_linha + 1) . "\"" . " align=\"\">\r\n");
   $nm_saida->saida("       " . $link_div . "\r\n");
   $nm_saida->saida("        " . $nm_nivel_book_pdf . $nm_fecha_pdf_new  . $this->Label_g_genero . $nm_fecha_pdf_old . "\r\n");
   $nm_saida->saida("       " . $link_div_2 . "\r\n");
   $nm_saida->saida("     </TD>\r\n");
   $nm_saida->saida("    </TR>\r\n");
   if ('' != $this->Ini->Tree_img_col && '' != $this->Ini->Tree_img_exp && !$this->Ini->Proc_print && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf" && !$this->NM_emb_tree_no)
   {
       $nm_saida->saida("    </TBODY>");
       if ($this->Ult_qb_free == $this->Tab_Nv_tree['g_genero'])
       {
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ind_tree']++;
           $this->NM_cont_body = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ind_tree'];
           $_SESSION['sc_session'][$this->Ini->sc_page]['NM_arr_tree']['grid_persona_enlaces'][$this->NM_cont_body][$this->Tab_Nv_tree['g_genero']] = 'bot';
           $nm_saida->saida("    <TBODY id=\"tbody_grid_persona_enlaces_" . $this->NM_cont_body . "_bot\" style=\"display:''\">");
           $this->NM_tbody_open = true;
       }
   }
 } 
 function quebra_geral_sc_free_group_by_top() 
 {
   global $nm_saida; 
   if (isset($this->NM_tbody_open) && $this->NM_tbody_open)
   {
       $nm_saida->saida("    </TBODY>");
   }
 }
 function quebra_geral_sc_free_group_by_bot() 
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
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
      { 
          $_SESSION['scriptcase']['saida_html'] = "";
      } 
      $nm_saida->saida("        <table id=\"sc_grid_toobar_top_table\" class=\"" . $this->css_scGridToolbar . "\" style=\"padding: 0px; border-spacing: 0px; border-width: 0px; vertical-align: top;\" width=\"100%\" valign=\"top\">\r\n");
      $nm_saida->saida("         <tr class=\"" . $this->css_scGridToolbarPadd . "_tr\"> \r\n");
      $nm_saida->saida("          <td class=\"" . $this->css_scGridToolbarPadd . "\" nowrap valign=\"middle\" align=\"left\" width=\"33%\"> \r\n");
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != "print") 
      {
      if (!$this->Ini->SC_Link_View && $this->nmgp_botoes['qsearch'] == "on")
      {
          $nm_saida->saida("           <script type=\"text/javascript\">var change_fast_top = \"\";</script>\r\n");
          $OPC_cmp = (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['fast_search'])) ? $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['fast_search'][0] : "";
          $OPC_arg = (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['fast_search'])) ? $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['fast_search'][1] : "";
          $OPC_dat = (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['fast_search'])) ? $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['fast_search'][2] : "";
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
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
      if ($this->nmgp_botoes['groupby'] == "on" && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_psq'] && empty($this->nm_grid_sem_reg) && !$this->grid_emb_form)
      {
          $Q_free  = false;
          $Q_count = 0;
          foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_All_Groupby'] as $QB => $Tp)
          {
              if (!in_array($QB, $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Groupby_hide']))
              {
                  $Q_count++;
                  if ($QB == "sc_free_group_by")
                  {
                      $Q_free = true;
                  }
              }
          }
          if ($Q_count > 1 || $Q_free)
          {
              $this->nm_btn_exist['groupby'][] = "sel_groupby_top";
              $Cod_Btn = nmButtonOutput($this->arr_buttons, "bgroupby", "scBtnGroupByShow('" . $this->Ini->path_link . "grid_persona_enlaces/grid_persona_enlaces_sel_groupby.php?opc_ret=igual&path_img=" . $this->Ini->path_img_global . "&path_btn=" . $this->Ini->path_botoes . "&script_case_init=" . NM_encode_input($this->Ini->sc_page) . "&embbed_groupby=Y&toolbar_pos=top', 'top');", "scBtnGroupByShow('" . $this->Ini->path_link . "grid_persona_enlaces/grid_persona_enlaces_sel_groupby.php?opc_ret=igual&path_img=" . $this->Ini->path_img_global . "&path_btn=" . $this->Ini->path_botoes . "&script_case_init=" . NM_encode_input($this->Ini->sc_page) . "&embbed_groupby=Y&toolbar_pos=top', 'top');", "sel_groupby_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
              $nm_saida->saida("           $Cod_Btn \r\n");
              $NM_btn = true;
          }
      }
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
      if ($this->nmgp_botoes['pdf'] == "on" && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_psq'] && empty($this->nm_grid_sem_reg) && !$this->grid_emb_form)
      {
          $nm_saida->saida("           <script type=\"text/javascript\">sc_itens_btgp_group_1_top = true;</script>\r\n");
      $Tem_gb_pdf  = "s";
      $Tem_pdf_res = "n";
      $Tem_pdf_res = "s";
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Ind_Groupby'] == "sc_free_group_by" && empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_cmp']))
      {
          $Tem_pdf_res = "n";
      }
              $this->nm_btn_exist['pdf'][] = "pdf_top";
          $nm_saida->saida("            <div id=\"div_pdf_top\" class=\"scBtnGrpText scBtnGrpClick\">\r\n");
              $Cod_Btn = nmButtonOutput($this->arr_buttons, "bpdf", "", "", "pdf_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "thickbox", "" . $this->Ini->path_link . "grid_persona_enlaces/grid_persona_enlaces_config_pdf.php?nm_opc=pdf&nm_target=0&nm_cor=cor&papel=8&lpapel=279&apapel=216&orientacao=1&bookmarks=1&largura=1200&conf_larg=S&conf_fonte=10&grafico=S&sc_ver_93=s&nm_tem_gb=" . $Tem_gb_pdf . "&nm_res_cons=" . $Tem_pdf_res . "&nm_ini_pdf_res=grid,resume&nm_all_modules=grid,resume,chart&nm_label_group=N&nm_all_cab=S&nm_all_label=S&nm_orient_grid=4&password=n&summary_export_columns=N&pdf_zip=N&origem=cons&language=es&conf_socor=N&script_case_init=" . $this->Ini->sc_page . "&app_name=grid_persona_enlaces&KeepThis=true&TB_iframe=true&modal=true", "group_1", "only_text", "text_right", "", "", "", "", "", "", "");
              $nm_saida->saida("           $Cod_Btn \r\n");
          $nm_saida->saida("            </div>\r\n");
              $NM_Gbtn = true;
      }
      if ($this->nmgp_botoes['word'] == "on" && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_psq'] && empty($this->nm_grid_sem_reg) && !$this->grid_emb_form)
      {
          $nm_saida->saida("           <script type=\"text/javascript\">sc_itens_btgp_group_1_top = true;</script>\r\n");
          $Tem_word_res = "n";
          $Tem_word_res = "s";
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Ind_Groupby'] == "sc_free_group_by" && empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_cmp']))
          {
              $Tem_word_res = "n";
          }
          $nm_saida->saida("            <div id=\"div_word_top\" class=\"scBtnGrpText scBtnGrpClick\">\r\n");
              $this->nm_btn_exist['word'][] = "word_top";
              $Cod_Btn = nmButtonOutput($this->arr_buttons, "bword", "", "", "word_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "thickbox", "" . $this->Ini->path_link . "grid_persona_enlaces/grid_persona_enlaces_config_word.php?script_case_init=" . $this->Ini->sc_page . "&summary_export_columns=N&nm_cor=CO&nm_res_cons=" . $Tem_word_res . "&nm_ini_word_res=grid,resume&nm_all_modules=grid,resume,chart&password=n&origem=cons&language=es&KeepThis=true&TB_iframe=true&modal=true", "group_1", "only_text", "text_right", "", "", "", "", "", "", "");
              $nm_saida->saida("           $Cod_Btn \r\n");
          $nm_saida->saida("            </div>\r\n");
              $NM_Gbtn = true;
      }
      if ($this->nmgp_botoes['xls'] == "on" && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_psq'] && empty($this->nm_grid_sem_reg) && !$this->grid_emb_form)
      {
          $nm_saida->saida("           <script type=\"text/javascript\">sc_itens_btgp_group_1_top = true;</script>\r\n");
          $Tem_xls_res = "n";
          $Tem_xls_res = "s";
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Ind_Groupby'] == "sc_free_group_by" && empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_cmp']))
          {
              $Tem_xls_res = "n";
          }
          $nm_saida->saida("            <div id=\"div_xls_top\" class=\"scBtnGrpText scBtnGrpClick\">\r\n");
              $this->nm_btn_exist['xls'][] = "xls_top";
              $Cod_Btn = nmButtonOutput($this->arr_buttons, "bexcel", "", "", "xls_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "thickbox", "" . $this->Ini->path_link . "grid_persona_enlaces/grid_persona_enlaces_config_xls.php?script_case_init=" . $this->Ini->sc_page . "&app_name=grid_persona_enlaces&nm_tp_xls=xlsx&nm_tot_xls=S&nm_res_cons=" . $Tem_xls_res . "&nm_ini_xls_res=grid,resume&nm_all_modules=grid,resume,chart&password=n&summary_export_columns=N&origem=cons&language=es&KeepThis=true&TB_iframe=true&modal=true", "group_1", "only_text", "text_right", "", "", "", "", "", "", "");
              $nm_saida->saida("           $Cod_Btn \r\n");
          $nm_saida->saida("            </div>\r\n");
              $NM_Gbtn = true;
      }
      if ($this->nmgp_botoes['csv'] == "on" && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_psq'] && empty($this->nm_grid_sem_reg) && !$this->grid_emb_form)
      {
          $nm_saida->saida("           <script type=\"text/javascript\">sc_itens_btgp_group_1_top = true;</script>\r\n");
          $Tem_csv_res = "n";
          $Tem_csv_res = "s";
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Ind_Groupby'] == "sc_free_group_by" && empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_cmp']))
          {
              $Tem_csv_res = "n";
          }
          $nm_saida->saida("            <div id=\"div_csv_top\" class=\"scBtnGrpText scBtnGrpClick\">\r\n");
              $this->nm_btn_exist['csv'][] = "csv_top";
              $Cod_Btn = nmButtonOutput($this->arr_buttons, "bcsv", "", "", "csv_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "thickbox", "" . $this->Ini->path_link . "grid_persona_enlaces/grid_persona_enlaces_config_csv.php?script_case_init=" . $this->Ini->sc_page . "&summary_export_columns=N&password=n&nm_res_cons=" . $Tem_csv_res . "&nm_ini_csv_res=grid,resume&nm_all_modules=grid,resume,chart&nm_delim_line=1&nm_delim_col=1&nm_delim_dados=1&nm_label_csv=N&language=&origem=cons&KeepThis=true&TB_iframe=true&modal=true", "group_1", "only_text", "text_right", "", "", "", "", "", "", "");
              $nm_saida->saida("           $Cod_Btn \r\n");
          $nm_saida->saida("            </div>\r\n");
              $NM_Gbtn = true;
      }
          if ($NM_Gbtn)
          {
                  $nm_saida->saida("           </td></tr><tr><td class=\"scBtnGrpBackground\">\r\n");
              $NM_Gbtn = false;
          }
      if ($this->nmgp_botoes['print'] == "on" && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_psq'] && empty($this->nm_grid_sem_reg) && !$this->grid_emb_form)
      {
          $Tem_pdf_res = "n";
          $Tem_pdf_res = "s";
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Ind_Groupby'] == "sc_free_group_by" && empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_cmp']))
          {
              $Tem_pdf_res = "n";
          }
          $nm_saida->saida("           <script type=\"text/javascript\">sc_itens_btgp_group_1_top = true;</script>\r\n");
          $nm_saida->saida("            <div id=\"div_print_top\" class=\"scBtnGrpText scBtnGrpClick\">\r\n");
              $this->nm_btn_exist['print'][] = "print_top";
              $Cod_Btn = nmButtonOutput($this->arr_buttons, "bprint", "", "", "print_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "thickbox", "" . $this->Ini->path_link . "grid_persona_enlaces/grid_persona_enlaces_config_print.php?script_case_init=" . $this->Ini->sc_page . "&summary_export_columns=N&nm_opc=RC&nm_cor=CO&password=n&language=es&nm_page=" . NM_encode_input($this->Ini->sc_page) . "&nm_res_cons=" . $Tem_pdf_res . "&nm_ini_prt_res=grid,resume&nm_all_modules=grid,resume,chart&origem=cons&KeepThis=true&TB_iframe=true&modal=true", "group_1", "only_text", "text_right", "", "", "", "", "", "", "");
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
        if (!$this->Ini->SC_Link_View && $this->nmgp_botoes['new'] == "on" && $this->nmgp_botoes['insert'] == "on" && !$this->grid_emb_form)
        {
           $Sc_parent = ($this->grid_emb_form_full) ? "S" : "";
           if (isset($this->Ini->sc_lig_md5["form_persona"]) && $this->Ini->sc_lig_md5["form_persona"] == "S") {
               $Parms_Lig  = "NM_cancel_insert_new*scin1*scoutNM_cancel_return_new*scin1*scoutnmgp_opcao*scinnovo*scoutNM_btn_insert*scinS*scoutNM_btn_new*scinS*scoutNM_btn_update*scinS*scoutNM_btn_delete*scinS*scoutNM_btn_navega*scinN*scout";
               $Md5_Lig    = "@SC_par@" . NM_encode_input($this->Ini->sc_page) . "@SC_par@grid_persona_enlaces@SC_par@" . md5($Parms_Lig);
               $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['Lig_Md5'][md5($Parms_Lig)] = $Parms_Lig;
           } else {
               $Md5_Lig  = "NM_cancel_insert_new*scin1*scoutNM_cancel_return_new*scin1*scoutnmgp_opcao*scinnovo*scoutNM_btn_insert*scinS*scoutNM_btn_new*scinS*scoutNM_btn_update*scinS*scoutNM_btn_delete*scinS*scoutNM_btn_navega*scinN*scout";
           }
         $this->nm_btn_exist['new'][] = "sc_b_new_top";
         $Cod_Btn = nmButtonOutput($this->arr_buttons, "bnovo", "nm_gp_submit1('" .  $this->Ini->link_form_persona . "', '$this->nm_location', '$Md5_Lig', '_self', 'form_persona'); return false;;", "nm_gp_submit1('" .  $this->Ini->link_form_persona . "', '$this->nm_location', '$Md5_Lig', '_self', 'form_persona'); return false;;", "sc_b_new_top", "", "" . $this->Ini->Nm_lang['lang_btns_neww'] . "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "" . $this->Ini->Nm_lang['lang_btns_neww_hint'] . "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
         $nm_saida->saida("           $Cod_Btn \r\n");
         $NM_btn = true;
        }
          if (is_file("grid_persona_enlaces_help.txt") && !$this->grid_emb_form)
          {
             $Arq_WebHelp = file("grid_persona_enlaces_help.txt"); 
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
      if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['b_sair'] || $this->grid_emb_form || $this->grid_emb_form_full || (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['dashboard_info']['under_dashboard']) && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['dashboard_info']['under_dashboard']))
      {
         $this->nmgp_botoes['exit'] = "off"; 
      }
      if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_psq'])
      {
          $this->nm_btn_exist['exit'][] = "sai_top";
         $Cod_Btn = nmButtonOutput($this->arr_buttons, "bvoltar", "nm_gp_move('resumo', '0');", "nm_gp_move('resumo', '0');", "sai_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
         $nm_saida->saida("           $Cod_Btn \r\n");
         $NM_btn = true;
      }
      elseif ($this->nmgp_botoes['exit'] == "on")
      {
        if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['sc_modal']) && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['sc_modal'])
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
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
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
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
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
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
      { 
          $_SESSION['scriptcase']['saida_html'] = "";
      } 
      $nm_saida->saida("        <table id=\"sc_grid_toobar_bot_table\" class=\"" . $this->css_scGridToolbar . "\" style=\"padding: 0px; border-spacing: 0px; border-width: 0px; vertical-align: top;\" width=\"100%\" valign=\"top\">\r\n");
      $nm_saida->saida("         <tr class=\"" . $this->css_scGridToolbarPadd . "_tr\"> \r\n");
      $nm_saida->saida("          <td class=\"" . $this->css_scGridToolbarPadd . "\" nowrap valign=\"middle\" align=\"left\" width=\"33%\"> \r\n");
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != "print") 
      {
          if (empty($this->nm_grid_sem_reg) && $this->nmgp_botoes['goto'] == "on" && $this->Ini->Apl_paginacao != "FULL" )
          {
              $Reg_Page  = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_lin_grid'];
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
              $obj_sel = ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_lin_grid'] == 1) ? " selected" : "";
              $nm_saida->saida("           <option value=\"1\" " . $obj_sel . ">1</option>\r\n");
              $obj_sel = ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_lin_grid'] == 10) ? " selected" : "";
              $nm_saida->saida("           <option value=\"10\" " . $obj_sel . ">10</option>\r\n");
              $obj_sel = ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_lin_grid'] == 20) ? " selected" : "";
              $nm_saida->saida("           <option value=\"20\" " . $obj_sel . ">20</option>\r\n");
              $obj_sel = ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_lin_grid'] == 50) ? " selected" : "";
              $nm_saida->saida("           <option value=\"50\" " . $obj_sel . ">50</option>\r\n");
              $nm_saida->saida("          </select>\r\n");
              $nm_saida->saida("          <input type=\"text\" class=\"" . $this->css_css_toolbar_obj . "\" id=\"quant_colunas_f0_bot\" name=\"nmgp_quant_colunas\" value=\"" . NM_encode_input($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_col_grid']) . "\" onchange=\"sc_ind = document.getElementById('quant_linhas_f0_bot').selectedIndex; nm_gp_submit_ajax('muda_qt_linhas', document.getElementById('quant_linhas_f0_bot').options[sc_ind].value + ';' + document.getElementById('quant_colunas_f0_bot').value);\" style=\"width:25px;vertical-align: middle;\"/> \r\n");
              $NM_btn = true;
          }
          $nm_saida->saida("         </td> \r\n");
          $nm_saida->saida("          <td class=\"" . $this->css_scGridToolbarPadd . "\" nowrap valign=\"middle\" align=\"center\" width=\"33%\"> \r\n");
          if ($this->nmgp_botoes['first'] == "on" && empty($this->nm_grid_sem_reg) && $this->Ini->Apl_paginacao != "FULL" && !isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_liga']['nav']))
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
          if ($this->nmgp_botoes['back'] == "on" && empty($this->nm_grid_sem_reg) && $this->Ini->Apl_paginacao != "FULL" && !isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_liga']['nav']))
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
          if (empty($this->nm_grid_sem_reg) && $this->nmgp_botoes['navpage'] == "on" && !isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_liga']['nav']) && $this->Ini->Apl_paginacao != "FULL" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_lin_grid'] != "all")
          {
              $Reg_Page  = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_lin_grid'] * $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_col_grid'];
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
          if ($this->nmgp_botoes['forward'] == "on" && empty($this->nm_grid_sem_reg) && $this->Ini->Apl_paginacao != "FULL" && !isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_liga']['nav']))
          {
              $this->nm_btn_exist['forward'][] = "forward_bot";
              $Cod_Btn = nmButtonOutput($this->arr_buttons, "bcons_avanca", "nm_gp_submit_rec('" . $this->Rec_fim . "');", "nm_gp_submit_rec('" . $this->Rec_fim . "');", "forward_bot", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
              $nm_saida->saida("           $Cod_Btn \r\n");
              $NM_btn = true;
          }
          if ($this->nmgp_botoes['last'] == "on" && empty($this->nm_grid_sem_reg) && $this->Ini->Apl_paginacao != "FULL" && !isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_liga']['nav']))
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
          if (is_file("grid_persona_enlaces_help.txt") && !$this->grid_emb_form)
          {
             $Arq_WebHelp = file("grid_persona_enlaces_help.txt"); 
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
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
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
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
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
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
      { 
          $_SESSION['scriptcase']['saida_html'] = "";
      } 
      $nm_saida->saida("        <table id=\"sc_grid_toobar_top_table\" class=\"" . $this->css_scGridToolbar . "\" style=\"padding: 0px; border-spacing: 0px; border-width: 0px; vertical-align: top;\" width=\"100%\" valign=\"top\">\r\n");
      $nm_saida->saida("         <tr class=\"" . $this->css_scGridToolbarPadd . "_tr\"> \r\n");
      $nm_saida->saida("          <td class=\"" . $this->css_scGridToolbarPadd . "\" nowrap valign=\"middle\" align=\"left\" width=\"33%\"> \r\n");
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != "print") 
      {
      if (!$this->Ini->SC_Link_View && $this->nmgp_botoes['qsearch'] == "on")
      {
          $nm_saida->saida("           <script type=\"text/javascript\">var change_fast_top = \"\";</script>\r\n");
          $OPC_cmp = (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['fast_search'])) ? $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['fast_search'][0] : "";
          $OPC_arg = (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['fast_search'])) ? $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['fast_search'][1] : "";
          $OPC_dat = (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['fast_search'])) ? $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['fast_search'][2] : "";
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
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
      if ($this->nmgp_botoes['groupby'] == "on" && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_psq'] && empty($this->nm_grid_sem_reg) && !$this->grid_emb_form)
      {
          $Q_free  = false;
          $Q_count = 0;
          foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_All_Groupby'] as $QB => $Tp)
          {
              if (!in_array($QB, $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Groupby_hide']))
              {
                  $Q_count++;
                  if ($QB == "sc_free_group_by")
                  {
                      $Q_free = true;
                  }
              }
          }
          if ($Q_count > 1 || $Q_free)
          {
              $this->nm_btn_exist['groupby'][] = "sel_groupby_top";
              $Cod_Btn = nmButtonOutput($this->arr_buttons, "bgroupby", "scBtnGroupByShow('" . $this->Ini->path_link . "grid_persona_enlaces/grid_persona_enlaces_sel_groupby.php?opc_ret=igual&path_img=" . $this->Ini->path_img_global . "&path_btn=" . $this->Ini->path_botoes . "&script_case_init=" . NM_encode_input($this->Ini->sc_page) . "&embbed_groupby=Y&toolbar_pos=top', 'top');", "scBtnGroupByShow('" . $this->Ini->path_link . "grid_persona_enlaces/grid_persona_enlaces_sel_groupby.php?opc_ret=igual&path_img=" . $this->Ini->path_img_global . "&path_btn=" . $this->Ini->path_botoes . "&script_case_init=" . NM_encode_input($this->Ini->sc_page) . "&embbed_groupby=Y&toolbar_pos=top', 'top');", "sel_groupby_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
              $nm_saida->saida("           $Cod_Btn \r\n");
              $NM_btn = true;
          }
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
      if ($this->nmgp_botoes['pdf'] == "on" && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_psq'] && empty($this->nm_grid_sem_reg) && !$this->grid_emb_form)
      {
          $nm_saida->saida("           <script type=\"text/javascript\">sc_itens_btgp_group_3_top = true;</script>\r\n");
      $Tem_gb_pdf  = "s";
      $Tem_pdf_res = "n";
      $Tem_pdf_res = "s";
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Ind_Groupby'] == "sc_free_group_by" && empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_cmp']))
      {
          $Tem_pdf_res = "n";
      }
              $this->nm_btn_exist['pdf'][] = "pdf_top";
          $nm_saida->saida("            <div id=\"div_pdf_top\" class=\"scBtnGrpText scBtnGrpClick\">\r\n");
              $Cod_Btn = nmButtonOutput($this->arr_buttons, "bpdf", "", "", "pdf_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "thickbox", "" . $this->Ini->path_link . "grid_persona_enlaces/grid_persona_enlaces_config_pdf.php?nm_opc=pdf&nm_target=0&nm_cor=cor&papel=8&lpapel=279&apapel=216&orientacao=1&bookmarks=1&largura=1200&conf_larg=S&conf_fonte=10&grafico=S&sc_ver_93=s&nm_tem_gb=" . $Tem_gb_pdf . "&nm_res_cons=" . $Tem_pdf_res . "&nm_ini_pdf_res=grid,resume&nm_all_modules=grid,resume,chart&nm_label_group=N&nm_all_cab=S&nm_all_label=S&nm_orient_grid=4&password=n&summary_export_columns=N&pdf_zip=N&origem=cons&language=es&conf_socor=N&script_case_init=" . $this->Ini->sc_page . "&app_name=grid_persona_enlaces&KeepThis=true&TB_iframe=true&modal=true", "group_3", "only_text", "text_right", "", "", "", "", "", "", "");
              $nm_saida->saida("           $Cod_Btn \r\n");
          $nm_saida->saida("            </div>\r\n");
              $NM_Gbtn = true;
      }
      if ($this->nmgp_botoes['word'] == "on" && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_psq'] && empty($this->nm_grid_sem_reg) && !$this->grid_emb_form)
      {
          $nm_saida->saida("           <script type=\"text/javascript\">sc_itens_btgp_group_3_top = true;</script>\r\n");
          $Tem_word_res = "n";
          $Tem_word_res = "s";
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Ind_Groupby'] == "sc_free_group_by" && empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_cmp']))
          {
              $Tem_word_res = "n";
          }
          $nm_saida->saida("            <div id=\"div_word_top\" class=\"scBtnGrpText scBtnGrpClick\">\r\n");
              $this->nm_btn_exist['word'][] = "word_top";
              $Cod_Btn = nmButtonOutput($this->arr_buttons, "bword", "", "", "word_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "thickbox", "" . $this->Ini->path_link . "grid_persona_enlaces/grid_persona_enlaces_config_word.php?script_case_init=" . $this->Ini->sc_page . "&summary_export_columns=N&nm_cor=CO&nm_res_cons=" . $Tem_word_res . "&nm_ini_word_res=grid,resume&nm_all_modules=grid,resume,chart&password=n&origem=cons&language=es&KeepThis=true&TB_iframe=true&modal=true", "group_3", "only_text", "text_right", "", "", "", "", "", "", "");
              $nm_saida->saida("           $Cod_Btn \r\n");
          $nm_saida->saida("            </div>\r\n");
              $NM_Gbtn = true;
      }
      if ($this->nmgp_botoes['xls'] == "on" && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_psq'] && empty($this->nm_grid_sem_reg) && !$this->grid_emb_form)
      {
          $nm_saida->saida("           <script type=\"text/javascript\">sc_itens_btgp_group_3_top = true;</script>\r\n");
          $Tem_xls_res = "n";
          $Tem_xls_res = "s";
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Ind_Groupby'] == "sc_free_group_by" && empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_cmp']))
          {
              $Tem_xls_res = "n";
          }
          $nm_saida->saida("            <div id=\"div_xls_top\" class=\"scBtnGrpText scBtnGrpClick\">\r\n");
              $this->nm_btn_exist['xls'][] = "xls_top";
              $Cod_Btn = nmButtonOutput($this->arr_buttons, "bexcel", "", "", "xls_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "thickbox", "" . $this->Ini->path_link . "grid_persona_enlaces/grid_persona_enlaces_config_xls.php?script_case_init=" . $this->Ini->sc_page . "&app_name=grid_persona_enlaces&nm_tp_xls=xlsx&nm_tot_xls=S&nm_res_cons=" . $Tem_xls_res . "&nm_ini_xls_res=grid,resume&nm_all_modules=grid,resume,chart&password=n&summary_export_columns=N&origem=cons&language=es&KeepThis=true&TB_iframe=true&modal=true", "group_3", "only_text", "text_right", "", "", "", "", "", "", "");
              $nm_saida->saida("           $Cod_Btn \r\n");
          $nm_saida->saida("            </div>\r\n");
              $NM_Gbtn = true;
      }
      if ($this->nmgp_botoes['csv'] == "on" && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_psq'] && empty($this->nm_grid_sem_reg) && !$this->grid_emb_form)
      {
          $nm_saida->saida("           <script type=\"text/javascript\">sc_itens_btgp_group_3_top = true;</script>\r\n");
          $Tem_csv_res = "n";
          $Tem_csv_res = "s";
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Ind_Groupby'] == "sc_free_group_by" && empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_cmp']))
          {
              $Tem_csv_res = "n";
          }
          $nm_saida->saida("            <div id=\"div_csv_top\" class=\"scBtnGrpText scBtnGrpClick\">\r\n");
              $this->nm_btn_exist['csv'][] = "csv_top";
              $Cod_Btn = nmButtonOutput($this->arr_buttons, "bcsv", "", "", "csv_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "thickbox", "" . $this->Ini->path_link . "grid_persona_enlaces/grid_persona_enlaces_config_csv.php?script_case_init=" . $this->Ini->sc_page . "&summary_export_columns=N&password=n&nm_res_cons=" . $Tem_csv_res . "&nm_ini_csv_res=grid,resume&nm_all_modules=grid,resume,chart&nm_delim_line=1&nm_delim_col=1&nm_delim_dados=1&nm_label_csv=N&language=&origem=cons&KeepThis=true&TB_iframe=true&modal=true", "group_3", "only_text", "text_right", "", "", "", "", "", "", "");
              $nm_saida->saida("           $Cod_Btn \r\n");
          $nm_saida->saida("            </div>\r\n");
              $NM_Gbtn = true;
      }
          if ($NM_Gbtn)
          {
                  $nm_saida->saida("           </td></tr><tr><td class=\"scBtnGrpBackground\">\r\n");
              $NM_Gbtn = false;
          }
      if ($this->nmgp_botoes['print'] == "on" && !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_psq'] && empty($this->nm_grid_sem_reg) && !$this->grid_emb_form)
      {
          $Tem_pdf_res = "n";
          $Tem_pdf_res = "s";
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Ind_Groupby'] == "sc_free_group_by" && empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['SC_Gb_Free_cmp']))
          {
              $Tem_pdf_res = "n";
          }
          $nm_saida->saida("           <script type=\"text/javascript\">sc_itens_btgp_group_3_top = true;</script>\r\n");
          $nm_saida->saida("            <div id=\"div_print_top\" class=\"scBtnGrpText scBtnGrpClick\">\r\n");
              $this->nm_btn_exist['print'][] = "print_top";
              $Cod_Btn = nmButtonOutput($this->arr_buttons, "bprint", "", "", "print_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "thickbox", "" . $this->Ini->path_link . "grid_persona_enlaces/grid_persona_enlaces_config_print.php?script_case_init=" . $this->Ini->sc_page . "&summary_export_columns=N&nm_opc=RC&nm_cor=CO&password=n&language=es&nm_page=" . NM_encode_input($this->Ini->sc_page) . "&nm_res_cons=" . $Tem_pdf_res . "&nm_ini_prt_res=grid,resume&nm_all_modules=grid,resume,chart&origem=cons&KeepThis=true&TB_iframe=true&modal=true", "group_3", "only_text", "text_right", "", "", "", "", "", "", "");
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
        if (!$this->Ini->SC_Link_View && $this->nmgp_botoes['new'] == "on" && $this->nmgp_botoes['insert'] == "on" && !$this->grid_emb_form)
        {
           $Sc_parent = ($this->grid_emb_form_full) ? "S" : "";
           if (isset($this->Ini->sc_lig_md5["form_persona"]) && $this->Ini->sc_lig_md5["form_persona"] == "S") {
               $Parms_Lig  = "NM_cancel_insert_new*scin1*scoutNM_cancel_return_new*scin1*scoutnmgp_opcao*scinnovo*scoutNM_btn_insert*scinS*scoutNM_btn_new*scinS*scoutNM_btn_update*scinS*scoutNM_btn_delete*scinS*scoutNM_btn_navega*scinN*scout";
               $Md5_Lig    = "@SC_par@" . NM_encode_input($this->Ini->sc_page) . "@SC_par@grid_persona_enlaces@SC_par@" . md5($Parms_Lig);
               $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['Lig_Md5'][md5($Parms_Lig)] = $Parms_Lig;
           } else {
               $Md5_Lig  = "NM_cancel_insert_new*scin1*scoutNM_cancel_return_new*scin1*scoutnmgp_opcao*scinnovo*scoutNM_btn_insert*scinS*scoutNM_btn_new*scinS*scoutNM_btn_update*scinS*scoutNM_btn_delete*scinS*scoutNM_btn_navega*scinN*scout";
           }
         $this->nm_btn_exist['new'][] = "sc_b_new_top";
         $Cod_Btn = nmButtonOutput($this->arr_buttons, "bnovo", "nm_gp_submit1('" .  $this->Ini->link_form_persona . "', '$this->nm_location', '$Md5_Lig', '_self', 'form_persona'); return false;;", "nm_gp_submit1('" .  $this->Ini->link_form_persona . "', '$this->nm_location', '$Md5_Lig', '_self', 'form_persona'); return false;;", "sc_b_new_top", "", "" . $this->Ini->Nm_lang['lang_btns_neww'] . "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "" . $this->Ini->Nm_lang['lang_btns_neww_hint'] . "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
         $nm_saida->saida("           $Cod_Btn \r\n");
         $NM_btn = true;
        }
          if (is_file("grid_persona_enlaces_help.txt") && !$this->grid_emb_form)
          {
             $Arq_WebHelp = file("grid_persona_enlaces_help.txt"); 
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
      if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['b_sair'] || $this->grid_emb_form || $this->grid_emb_form_full || (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['dashboard_info']['under_dashboard']) && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['dashboard_info']['under_dashboard']))
      {
         $this->nmgp_botoes['exit'] = "off"; 
      }
      if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_psq'])
      {
          $this->nm_btn_exist['exit'][] = "sai_top";
         $Cod_Btn = nmButtonOutput($this->arr_buttons, "bvoltar", "nm_gp_move('resumo', '0');", "nm_gp_move('resumo', '0');", "sai_top", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
         $nm_saida->saida("           $Cod_Btn \r\n");
         $NM_btn = true;
      }
      elseif ($this->nmgp_botoes['exit'] == "on")
      {
        if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['sc_modal']) && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['sc_modal'])
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
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
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
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
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
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
      { 
          $_SESSION['scriptcase']['saida_html'] = "";
      } 
      $nm_saida->saida("        <table id=\"sc_grid_toobar_bot_table\" class=\"" . $this->css_scGridToolbar . "\" style=\"padding: 0px; border-spacing: 0px; border-width: 0px; vertical-align: top;\" width=\"100%\" valign=\"top\">\r\n");
      $nm_saida->saida("         <tr class=\"" . $this->css_scGridToolbarPadd . "_tr\"> \r\n");
      $nm_saida->saida("          <td class=\"" . $this->css_scGridToolbarPadd . "\" nowrap valign=\"middle\" align=\"left\" width=\"33%\"> \r\n");
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != "print") 
      {
          if (empty($this->nm_grid_sem_reg) && $this->nmgp_botoes['goto'] == "on" && $this->Ini->Apl_paginacao != "FULL" )
          {
              $Reg_Page  = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_lin_grid'];
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
              $obj_sel = ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_lin_grid'] == 1) ? " selected" : "";
              $nm_saida->saida("           <option value=\"1\" " . $obj_sel . ">1</option>\r\n");
              $obj_sel = ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_lin_grid'] == 10) ? " selected" : "";
              $nm_saida->saida("           <option value=\"10\" " . $obj_sel . ">10</option>\r\n");
              $obj_sel = ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_lin_grid'] == 20) ? " selected" : "";
              $nm_saida->saida("           <option value=\"20\" " . $obj_sel . ">20</option>\r\n");
              $obj_sel = ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_lin_grid'] == 50) ? " selected" : "";
              $nm_saida->saida("           <option value=\"50\" " . $obj_sel . ">50</option>\r\n");
              $nm_saida->saida("          </select>\r\n");
              $nm_saida->saida("          <input type=\"text\" class=\"" . $this->css_css_toolbar_obj . "\" id=\"quant_colunas_f0_bot\" name=\"nmgp_quant_colunas\" value=\"" . NM_encode_input($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_col_grid']) . "\" onchange=\"sc_ind = document.getElementById('quant_linhas_f0_bot').selectedIndex; nm_gp_submit_ajax('muda_qt_linhas', document.getElementById('quant_linhas_f0_bot').options[sc_ind].value + ';' + document.getElementById('quant_colunas_f0_bot').value);\" style=\"width:25px;vertical-align: middle;\"/> \r\n");
              $NM_btn = true;
          }
          if ($this->nmgp_botoes['first'] == "on" && empty($this->nm_grid_sem_reg) && $this->Ini->Apl_paginacao != "FULL" && !isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_liga']['nav']))
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
          if ($this->nmgp_botoes['back'] == "on" && empty($this->nm_grid_sem_reg) && $this->Ini->Apl_paginacao != "FULL" && !isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_liga']['nav']))
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
          if (empty($this->nm_grid_sem_reg) && $this->nmgp_botoes['navpage'] == "on" && !isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_liga']['nav']) && $this->Ini->Apl_paginacao != "FULL" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_lin_grid'] != "all")
          {
              $Reg_Page  = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_lin_grid'] * $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['qt_col_grid'];
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
          if ($this->nmgp_botoes['forward'] == "on" && empty($this->nm_grid_sem_reg) && $this->Ini->Apl_paginacao != "FULL" && !isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_liga']['nav']))
          {
              $this->nm_btn_exist['forward'][] = "forward_bot";
              $Cod_Btn = nmButtonOutput($this->arr_buttons, "bcons_avanca", "nm_gp_submit_rec('" . $this->Rec_fim . "');", "nm_gp_submit_rec('" . $this->Rec_fim . "');", "forward_bot", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
              $nm_saida->saida("           $Cod_Btn \r\n");
              $NM_btn = true;
          }
          if ($this->nmgp_botoes['last'] == "on" && empty($this->nm_grid_sem_reg) && $this->Ini->Apl_paginacao != "FULL" && !isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_liga']['nav']))
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
          if (is_file("grid_persona_enlaces_help.txt") && !$this->grid_emb_form)
          {
             $Arq_WebHelp = file("grid_persona_enlaces_help.txt"); 
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
      if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
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
          if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
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
        if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
        { 
           $_SESSION['scriptcase']['saida_html'] = "";
        } 
       $this->NM_case_insensitive = false;
       $tmp = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['cond_pesq'];
       $pos = strrpos($tmp, "##*@@");
       if ($pos !== false)
       {
           $and_or = (substr($tmp, ($pos + 5)) == "and") ? $this->Ini->Nm_lang['lang_srch_and_cond'] : $this->Ini->Nm_lang['lang_srch_orr_cond'];
           $tmp    = substr($tmp, 0, $pos);
           $this->grid_search_str = str_replace("##*@@", ", " . $and_or . " ", $tmp);
       }
       $str_display = empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['grid_pesq'])?'none':'';
       if(!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
       {
          $nm_saida->saida("   <tr id=\"NM_Grid_Search\" ajax='' style='display:" . $str_display . "'>\r\n");
       }
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'] && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['grid_pesq']))
       { 
           $_SESSION['scriptcase']['saida_html'] = "";
           foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['grid_pesq'] as $cmp => $def)
           {
               $this->Ini->Arr_result['setValue'][] = array('field' => 'grid_search_label_' . $cmp, 'value' => NM_charset_to_utf8(trim($def['descr'])));
               $this->Ini->Arr_result['setTitle'][] = array('field' => 'grid_search_label_' . $cmp, 'value' => NM_charset_to_utf8(trim($def['hint'])));
           }
           $lin_obj = $this->grid_search_add_tag();
           $this->Ini->Arr_result['setValue'][] = array('field' => 'id_grid_search_add_tag', 'value' => NM_charset_to_utf8($lin_obj));
           $this->Ini->Arr_result['setValue'][] = array('field' => 'id_grid_search_cmd_str', 'value' => NM_charset_to_utf8($this->grid_search_str));
           if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['save_grid']))
           {
               return;
           }
           else
           {
               $this->Ini->Arr_result['setDisplay'][] = array('field' => 'NM_Grid_Search', 'value' => '');
           }
       } 
           if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['save_grid']))
           {
               $str_display = empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['grid_pesq']) ? 'none' : '';
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
            if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['grid_pesq']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['grid_pesq']))
            {
                foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['grid_pesq'] as $cmp => $def)
                {
                    if (isset($def['label'])) {
                        $this->grid_search_seq++;
                        $lin_obj = $this->grid_search_tag_ini($cmp, $def, $this->grid_search_seq);
                        $nm_saida->saida("" . $lin_obj . "\r\n");
                        if ($cmp == "p_idpersona")
                        {
                           $this->grid_search_dat[$this->grid_search_seq] = "p_idpersona";
                           $lin_obj = $this->grid_search_p_idpersona($this->grid_search_seq, 'N', $def['opc'], $def['val'], $def['label']);
                           $nm_saida->saida("" . $lin_obj . "\r\n");
                        }
                        if ($cmp == "p_foto")
                        {
                           $this->grid_search_dat[$this->grid_search_seq] = "p_foto";
                           $lin_obj = $this->grid_search_p_foto($this->grid_search_seq, 'N', $def['opc'], $def['val'], $def['label']);
                           $nm_saida->saida("" . $lin_obj . "\r\n");
                        }
                        if ($cmp == "p_nombre")
                        {
                           $this->grid_search_dat[$this->grid_search_seq] = "p_nombre";
                           $lin_obj = $this->grid_search_p_nombre($this->grid_search_seq, 'N', $def['opc'], $def['val'], $def['label']);
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
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
       { 
           $this->Ini->Arr_result['setValue'][] = array('field' => 'NM_Grid_Search', 'value' => NM_charset_to_utf8($_SESSION['scriptcase']['saida_html']));
           $_SESSION['scriptcase']['saida_html'] = "";
           if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['save_grid']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['grid_pesq']))
           { 
               $this->Ini->Arr_result['exec_JS'][] = array('function' => 'SC_carga_evt_jquery_grid', 'parm' => 'all');
           } 
       } 
       if(!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
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
       $All_cmp_search = array('p_idpersona','p_foto','p_nombre');
       $nmgp_tab_label = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['pesq_tab_label'];
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
       if (count($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['grid_pesq']) < 3)
       {
           $lin_obj .= "<table id='id_grid_search_all_cmp' cellpadding=0 cellspacing=0>";
           foreach ($All_cmp_search as $cada_cmp)
           {
               if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['grid_pesq'][$cada_cmp]))
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
   function grid_search_p_idpersona($ind, $ajax, $opc="", $val=array(), $label='')
   {
       $lin_obj  = "";
       $lin_obj .= "     <div class='scGridFilterTagListFilter' id='grid_search_p_idpersona_" . $ind . "' style='display:none; z-index: 10'>";
       $lin_obj .= "         <div class='scGridFilterTagListFilterLabel'>". NM_encode_input($label) ." <span class='scGridFilterTagListFilterLabelClose' onclick='closeAllTags(this);'></span></div>";
       $lin_obj .= "         <div class='scGridFilterTagListFilterInputs'>";
       if (empty($opc))
       {
           $opc = "gt";
       }
       $lin_obj .= "       <select id='grid_search_p_idpersona_cond_" . $ind . "' name='cond_grid_search_p_idpersona_" . $ind . "' class='" . $this->css_scAppDivToolbarInput . "' style='vertical-align: middle;' onChange='grid_search_hide_input(\"p_idpersona\", $ind)'>";
       $selected = ($opc == "gt") ? " selected" : "";
       $lin_obj .= "        <option value='gt'" . $selected . ">" . $this->Ini->Nm_lang['lang_srch_grtr'] . "</option>";
       $selected = ($opc == "lt") ? " selected" : "";
       $lin_obj .= "        <option value='lt'" . $selected . ">" . $this->Ini->Nm_lang['lang_srch_less'] . "</option>";
       $selected = ($opc == "eq") ? " selected" : "";
       $lin_obj .= "        <option value='eq'" . $selected . ">" . $this->Ini->Nm_lang['lang_srch_exac'] . "</option>";
       $lin_obj .= "       </select>";
       if ($opc == "nu" || $opc == "nn" || $opc == "ep" || $opc == "ne")
       {
           $display_in_1 = "none";
       }
       else
       {
           $display_in_1 = "''";
       }
       $lin_obj .= "       <span id=\"grid_p_idpersona_" . $ind . "\" style=\"display:" . $display_in_1 . "\">";
       $val_cmp = (isset($val[0][0])) ? $val[0][0] : "";
       nmgp_Form_Num_Val($val_cmp, $_SESSION['scriptcase']['reg_conf']['grup_num'], $_SESSION['scriptcase']['reg_conf']['dec_num'], "0", "S", "1", "", "N:" . $_SESSION['scriptcase']['reg_conf']['neg_num'] , $_SESSION['scriptcase']['reg_conf']['simb_neg'], $_SESSION['scriptcase']['reg_conf']['num_group_digit']) ; 
       $lin_obj .= "     <input  type=\"text\" class='sc-js-input " . $this->css_scAppDivToolbarInput . "' id='grid_search_p_idpersona_val_" . $ind . "' name='val_grid_search_p_idpersona_" . $ind . "' value=\"" . NM_encode_input($val_cmp) . "\" size=11 alt=\"{datatype: 'decimal', maxLength: 11, precision: 0, decimalSep: '" . $_SESSION['scriptcase']['reg_conf']['dec_num'] . "', thousandsSep: '" . $_SESSION['scriptcase']['reg_conf']['grup_num'] . "', allowNegative: false, onlyNegative: false, enterTab: false}\">";
       $lin_obj .= "       </span>";
       $lin_obj .= "          </div>";
       $lin_obj .= "          <div class='scGridFilterTagListFilterBar'>";
       $lin_obj .= nmButtonOutput($this->arr_buttons, "bapply_appdiv", "closeAllTags();setTimeout(function() {nm_proc_grid_search($ind, 'proc_grid_search', 'grid_search')}, 200);", "closeAllTags();setTimeout(function() {nm_proc_grid_search($ind, 'proc_grid_search', 'grid_search')}, 200);", "grid_search_apply_" . $ind . "", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
       $lin_obj .= "          </div>";
       $lin_obj .= "      </div>";
       return $lin_obj;
   }
   function grid_search_p_foto($ind, $ajax, $opc="", $val=array(), $label='')
   {
       $lin_obj  = "";
       $lin_obj .= "     <div class='scGridFilterTagListFilter' id='grid_search_p_foto_" . $ind . "' style='display:none; z-index: 10'>";
       $lin_obj .= "         <div class='scGridFilterTagListFilterLabel'>". NM_encode_input($label) ." <span class='scGridFilterTagListFilterLabelClose' onclick='closeAllTags(this);'></span></div>";
       $lin_obj .= "         <div class='scGridFilterTagListFilterInputs'>";
       if (empty($opc))
       {
           $opc = "eq";
       }
       $lin_obj .= "       <select id='grid_search_p_foto_cond_" . $ind . "' name='cond_grid_search_p_foto_" . $ind . "' class='" . $this->css_scAppDivToolbarInput . "' style='vertical-align: middle;' onChange='grid_search_hide_input(\"p_foto\", $ind)'>";
       $selected = ($opc == "eq") ? " selected" : "";
       $lin_obj .= "        <option value='eq'" . $selected . ">" . $this->Ini->Nm_lang['lang_srch_exac'] . "</option>";
       $selected = ($opc == "ii") ? " selected" : "";
       $lin_obj .= "        <option value='ii'" . $selected . ">" . $this->Ini->Nm_lang['lang_srch_stts_with'] . "</option>";
       $selected = ($opc == "qp") ? " selected" : "";
       $lin_obj .= "        <option value='qp'" . $selected . ">" . $this->Ini->Nm_lang['lang_srch_like'] . "</option>";
       $selected = ($opc == "df") ? " selected" : "";
       $lin_obj .= "        <option value='df'" . $selected . ">" . $this->Ini->Nm_lang['lang_srch_dife'] . "</option>";
       $lin_obj .= "       </select>";
       if ($opc == "nu" || $opc == "nn" || $opc == "ep" || $opc == "ne")
       {
           $display_in_1 = "none";
       }
       else
       {
           $display_in_1 = "''";
       }
       $lin_obj .= "       <span id=\"grid_p_foto_" . $ind . "\" style=\"display:" . $display_in_1 . "\">";
       $val_cmp = (isset($val[0][0])) ? $val[0][0] : "";
       $lin_obj .= "     <input  type=\"text\" class='sc-js-input " . $this->css_scAppDivToolbarInput . "' id='grid_search_p_foto_val_" . $ind . "' name='val_grid_search_p_foto_" . $ind . "' value=\"" . NM_encode_input($val_cmpo) . "\" size=\"50\" maxlength=\"32767\">";
       $lin_obj .= "       </span>";
       $lin_obj .= "          </div>";
       $lin_obj .= "          <div class='scGridFilterTagListFilterBar'>";
       $lin_obj .= nmButtonOutput($this->arr_buttons, "bapply_appdiv", "closeAllTags();setTimeout(function() {nm_proc_grid_search($ind, 'proc_grid_search', 'grid_search')}, 200);", "closeAllTags();setTimeout(function() {nm_proc_grid_search($ind, 'proc_grid_search', 'grid_search')}, 200);", "grid_search_apply_" . $ind . "", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
       $lin_obj .= "          </div>";
       $lin_obj .= "      </div>";
       return $lin_obj;
   }
   function grid_search_p_nombre($ind, $ajax, $opc="", $val=array(), $label='')
   {
       $lin_obj  = "";
       $lin_obj .= "     <div class='scGridFilterTagListFilter' id='grid_search_p_nombre_" . $ind . "' style='display:none; z-index: 10'>";
       $lin_obj .= "         <div class='scGridFilterTagListFilterLabel'>". NM_encode_input($label) ." <span class='scGridFilterTagListFilterLabelClose' onclick='closeAllTags(this);'></span></div>";
       $lin_obj .= "         <div class='scGridFilterTagListFilterInputs'>";
       if (empty($opc))
       {
           $opc = "qp";
       }
       $lin_obj .= "       <select id='grid_search_p_nombre_cond_" . $ind . "' name='cond_grid_search_p_nombre_" . $ind . "' class='" . $this->css_scAppDivToolbarInput . "' style='vertical-align: middle;' onChange='grid_search_hide_input(\"p_nombre\", $ind)'>";
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
       $lin_obj .= "       <span id=\"grid_p_nombre_" . $ind . "\" style=\"display:" . $display_in_1 . "\">";
       $val_cmp = (isset($val[0][0])) ? $val[0][0] : "";
       $p_nombre = $val_cmp;
       if ($p_nombre != "")
       {
       $p_nombre_look = substr($this->Db->qstr($p_nombre), 1, -1); 
       $nmgp_def_dados = array(); 
       $nm_comando = "select distinct p.nombre from " . $this->Ini->nm_tabela . " where p.idTipoDeDocumento=td.idTipoDeDocumento AND p.idGenero=g.idGenero AND  	 p.idEtnia=e.idEtnia AND p.idEstadoCivil=ec.idEstadoCivil AND p.idComunidad=c.idComunidad AND c.idMunicipio=mu.idMunicipio AND mu.idDepartamento=de.idDepartamento AND de.idPais=pa.idPais AND p.idLgbt=l.idLgbt and p.nombre = '$p_nombre_look' order by p.nombre"; 
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
       if (isset($nmgp_def_dados[0][$p_nombre]))
       {
           $sAutocompValue = $nmgp_def_dados[0][$p_nombre];
       }
       else
       {
           $sAutocompValue = $val_cmp;
           $val[0][0]      = $val_cmp;
       }
       $val_cmp = (isset($val[0][0])) ? $val[0][0] : "";
       $lin_obj .= "     <input  type=\"text\" class='sc-js-input " . $this->css_scAppDivToolbarInput . "' id='grid_search_p_nombre_val_" . $ind . "' name='val_grid_search_p_nombre_" . $ind . "' value=\"" . NM_encode_input($val_cmp) . "\" size=50 alt=\"{datatype: 'text', maxLength: 375, allowedChars: '', lettersCase: '', autoTab: false, enterTab: false}\" style='display: none'>";
       $tmp_pos = strpos($val_cmp, "##@@");
       if ($tmp_pos !== false) {
           $val_cmp = substr($val_cmp, ($tmp_pos + 4));
           $sAutocompValue = substr($sAutocompValue, ($tmp_pos + 4));
       }
       $lin_obj .= "     <input class='sc-js-input " . $this->css_scAppDivToolbarInput . "' type='text' id='id_ac_grid_p_nombre" . $ind . "' name='val_grid_search_p_nombre_autocomp" . $ind . "' size='50' value='" . NM_encode_input($sAutocompValue) . "' alt=\"{datatype: 'text', maxLength: 50, allowedChars: '', lettersCase: '', autoTab: false, enterTab: false}\">";
       $lin_obj .= "       </span>";
       $lin_obj .= "          </div>";
       $lin_obj .= "          <div class='scGridFilterTagListFilterBar'>";
       $lin_obj .= nmButtonOutput($this->arr_buttons, "bapply_appdiv", "closeAllTags();setTimeout(function() {nm_proc_grid_search($ind, 'proc_grid_search', 'grid_search')}, 200);", "closeAllTags();setTimeout(function() {nm_proc_grid_search($ind, 'proc_grid_search', 'grid_search')}, 200);", "grid_search_apply_" . $ind . "", "", "", "", "absmiddle", "", "0px", $this->Ini->path_botoes, "", "", "", "", "", "only_text", "text_right", "", "", "", "", "", "", "");
       $lin_obj .= "          </div>";
       $lin_obj .= "      </div>";
       return $lin_obj;
   }
   function lookup_ajax_p_nombre($p_nombre)
   {
       $p_nombre = substr($this->Db->qstr($p_nombre), 1, -1);
       $this->NM_case_insensitive = false;
       $p_nombre_look = substr($this->Db->qstr($p_nombre), 1, -1); 
       $nmgp_def_dados = array(); 
       $nm_comando = "select distinct p.nombre from " . $this->Ini->nm_tabela . " where p.idTipoDeDocumento=td.idTipoDeDocumento AND p.idGenero=g.idGenero AND  	 p.idEtnia=e.idEtnia AND p.idEstadoCivil=ec.idEstadoCivil AND p.idComunidad=c.idComunidad AND c.idMunicipio=mu.idMunicipio AND mu.idDepartamento=de.idDepartamento AND de.idPais=pa.idPais AND p.idLgbt=l.idLgbt and  p.nombre like '%" . $p_nombre . "%' order by p.nombre"; 
       $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_comando; 
       $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
      if ($rs = $this->Db->SelectLimit($nm_comando, 10, 0)) 
       { 
          while (!$rs->EOF) 
          { 
            $cmp1 = NM_charset_to_utf8(trim($rs->fields[0]));
            $cmp1 = grid_persona_enlaces_pack_protect_string($cmp1);
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
       $NM_patch   = "MealSint2/grid_persona_enlaces";
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
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
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
       $nm_saida->saida("                 if (tmp == 'p_nombre')\r\n");
       $nm_saida->saida("                 {\r\n");
       $nm_saida->saida("                      var x_p_nombre = i;\r\n");
       $nm_saida->saida("                      $(\"#id_ac_grid_p_nombre\" + i).autocomplete({\r\n");
       $nm_saida->saida("                        minLength: 1,\r\n");
       $nm_saida->saida("                        source: function (request, response) {\r\n");
       $nm_saida->saida("                        $.ajax({\r\n");
       $nm_saida->saida("                          url: \"index.php\",\r\n");
       $nm_saida->saida("                          dataType: \"json\",\r\n");
       $nm_saida->saida("                          data: {\r\n");
       $nm_saida->saida("                             q: request.term,\r\n");
       $nm_saida->saida("                             nmgp_opcao: \"ajax_aut_comp_dyn_search\",\r\n");
       $nm_saida->saida("                             origem: \"grid\",\r\n");
       $nm_saida->saida("                             field: \"p_nombre\",\r\n");
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
       $nm_saida->saida("                          $(\"#grid_search_p_nombre_val_\" + x_p_nombre).val(ui.item.value);\r\n");
       $nm_saida->saida("                          $(this).val(ui.item.label);\r\n");
       $nm_saida->saida("                          event.preventDefault();\r\n");
       $nm_saida->saida("                        },\r\n");
       $nm_saida->saida("                        focus: function (event, ui) {\r\n");
       $nm_saida->saida("                          $(\"#grid_search_p_nombre_val_\" + x_p_nombre).val(ui.item.value);\r\n");
       $nm_saida->saida("                          $(this).val(ui.item.label);\r\n");
       $nm_saida->saida("                          event.preventDefault();\r\n");
       $nm_saida->saida("                        },\r\n");
       $nm_saida->saida("                        change: function (event, ui) {\r\n");
       $nm_saida->saida("                          if (null == ui.item) {\r\n");
       $nm_saida->saida("                             $(\"#grid_search_p_nombre_val_\" + x_p_nombre).val( $(this).val() );\r\n");
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
       $nm_saida->saida("                 if (Tab_obj_grid_search[i] == 'p_idpersona')\r\n");
       $nm_saida->saida("                 {\r\n");
       $nm_saida->saida("                     result  = grid_search_get_text(obj_dyn + i, '');\r\n");
       $nm_saida->saida("                 }\r\n");
       $nm_saida->saida("                 if (Tab_obj_grid_search[i] == 'p_foto')\r\n");
       $nm_saida->saida("                 {\r\n");
       $nm_saida->saida("                     result  = grid_search_get_text(obj_dyn + i, '');\r\n");
       $nm_saida->saida("                 }\r\n");
       $nm_saida->saida("                 if (Tab_obj_grid_search[i] == 'p_nombre')\r\n");
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
       $nm_saida->saida("                 if (Tab_obj_grid_search[i] == 'p_idpersona')\r\n");
       $nm_saida->saida("                 {\r\n");
       $nm_saida->saida("                     result  = grid_search_get_text(obj_dyn + i, '');\r\n");
       $nm_saida->saida("                     str_out += \"SC_\" + Tab_obj_grid_search[i] + \"#NMF#\" + result + \"@NMF@\";\r\n");
       $nm_saida->saida("                 }\r\n");
       $nm_saida->saida("                 if (Tab_obj_grid_search[i] == 'p_foto')\r\n");
       $nm_saida->saida("                 {\r\n");
       $nm_saida->saida("                     result  = grid_search_get_text(obj_dyn + i, '');\r\n");
       $nm_saida->saida("                     str_out += \"SC_\" + Tab_obj_grid_search[i] + \"#NMF#\" + result + \"@NMF@\";\r\n");
       $nm_saida->saida("                 }\r\n");
       $nm_saida->saida("                 if (Tab_obj_grid_search[i] == 'p_nombre')\r\n");
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
//--- 
//--- 
 function grafico_pdf()
 {
   global $nm_saida, $nm_lang;
   require_once($this->Ini->path_aplicacao . $this->Ini->Apl_grafico); 
   $this->Graf  = new grid_persona_enlaces_grafico();
   $this->Graf->Db     = $this->Db;
   $this->Graf->Erro   = $this->Erro;
   $this->Graf->Ini    = $this->Ini;
   $this->Graf->Lookup = $this->Lookup;
   if (!empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['pivot_charts']) && (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['skip_charts']) || !$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['skip_charts']))
   {
       $this->Graf->monta_grafico('', 'pdf_lib');
       $prim_graf = true;
       $nm_saida->saida("<B><div style=\"height:1px;overflow:hidden\"><H1 style=\"font-size:0;padding:1px\">" . $this->Ini->Nm_lang['lang_btns_chrt_pdff_hint'] . "</H1></div></B>\r\n");
       $iChartCount = 1;
       $iChartTotal = sizeof($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['pivot_charts']);
       $sChartLang  = isset($this->Ini->Nm_lang['lang_pdff_pcht']) ? $this->Ini->Nm_lang['lang_pdff_pcht'] : 'Generating chart';
       if (!NM_is_utf8($sChartLang))
       {
           $sChartLang = sc_convert_encoding($sChartLang, "UTF-8", $_SESSION['scriptcase']['charset']);
       }
       $bChartFP = false;
      if (!isset($this->progress_fp) || !$this->progress_fp)
      {
           $bChartFP           = true;
           $str_pbfile         = $this->Ini->root . $this->Ini->path_imag_temp . '/sc_pb_' . session_id() . '.tmp';
           $this->progress_fp  = fopen($str_pbfile, 'a');
           $this->progress_tot = 100;
           $this->progress_now = 90;
           $this->progress_res = 0;
      }
 if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf'] || $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf_vert'])
 { 
           $nm_saida->saida(" <style>\r\n");
            $nm_saida->saida("  table td, table tr{ page-break-inside: avoid !important; }\r\n");
           $nm_saida->saida(" </style>\r\n");
 } 
       $prim_graf = ($this->Ini->SC_module_export == "chart") ? true : false;
       foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['pivot_charts'] as $chart_index => $chart_data)
       {
           if (!$prim_graf)
           {
                   $nm_saida->saida("<div style=\"page-break-after: always;\"><span style=\"display: none;\">&nbsp;</span></div>\r\n");
           }
           $prim_graf = false;
 if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf'] || $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['proc_pdf_vert'])
 { 
           $nm_saida->saida("<table style=\"width: 100%; page-break-inside: avoid !important;\" ><tr><td>\r\n");
 } else {
           $nm_saida->saida("<table><tr><td>\r\n");
 } 
           $tit_graf = $chart_data['title'];
           if ('' != $chart_data['subtitle'])
           {
               $tit_graf .= ' - ' . $chart_data['subtitle'];
           }
           if ('UTF-8' != $_SESSION['scriptcase']['charset'])
           {
               $tit_graf = sc_convert_encoding($tit_graf, $_SESSION['scriptcase']['charset'], 'UTF-8');
           }
           $tit_book_marks = str_replace(" ", "&nbsp;", $tit_graf);
           $random_id = 'sc-id-h2-' . md5(session_id() . microtime() . rand(1, 1000));
           $nm_saida->saida("<b><h2 id=\"$random_id\">$tit_book_marks</h2></b>\r\n");
           if ($this->progress_fp)
           {
               grid_persona_enlaces_pdf_progress_call($this->progress_tot . "_#NM#_" . $this->progress_now . "_#NM#_" . $sChartLang . " " . $iChartCount . "...\n", $this->Ini->Nm_lang, true);
               fwrite($this->progress_fp, $this->progress_now . "_#NM#_" . $sChartLang . " " . $iChartCount . "...\n");
               $iChartCount++;
               if (0 < $this->progress_res)
               {
                   $this->progress_now++;
               }
           }
           $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['this_chart_label'] = '';
           $this->Graf->monta_grafico($chart_index, 'pdf');
           $nm_saida->saida("</td></tr></table>\r\n");
       }
       if ($bChartFP)
       {
           $lang_protect = $this->Ini->Nm_lang['lang_pdff_gnrt'];
           if (!NM_is_utf8($lang_protect))
           {
               $lang_protect = sc_convert_encoding($lang_protect, "UTF-8", $_SESSION['scriptcase']['charset']);
           }
           grid_persona_enlaces_pdf_progress_call(100 . "_#NM#_" . 90 . "_#NM#_" . $lang_protect . "...\n", $this->Ini->Nm_lang);
           fwrite($this->progress_fp, 90 . "_#NM#_" . $lang_protect . "...\n");
           fclose($this->progress_fp);
       }
       if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['charts_html']) && '' != $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['charts_html'])
       {
            $nm_saida->saida("<script type=\"text/javascript\">\r\n");
            $nm_saida->saida("{$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['charts_html']}\r\n");
            $nm_saida->saida("</script>\r\n");
       }
   }
       $nm_saida->saida("</body>\r\n");
       $nm_saida->saida("</HTML>\r\n");
 }
//--- 
//--- 
 function grafico_pdf_flash()
 {
   global $nm_saida, $nm_lang;
   if (!empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['chart_list']))
   {
       foreach ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['chart_list'] as $arr_chart)
       {
           $nm_saida->saida("<div style=\"page-break-after: always;\"><span style=\"display: none;\">&nbsp;</span></div>\r\n");
       $nm_saida->saida("<b><div style=\"height:1px;overflow:hidden\"><H1 style=\"font-size:0;padding:1px\">" . $this->Ini->Nm_lang['lang_btns_chrt_pdff_hint'] . "</H1></div></b>\r\n");
           $nm_saida->saida("<table><tr><td>\r\n");
           $tit_graf       = $arr_chart[1];
           if ('UTF-8' != $_SESSION['scriptcase']['charset'])
           {
               $tit_graf = sc_convert_encoding($tit_graf, $_SESSION['scriptcase']['charset'], 'UTF-8');
           }
           $tit_book_marks = str_replace(" ", "&nbsp;", $tit_graf);
           $nm_saida->saida("<b><h2>$tit_book_marks</h2></b>\r\n");
           $nm_saida->saida("<img src=\"" . $arr_chart[0] . ".png\"/>\r\n");
           $_SESSION['scriptcase']['sc_num_img']++;
           $nm_saida->saida("</td></tr></table>\r\n");
       }
   }
   $nm_saida->saida("</body>\r\n");
   $nm_saida->saida("</HTML>\r\n");
 }
//--- 
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
   if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && isset($_SESSION['sc_session'][$this->Ini->sc_page]['SC_sub_css']))
   {
       unset($_SESSION['sc_session'][$this->Ini->sc_page]['SC_sub_css']);
       unset($_SESSION['sc_session'][$this->Ini->sc_page]['SC_sub_css_bw']);
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'])
   { 
        return;
   } 
   $nm_saida->saida("   </TABLE></TD>\r\n");
   $nm_saida->saida("   </TR>\r\n");
   if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'] && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf" &&
        $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "print" && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao_print'] != "print" && !$this->Print_All) 
   { 
      $nm_saida->saida("     <tr><td colspan=3  class=\"" . $this->css_scGridTabelaTd . "\" style=\"vertical-align: top\"> \r\n");
      $nm_saida->saida("     <iframe class=\"css_iframes\" id=\"nmsc_iframe_liga_B_grid_persona_enlaces\" marginWidth=\"0px\" marginHeight=\"0px\" frameborder=\"0\" valign=\"top\" height=\"0px\" width=\"0px\" name=\"nm_iframe_liga_B_grid_persona_enlaces\" scrolling=\"auto\" src=\"NM_Blank_Page.htm\"></iframe>\r\n");
      $nm_saida->saida("     </td></tr> \r\n");
   } 
   $nm_saida->saida("   </TABLE>\r\n");
   $nm_saida->saida("   </div>\r\n");
   $nm_saida->saida("   </TR>\r\n");
   $nm_saida->saida("   </TD>\r\n");
   $nm_saida->saida("   </TABLE>\r\n");
   $nm_saida->saida("   <div id=\"sc-id-fixedheaders-placeholder\" style=\"display: none; position: fixed; top: 0\"></div>\r\n");
   $nm_saida->saida("   </body>\r\n");
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] == "pdf" || $this->Print_All)
   { 
   $nm_saida->saida("   </HTML>\r\n");
        return;
   } 
   $nm_saida->saida("   <script type=\"text/javascript\">\r\n");
   $nm_saida->saida("   NM_ancor_ult_lig = '';\r\n");
   if (!$_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['embutida'])
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
               if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
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
                       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
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
   if ($this->Rec_ini == 0 && empty($this->nm_grid_sem_reg) && !$this->Print_All && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf" && !$_SESSION['scriptcase']['proc_mobile'])
   { 
       $nm_saida->saida("   document.getElementById('first_bot').disabled = true;\r\n");
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
       {
           $this->Ini->Arr_result['setDisabled'][] = array('field' => 'first_bot', 'value' => "true");
       }
       $nm_saida->saida("   document.getElementById('back_bot').disabled = true;\r\n");
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
       {
           $this->Ini->Arr_result['setDisabled'][] = array('field' => 'back_bot', 'value' => "true");
       }
   } 
   elseif ($this->Rec_ini == 0 && empty($this->nm_grid_sem_reg) && !$this->Print_All && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf" && $_SESSION['scriptcase']['proc_mobile'])
   { 
       $nm_saida->saida("   document.getElementById('first_bot').disabled = true;\r\n");
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
       {
           $this->Ini->Arr_result['setDisabled'][] = array('field' => 'first_bot', 'value' => "true");
       }
       $nm_saida->saida("   document.getElementById('back_bot').disabled = true;\r\n");
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
       {
           $this->Ini->Arr_result['setDisabled'][] = array('field' => 'back_bot', 'value' => "true");
       }
   } 
   $nm_saida->saida("  $(window).scroll(function() {\r\n");
   $nm_saida->saida("   if (typeof(scSetFixedHeaders) === typeof(function(){})) scSetFixedHeaders();\r\n");
   $nm_saida->saida("  }).resize(function() {\r\n");
   $nm_saida->saida("   if (typeof(scSetFixedHeaders) === typeof(function(){})) scSetFixedHeaders();\r\n");
   $nm_saida->saida("  });\r\n");
   if ($this->rs_grid->EOF && empty($this->nm_grid_sem_reg) && !$this->Print_All && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf")
   {
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf" && !isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_liga']['nav']) && !$_SESSION['scriptcase']['proc_mobile'])
       { 
           { 
               $nm_saida->saida("   document.getElementById('forward_bot').disabled = true;\r\n");
               $nm_saida->saida("   document.getElementById('forward_bot').className = \"scButton_" . $this->arr_buttons['bcons_avanca']['style'] . " disabled\";\r\n");
               if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
               {
                   $this->Ini->Arr_result['setDisabled'][] = array('field' => 'forward_bot', 'value' => "true");
                   $this->Ini->Arr_result['setClass'][] = array('field' => 'forward_bot', 'value' => "scButton_" . $this->arr_buttons['bcons_avanca']['style'] . ' disabled');
               }
               if ($this->arr_buttons['bcons_avanca']['display'] == 'only_img' || $this->arr_buttons['bcons_avanca']['display'] == 'text_img')
               { 
                   $nm_saida->saida("   document.getElementById('id_img_forward_bot').src = \"" . $this->Ini->path_botoes . "/" . $this->arr_buttons['bcons_avanca']['image'] . "\";\r\n");
                   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
                   {
                       $this->Ini->Arr_result['setSrc'][] = array('field' => 'id_img_forward_bot', 'value' => $this->Ini->path_botoes . "/" . $this->arr_buttons['bcons_avanca']['image']);
                   }
               } 
           } 
           { 
               $nm_saida->saida("   document.getElementById('last_bot').disabled = true;\r\n");
               $nm_saida->saida("   document.getElementById('last_bot').className = \"scButton_" . $this->arr_buttons['bcons_final']['style'] . " disabled\";\r\n");
               if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
               {
                  $this->Ini->Arr_result['setDisabled'][] = array('field' => 'last_bot', 'value' => "true");
                  $this->Ini->Arr_result['setClass'][] = array('field' => 'last_bot', 'value' => "scButton_" . $this->arr_buttons['bcons_final']['style'] . ' disabled');
               }
               if ($this->arr_buttons['bcons_final']['display'] == 'only_img' || $this->arr_buttons['bcons_final']['display'] == 'text_img')
               { 
                   $nm_saida->saida("   document.getElementById('id_img_last_bot').src = \"" . $this->Ini->path_botoes . "/" . $this->arr_buttons['bcons_final']['image'] . "\";\r\n");
                   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
                   {
                       $this->Ini->Arr_result['setSrc'][] = array('field' => 'id_img_last_bot', 'value' => $this->Ini->path_botoes . "/" . $this->arr_buttons['bcons_final']['image']);
                   }
               } 
           } 
       } 
       elseif ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opcao'] != "pdf" && !isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['opc_liga']['nav']) && $_SESSION['scriptcase']['proc_mobile'])
       { 
           { 
               $nm_saida->saida("   document.getElementById('forward_bot').disabled = true;\r\n");
               $nm_saida->saida("   document.getElementById('forward_bot').className = \"scButton_" . $this->arr_buttons['bcons_avanca']['style'] . " disabled\";\r\n");
               if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
               {
                   $this->Ini->Arr_result['setDisabled'][] = array('field' => 'forward_bot', 'value' => "true");
                   $this->Ini->Arr_result['setClass'][] = array('field' => 'forward_bot', 'value' => "scButton_" . $this->arr_buttons['bcons_avanca']['style'] . ' disabled');
               }
               if ($this->arr_buttons['bcons_avanca']['display'] == 'only_img' || $this->arr_buttons['bcons_avanca']['display'] == 'text_img')
               { 
                   $nm_saida->saida("   document.getElementById('id_img_forward_bot').src = \"" . $this->Ini->path_botoes . "/" . $this->arr_buttons['bcons_avanca']['image'] . "\";\r\n");
                   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
                   {
                       $this->Ini->Arr_result['setSrc'][] = array('field' => 'id_img_forward_bot', 'value' => $this->Ini->path_botoes . "/" . $this->arr_buttons['bcons_avanca']['image']);
                   }
               } 
           } 
           { 
               $nm_saida->saida("   document.getElementById('last_bot').disabled = true;\r\n");
               $nm_saida->saida("   document.getElementById('last_bot').className = \"scButton_" . $this->arr_buttons['bcons_final']['style'] . " disabled\";\r\n");
               if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
               {
                  $this->Ini->Arr_result['setDisabled'][] = array('field' => 'last_bot', 'value' => "true");
                  $this->Ini->Arr_result['setClass'][] = array('field' => 'last_bot', 'value' => "scButton_" . $this->arr_buttons['bcons_final']['style'] . ' disabled');
               }
               if ($this->arr_buttons['bcons_final']['display'] == 'only_img' || $this->arr_buttons['bcons_final']['display'] == 'text_img')
               { 
                   $nm_saida->saida("   document.getElementById('id_img_last_bot').src = \"" . $this->Ini->path_botoes . "/" . $this->arr_buttons['bcons_final']['image'] . "\";\r\n");
                   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
                   {
                       $this->Ini->Arr_result['setSrc'][] = array('field' => 'id_img_last_bot', 'value' => $this->Ini->path_botoes . "/" . $this->arr_buttons['bcons_final']['image']);
                   }
               } 
           } 
       } 
       $nm_saida->saida("   nm_gp_fim = \"fim\";\r\n");
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
       {
           $this->Ini->Arr_result['setVar'][] = array('var' => 'nm_gp_fim', 'value' => "fim");
           $this->Ini->Arr_result['scrollEOF'] = true;
       }
   }
   else
   {
       $nm_saida->saida("   nm_gp_fim = \"\";\r\n");
       if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
       {
           $this->Ini->Arr_result['setVar'][] = array('var' => 'nm_gp_fim', 'value' => "");
       }
   }
   if (isset($this->redir_modal) && !empty($this->redir_modal))
   {
       echo $this->redir_modal;
   }
   $nm_saida->saida("   </script>\r\n");
   if ($this->grid_emb_form || $this->grid_emb_form_full)
   {
       $nm_saida->saida("   <script type=\"text/javascript\">\r\n");
       $nm_saida->saida("      window.onload = function() {\r\n");
       $nm_saida->saida("         setTimeout(\"parent.scAjaxDetailHeight('grid_persona_enlaces', $(document).innerHeight())\",50);\r\n");
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
   $nm_saida->saida("    <input type=\"hidden\" name=\"SC_lig_apl_orig\" value=\"grid_persona_enlaces\"/>\r\n");
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
   $nm_saida->saida("                     action=\"grid_persona_enlaces_pesq.class.php\" \r\n");
   $nm_saida->saida("                     target=\"_self\" style=\"display: none\"> \r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"script_case_init\" value=\"" . NM_encode_input($this->Ini->sc_page) . "\"/> \r\n");
   $nm_saida->saida("   </form> \r\n");
   $nm_saida->saida("   <form name=\"F6\" method=\"post\" \r\n");
   $nm_saida->saida("                     action=\"./\" \r\n");
   $nm_saida->saida("                     target=\"_self\" style=\"display: none\"> \r\n");
   $nm_saida->saida("    <input type=\"hidden\" name=\"script_case_init\" value=\"" . NM_encode_input($this->Ini->sc_page) . "\"/> \r\n");
   $nm_saida->saida("   </form> \r\n");
   $nm_saida->saida("   <form name=\"Fprint\" method=\"post\" \r\n");
   $nm_saida->saida("                     action=\"grid_persona_enlaces_iframe_prt.php\" \r\n");
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
   $nm_saida->saida("               nm_submit_modal(\"" . $this->Ini->path_link . "grid_persona_enlaces/grid_persona_enlaces_export_email.php?script_case_init={$this->Ini->sc_page}&path_img={$this->Ini->path_img_global}&path_btn={$this->Ini->path_botoes}&sType=\"+ str_type +\"&sAdd=__E__nmgp_cor_word=\" + cor + \"__E__SC_module_export=\" + SC_module_export + \"__E__nmgp_password=\" + password + \"&KeepThis=true&TB_iframe=true&modal=true\", bol_param);\r\n");
   $nm_saida->saida("       }\r\n");
   $nm_saida->saida("       else\r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           document.Fdoc_word.nmgp_cor_word.value = cor;\r\n");
   $nm_saida->saida("           document.Fdoc_word.nmgp_password.value = password;\r\n");
   $nm_saida->saida("           document.Fdoc_word.SC_module_export.value = SC_module_export;\r\n");
   $nm_saida->saida("           document.Fdoc_word.action = \"grid_persona_enlaces_export_ctrl.php\";\r\n");
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
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['ajax_nav'])
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
   $nm_saida->saida("   function nm_gp_submit1(apl_lig, apl_saida, parms, target, apl_name) \r\n");
   $nm_saida->saida("   { \r\n");
   $nm_saida->saida("      document.F3.target               = \"_self\"; \r\n");
   $nm_saida->saida("      if (target != null) \r\n");
   $nm_saida->saida("      {\r\n");
   $nm_saida->saida("          document.F3.target = target; \r\n");
   $nm_saida->saida("      }\r\n");
   $nm_saida->saida("      document.F3.action               = apl_lig  ;\r\n");
   $nm_saida->saida("      document.F3.nmgp_url_saida.value = apl_saida ;\r\n");
   $nm_saida->saida("      document.F3.nmgp_chave.value     = \"\" ;\r\n");
   $nm_saida->saida("      document.F3.nmgp_opcao.value     = \"edit_novo\" ;\r\n");
   $nm_saida->saida("      document.F3.nmgp_parms.value     = parms ;\r\n");
   $nm_saida->saida("      if (target == '_blank') \r\n");
   $nm_saida->saida("      {\r\n");
   $nm_saida->saida("          document.F3.nmgp_outra_jan.value = \"true\" ;\r\n");
   $nm_saida->saida("         window.open('','jan_sc','location=no,menubar=no,resizable,scrollbars,status=no,toolbar=no');\r\n");
   $nm_saida->saida("          document.F3.target = \"jan_sc\"; \r\n");
   $nm_saida->saida("      }\r\n");
   $nm_saida->saida("      document.F3.submit() ;\r\n");
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
   $nm_saida->saida("          par_modal = '?&nmgp_outra_jan=true&nmgp_url_saida=modal&SC_lig_apl_orig=grid_persona_enlaces';\r\n");
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
   $nm_saida->saida("      if (pos == \"A\") {obj = document.getElementById('nmsc_iframe_liga_A_grid_persona_enlaces');} \r\n");
   $nm_saida->saida("      if (pos == \"B\") {obj = document.getElementById('nmsc_iframe_liga_B_grid_persona_enlaces');} \r\n");
   $nm_saida->saida("      if (pos == \"E\") {obj = document.getElementById('nmsc_iframe_liga_E_grid_persona_enlaces');} \r\n");
   $nm_saida->saida("      if (pos == \"D\") {obj = document.getElementById('nmsc_iframe_liga_D_grid_persona_enlaces');} \r\n");
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
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['grid_persona_enlaces_iframe_params'] = array(
       'str_tmp'          => $this->Ini->path_imag_temp,
       'str_prod'         => $this->Ini->path_prod,
       'str_btn'          => $this->Ini->Str_btn_css,
       'str_lang'         => $this->Ini->str_lang,
       'str_schema'       => $this->Ini->str_schema_all,
       'str_google_fonts' => $this->Ini->str_google_fonts,
   );
   $prep_parm_pdf = "scsess?#?" . session_id() . "?@?str_tmp?#?" . $this->Ini->path_imag_temp . "?@?str_prod?#?" . $this->Ini->path_prod . "?@?str_btn?#?" . $this->Ini->Str_btn_css . "?@?str_lang?#?" . $this->Ini->str_lang . "?@?str_schema?#?"  . $this->Ini->str_schema_all . "?@?script_case_init?#?" . $this->Ini->sc_page . "?@?jspath?#?" . $this->Ini->path_js . "?#?";
   $Md5_pdf    = "@SC_par@" . NM_encode_input($this->Ini->sc_page) . "@SC_par@grid_persona_enlaces@SC_par@" . md5($prep_parm_pdf);
   $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['Md5_pdf'][md5($prep_parm_pdf)] = $prep_parm_pdf;
   $nm_saida->saida("       if (\"pdf\" == x)\r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           if (\"S\" == ajax)\r\n");
   $nm_saida->saida("           {\r\n");
   $nm_saida->saida("               $('#TB_window').remove();\r\n");
   $nm_saida->saida("               $('body').append(\"<div id='TB_window'></div>\");\r\n");
   $nm_saida->saida("               nm_submit_modal(\"" . $this->Ini->path_link . "grid_persona_enlaces/grid_persona_enlaces_export_email.php?script_case_init={$this->Ini->sc_page}&path_img={$this->Ini->path_img_global}&path_btn={$this->Ini->path_botoes}&sType=pdf&sAdd=__E__nmgp_tipo_pdf=\" + z + \"__E__sc_parms_pdf=\" + p + \"__E__sc_create_charts=\" + crt + \"__E__sc_graf_pdf=\" + g + \"__E__chart_level=\" + chart_level + \"__E__page_break_pdf=\" + page_break_pdf + \"__E__SC_module_export=\" + SC_module_export + \"__E__use_pass_pdf=\" + use_pass_pdf + \"__E__pdf_all_cab=\" + pdf_all_cab + \"__E__pdf_all_label=\" +  pdf_all_label + \"__E__pdf_label_group=\" +  pdf_label_group + \"__E__pdf_zip=\" +  pdf_zip + \"&nm_opc=pdf&KeepThis=true&TB_iframe=true&modal=true\", '');\r\n");
   $nm_saida->saida("           }\r\n");
   $nm_saida->saida("           else\r\n");
   $nm_saida->saida("           {\r\n");
   $nm_saida->saida("               window.location = \"" . $this->Ini->path_link . "grid_persona_enlaces/grid_persona_enlaces_iframe.php?nmgp_parms=" . $Md5_pdf . "&sc_tp_pdf=\" + z + \"&sc_parms_pdf=\" + p + \"&sc_create_charts=\" + crt + \"&sc_graf_pdf=\" + g + '&chart_level=' + chart_level + '&page_break_pdf=' + page_break_pdf + '&SC_module_export=' + SC_module_export + '&use_pass_pdf=' + use_pass_pdf + '&pdf_all_cab=' + pdf_all_cab + '&pdf_all_label=' +  pdf_all_label + '&pdf_label_group=' +  pdf_label_group + '&pdf_zip=' +  pdf_zip;\r\n");
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
   $nm_saida->saida("               nm_submit_modal(\"" . $this->Ini->path_link . "grid_persona_enlaces/grid_persona_enlaces_export_email.php?script_case_init={$this->Ini->sc_page}&path_img={$this->Ini->path_img_global}&path_btn={$this->Ini->path_botoes}&sType=\"+ str_type +\"&sAdd=__E__nmgp_tipo_print=\" + tp + \"__E__cor_print=\" + cor + \"__E__SC_module_export=\" + SC_module_export + \"__E__nmgp_password=\" + password + \"&KeepThis=true&TB_iframe=true&modal=true\", bol_param);\r\n");
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
   $nm_saida->saida("               document.Fprint.action = \"grid_persona_enlaces_export_ctrl.php\";\r\n");
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
   $nm_saida->saida("               nm_submit_modal(\"" . $this->Ini->path_link . "grid_persona_enlaces/grid_persona_enlaces_export_email.php?script_case_init={$this->Ini->sc_page}&path_img={$this->Ini->path_img_global}&path_btn={$this->Ini->path_botoes}&sType=\" + str_type +\"&sAdd=__E__SC_module_export=\" + SC_module_export + \"__E__nmgp_tp_xls=\" + tp_xls + \"__E__nmgp_tot_xls=\" + tot_xls + \"__E__nmgp_password=\" + password + \"&KeepThis=true&TB_iframe=true&modal=true\", bol_param);\r\n");
   $nm_saida->saida("       }\r\n");
   $nm_saida->saida("       else\r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           document.Fexport.nmgp_opcao.value = \"xls\";\r\n");
   $nm_saida->saida("           document.Fexport.nmgp_tp_xls.value = tp_xls;\r\n");
   $nm_saida->saida("           document.Fexport.nmgp_tot_xls.value = tot_xls;\r\n");
   $nm_saida->saida("           document.Fexport.nmgp_password.value = password;\r\n");
   $nm_saida->saida("           document.Fexport.SC_module_export.value = SC_module_export;\r\n");
   $nm_saida->saida("           document.Fexport.action = \"grid_persona_enlaces_export_ctrl.php\";\r\n");
   $nm_saida->saida("           document.Fexport.submit() ;\r\n");
   $nm_saida->saida("       }\r\n");
   $nm_saida->saida("   }\r\n");
   $nm_saida->saida("   function nm_gp_csv_conf(delim_line, delim_col, delim_dados, label_csv, SC_module_export, password, ajax, str_type, bol_param)\r\n");
   $nm_saida->saida("   {\r\n");
   $nm_saida->saida("       if (\"S\" == ajax)\r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           $('#TB_window').remove();\r\n");
   $nm_saida->saida("           $('body').append(\"<div id='TB_window'></div>\");\r\n");
   $nm_saida->saida("               nm_submit_modal(\"" . $this->Ini->path_link . "grid_persona_enlaces/grid_persona_enlaces_export_email.php?script_case_init={$this->Ini->sc_page}&path_img={$this->Ini->path_img_global}&path_btn={$this->Ini->path_botoes}&sType=\" + str_type +\"&sAdd=__E__nm_delim_line=\" + delim_line + \"__E__nm_delim_col=\" + delim_col + \"__E__nm_delim_dados=\" + delim_dados + \"__E__nm_label_csv=\" + label_csv + \"&KeepThis=true&TB_iframe=true&modal=true\", bol_param);\r\n");
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
   $nm_saida->saida("           document.Fexport.action = \"grid_persona_enlaces_export_ctrl.php\";\r\n");
   $nm_saida->saida("           document.Fexport.submit() ;\r\n");
   $nm_saida->saida("       }\r\n");
   $nm_saida->saida("   }\r\n");
   $nm_saida->saida("   function nm_gp_xml_conf(xml_tag, xml_label, SC_module_export, password, ajax, str_type, bol_param)\r\n");
   $nm_saida->saida("   {\r\n");
   $nm_saida->saida("       if (\"S\" == ajax)\r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           $('#TB_window').remove();\r\n");
   $nm_saida->saida("           $('body').append(\"<div id='TB_window'></div>\");\r\n");
   $nm_saida->saida("               nm_submit_modal(\"" . $this->Ini->path_link . "grid_persona_enlaces/grid_persona_enlaces_export_email.php?script_case_init={$this->Ini->sc_page}&path_img={$this->Ini->path_img_global}&path_btn={$this->Ini->path_botoes}&sType=\" + str_type +\"&sAdd=__E__nm_xml_tag=\" + xml_tag + \"__E__nm_xml_label=\" + xml_label + \"&KeepThis=true&TB_iframe=true&modal=true\", bol_param);\r\n");
   $nm_saida->saida("       }\r\n");
   $nm_saida->saida("       else\r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           document.Fexport.nmgp_opcao.value   = \"xml\";\r\n");
   $nm_saida->saida("           document.Fexport.nm_xml_tag.value   = xml_tag;\r\n");
   $nm_saida->saida("           document.Fexport.nm_xml_label.value = xml_label;\r\n");
   $nm_saida->saida("           document.Fexport.nmgp_password.value = password;\r\n");
   $nm_saida->saida("           document.Fexport.SC_module_export.value = SC_module_export;\r\n");
   $nm_saida->saida("           document.Fexport.action = \"grid_persona_enlaces_export_ctrl.php\";\r\n");
   $nm_saida->saida("           document.Fexport.submit() ;\r\n");
   $nm_saida->saida("       }\r\n");
   $nm_saida->saida("   }\r\n");
   $nm_saida->saida("   function nm_gp_json_conf(json_format, json_label, SC_module_export, password, ajax, str_type, bol_param)\r\n");
   $nm_saida->saida("   {\r\n");
   $nm_saida->saida("       if (\"S\" == ajax)\r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           $('#TB_window').remove();\r\n");
   $nm_saida->saida("           $('body').append(\"<div id='TB_window'></div>\");\r\n");
   $nm_saida->saida("               nm_submit_modal(\"" . $this->Ini->path_link . "grid_persona_enlaces/grid_persona_enlaces_export_email.php?script_case_init={$this->Ini->sc_page}&path_img={$this->Ini->path_img_global}&path_btn={$this->Ini->path_botoes}&sType=\" + str_type +\"&sAdd=__E__nm_json_format=\" + json_format + \"__E__nm_json_label=\" + json_label + \"&KeepThis=true&TB_iframe=true&modal=true\", bol_param);\r\n");
   $nm_saida->saida("       }\r\n");
   $nm_saida->saida("       else\r\n");
   $nm_saida->saida("       {\r\n");
   $nm_saida->saida("           document.Fexport.nmgp_opcao.value       = \"json\";\r\n");
   $nm_saida->saida("           document.Fexport.nm_json_format.value   = json_format;\r\n");
   $nm_saida->saida("           document.Fexport.nm_json_label.value    = json_label;\r\n");
   $nm_saida->saida("           document.Fexport.nmgp_password.value    = password;\r\n");
   $nm_saida->saida("           document.Fexport.SC_module_export.value = SC_module_export;\r\n");
   $nm_saida->saida("           document.Fexport.action = \"grid_persona_enlaces_export_ctrl.php\";\r\n");
   $nm_saida->saida("           document.Fexport.submit() ;\r\n");
   $nm_saida->saida("       }\r\n");
   $nm_saida->saida("   }\r\n");
   $nm_saida->saida("   function nm_gp_rtf_conf()\r\n");
   $nm_saida->saida("   {\r\n");
   $nm_saida->saida("       document.Fexport.nmgp_opcao.value   = \"rtf\";\r\n");
   $nm_saida->saida("       document.Fexport.action = \"grid_persona_enlaces_export_ctrl.php\";\r\n");
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
   if (!empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['form_psq_ret']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['campo_psq_ret']) )
   {
      $nm_saida->saida("      if (document.Fpesq.nm_ret_psq.value != \"\")\r\n");
      $nm_saida->saida("      {\r\n");
      if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['sc_modal']) && $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['sc_modal'])
      {
         if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['iframe_ret_cap']))
         {
             $Iframe_cap = $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['iframe_ret_cap'];
             unset($_SESSION['sc_session'][$script_case_init]['grid_persona_enlaces']['iframe_ret_cap']);
             $nm_saida->saida("           var Obj_Form  = parent.document.getElementById('" . $Iframe_cap . "').contentWindow.document." . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['form_psq_ret'] . "." . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['campo_psq_ret'] . ";\r\n");
             $nm_saida->saida("           var Obj_Form1 = parent.document.getElementById('" . $Iframe_cap . "').contentWindow.document." . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['form_psq_ret'] . "." . str_replace("_autocomp", "_", $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['campo_psq_ret']) . ";\r\n");
             $nm_saida->saida("           var Obj_Doc   = parent.document.getElementById('" . $Iframe_cap . "').contentWindow;\r\n");
             $nm_saida->saida("           if (parent.document.getElementById('" . $Iframe_cap . "').contentWindow.document.getElementById(\"id_read_on_" . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['campo_psq_ret'] . "\"))\r\n");
             $nm_saida->saida("           {\r\n");
             $nm_saida->saida("               var Obj_Readonly = parent.document.getElementById('" . $Iframe_cap . "').contentWindow.document.getElementById(\"id_read_on_" . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['campo_psq_ret'] . "\");\r\n");
             $nm_saida->saida("           }\r\n");
         }
         else
         {
             $nm_saida->saida("          var Obj_Form  = parent.document." . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['form_psq_ret'] . "." . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['campo_psq_ret'] . ";\r\n");
             $nm_saida->saida("          var Obj_Form1 = parent.document." . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['form_psq_ret'] . "." . str_replace("_autocomp", "_", $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['campo_psq_ret']) . ";\r\n");
             $nm_saida->saida("          var Obj_Doc   = parent;\r\n");
             $nm_saida->saida("          if (parent.document.getElementById(\"id_read_on_" . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['campo_psq_ret'] . "\"))\r\n");
             $nm_saida->saida("          {\r\n");
             $nm_saida->saida("              var Obj_Readonly = parent.document.getElementById(\"id_read_on_" . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['campo_psq_ret'] . "\");\r\n");
             $nm_saida->saida("          }\r\n");
         }
      }
      else
      {
          $nm_saida->saida("          var Obj_Form  = opener.document." . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['form_psq_ret'] . "." . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['campo_psq_ret'] . ";\r\n");
          $nm_saida->saida("          var Obj_Form1 = opener.document." . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['form_psq_ret'] . "." . str_replace("_autocomp", "_", $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['campo_psq_ret']) . ";\r\n");
          $nm_saida->saida("          var Obj_Doc   = opener;\r\n");
          $nm_saida->saida("          if (opener.document.getElementById(\"id_read_on_" . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['campo_psq_ret'] . "\"))\r\n");
          $nm_saida->saida("          {\r\n");
          $nm_saida->saida("              var Obj_Readonly = opener.document.getElementById(\"id_read_on_" . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['campo_psq_ret'] . "\");\r\n");
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
     if (!empty($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['js_apos_busca']))
     {
      $nm_saida->saida("              if (Obj_Doc." . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['js_apos_busca'] . ")\r\n");
      $nm_saida->saida("              {\r\n");
      $nm_saida->saida("                  Obj_Doc." . $_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['js_apos_busca'] . "();\r\n");
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
   $nm_saida->saida("      document.F5.action = \"grid_persona_enlaces_fim.php\";\r\n");
   $nm_saida->saida("      document.F5.submit();\r\n");
   $nm_saida->saida("   }\r\n");
   $nm_saida->saida("   function nm_open_popup(parms)\r\n");
   $nm_saida->saida("   {\r\n");
   $nm_saida->saida("       NovaJanela = window.open (parms, '', 'resizable, scrollbars');\r\n");
   $nm_saida->saida("   }\r\n");
   if (($this->grid_emb_form || $this->grid_emb_form_full) && isset($_SESSION['sc_session'][$this->Ini->sc_page]['grid_persona_enlaces']['reg_start']))
   {
       $nm_saida->saida("      $(document).ready(function(){\r\n");
       $nm_saida->saida("         setTimeout(\"parent.scAjaxDetailStatus('grid_persona_enlaces')\",50);\r\n");
       $nm_saida->saida("         setTimeout(\"parent.scAjaxDetailHeight('grid_persona_enlaces', $(document).innerHeight())\",50);\r\n");
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
