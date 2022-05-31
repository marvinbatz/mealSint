<?php
class pdfreport_consentimiento_lookup
{
//  
   function lookup_idproyecto(&$conteudo , $idproyecto) 
   {   
      static $save_conteudo = "" ; 
      static $save_conteudo1 = "" ; 
      $tst_cache = $idproyecto; 
      if ($tst_cache === $save_conteudo && $conteudo != "") 
      { 
          $conteudo = $save_conteudo1 ; 
          return ; 
      } 
      $save_conteudo = $tst_cache ; 
      if (trim($idproyecto) === "" || trim($idproyecto) == "&nbsp;")
      { 
          $conteudo = "";
          $save_conteudo  = ""; 
          $save_conteudo1 = ""; 
          return ; 
      } 
      $nm_comando = "select concat(SUBSTRING(nombreP, 1, 90), \"-\") from proyecto where idProyecto = '$idproyecto' order by codigoC, nombreP" ; 
      $conteudo = "" ; 
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_comando; 
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
      if ($rx = $this->Db->Execute($nm_comando)) 
      { 
          if (isset($rx->fields[0]))  
          { 
              $conteudo = trim($rx->fields[0]); 
          } 
          $conteudo = sc_strtolower($conteudo);
          $conteudo = ucfirst($conteudo);
          $save_conteudo1 = $conteudo ; 
          $rx->Close(); 
      } 
      elseif ($GLOBALS["NM_ERRO_IBASE"] != 1)  
      { 
          $this->Erro->mensagem(__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg()); 
          exit; 
      } 
      if ($conteudo === "") 
      { 
          $conteudo = "";
          $save_conteudo1 = $conteudo ; 
      } 
   }  
//  
   function lookup_idproyecto_1(&$conteudo , $idproyecto_1) 
   {   
      static $save_conteudo = "" ; 
      static $save_conteudo1 = "" ; 
      $tst_cache = $idproyecto_1; 
      if ($tst_cache === $save_conteudo && $conteudo != "") 
      { 
          $conteudo = $save_conteudo1 ; 
          return ; 
      } 
      $save_conteudo = $tst_cache ; 
      if (trim($idproyecto_1) === "" || trim($idproyecto_1) == "&nbsp;")
      { 
          $conteudo = "";
          $save_conteudo  = ""; 
          $save_conteudo1 = ""; 
          return ; 
      } 
      $nm_comando = "select CONCAT(SUBSTRING(nombreP, 91, 180),\"-\") from proyecto where idProyecto = $idproyecto_1 order by nombreP" ; 
      $conteudo = "" ; 
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_comando; 
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
      if ($rx = $this->Db->Execute($nm_comando)) 
      { 
          if (isset($rx->fields[0]))  
          { 
              $conteudo = trim($rx->fields[0]); 
          } 
          $conteudo = sc_strtolower($conteudo);
          $save_conteudo1 = $conteudo ; 
          $rx->Close(); 
      } 
      elseif ($GLOBALS["NM_ERRO_IBASE"] != 1)  
      { 
          $this->Erro->mensagem(__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg()); 
          exit; 
      } 
      if ($conteudo === "") 
      { 
          $conteudo = "";
          $save_conteudo1 = $conteudo ; 
      } 
   }  
//  
   function lookup_idproyecto_2(&$conteudo , $idproyecto_2) 
   {   
      static $save_conteudo = "" ; 
      static $save_conteudo1 = "" ; 
      $tst_cache = $idproyecto_2; 
      if ($tst_cache === $save_conteudo && $conteudo != "") 
      { 
          $conteudo = $save_conteudo1 ; 
          return ; 
      } 
      $save_conteudo = $tst_cache ; 
      if (trim($idproyecto_2) === "" || trim($idproyecto_2) == "&nbsp;")
      { 
          $conteudo = "";
          $save_conteudo  = ""; 
          $save_conteudo1 = ""; 
          return ; 
      } 
      $nm_comando = "select SUBSTRING(nombreP, 181, 270) from proyecto where idProyecto = $idproyecto_2 order by nombreP" ; 
      $conteudo = "" ; 
      $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nm_comando; 
      $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
      if ($rx = $this->Db->Execute($nm_comando)) 
      { 
          if (isset($rx->fields[0]))  
          { 
              $conteudo = trim($rx->fields[0]); 
          } 
          $conteudo = sc_strtolower($conteudo);
          $save_conteudo1 = $conteudo ; 
          $rx->Close(); 
      } 
      elseif ($GLOBALS["NM_ERRO_IBASE"] != 1)  
      { 
          $this->Erro->mensagem(__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg()); 
          exit; 
      } 
      if ($conteudo === "") 
      { 
          $conteudo = "";
          $save_conteudo1 = $conteudo ; 
      } 
   }  
}
?>
