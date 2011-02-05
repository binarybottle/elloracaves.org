
// Idea by:  Nic Wolfe (Nic@TimelapseProductions.com)
// Web URL:  http://fineline.xs.mw
// http://javascript.internet.com/generators/popup-window.html
function popup(mylink, windowname)                   
{
   if (! window.focus)return true;
      var href;
      if (typeof(mylink) == 'string')
         href=mylink;
      else
         href=mylink.href;
         window.open(href, windowname, 'toolbar=1,statusbar=1,menubar=1,scrollbars=1,location=1,width=900,height=900,left=20,right=20,resizable=1'); 
         return false;
}
