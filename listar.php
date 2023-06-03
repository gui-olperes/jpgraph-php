<?php
 $pasta = '../Examples';

 if(is_dir($pasta))
 {
  $diretorio = dir($pasta);

  echo '<h1>Gerando gráficos com jpgraph</h1>';
  
  while(($arquivo = $diretorio->read()) !== false)
  {
   if(substr($arquivo,-5)== 'o.php'){
   //echo '<p>'.$arquivo.'</p>';	
   echo '<iframe style="height:400px;width:500px;" src="'.$arquivo.'"></iframe>';
   }
   
  }

  $diretorio->close();
 }
 else
 {
  echo 'A pasta não existe.';
 }
?>