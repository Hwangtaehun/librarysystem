<script language='javascript'>
var a = 'abc' ; 
</script>
<?php
$A = "<script>document.write (a);</script>" ;
?>
<?php
echo $A ;
?>