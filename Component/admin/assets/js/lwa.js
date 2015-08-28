/**
* LivingWord Component
* 
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
function setNTAOptions(){
var av = document.getElementById('config_audio_version');
var bv = document.getElementById('config_bible_version');
var selPlan = document.getElementById('config_bible_plan');
var selIndex = bv.selectedIndex;
if(selPlan.value == 0){
document.adminForm.selplan.value = selPlan.selectedIndex;
}
var title = bv.options[selIndex].title;
titlearray = title.split(/;/);
var nt = titlearray[0];
var audio = titlearray[1];
var avt = titlearray[2];
av.value = avt;
var a = optionTmp;
if(audio == 0){
  if( nt == 1 ){
    selPlan.options.length = 0;
    selPlan.options[selPlan.options.length] = new Option(selectbp,0);
    selPlan.options[selPlan.options.length] = new Option(a[6][0],a[6][1]);
  }
  else {
    selPlan.options.length = 0;
    for(i=0;i<7;i++){
    selPlan.options[i] = new Option(a[i][0],a[i][1]);
    }
  }
}
else {
  if( nt == 1 ){
    selPlan.options.length = 0;
    selPlan.options[selPlan.options.length] = new Option(selectbp,0);
    selPlan.options[selPlan.options.length] = new Option(a[10][0],a[10][1]);
  }
  else {
    selPlan.options.length = 0;
    selPlan.options[selPlan.options.length] = new Option(selectbp,0);
    for(i=1,j=7;j<11;j++,i++){
    selPlan.options[i] = new Option(a[j][0],a[j][1]);
    }
  }
}
selPlan.selectedIndex = 0;
return true;
}