
<script type="text/javascript">

function popup(mylink, windowname)
{
   if (! window.focus)return true;
      var href;
      if (typeof(mylink) == 'string')
         href=mylink;
      else
         href=mylink.href;
         window.open(href, windowname, 'width=880,height=880,left=100,right=100,resizable=yes,scrollbars=yes');
         return false;
}

</script>


