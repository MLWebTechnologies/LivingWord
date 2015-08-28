// ******************************************************************************
// Title          LivingWord Bible Reading Plan Component for Joomla
// Author         Mike Leeper
// Version        3.x
// Copyright      © by Mike Leeper
// License        This is free software and you may redistribute it under the GPL.
//                LivingWord Bible Reading Plan comes with absolutely no warranty. 
//                For details, see the license at http://www.gnu.org/licenses/gpl.txt
//                YOU ARE NOT REQUIRED TO KEEP COPYRIGHT NOTICES IN
//                THE HTML OUTPUT OF THIS SCRIPT. YOU ARE NOT ALLOWED
//                TO REMOVE COPYRIGHT NOTICES FROM THE SOURCE CODE.
// *******************************************************************************
function validatep1() { 
  valid = true;
  if( document.settingspage.selectversion.selectedIndex == 0 )
  {
    alert(selectbv);
    document.settingspage.getElementById('selectversion').focus();
    document.settingspage.getElementById('selectversion').style.border = '1px solid #ff0000'
    document.settingspage.getElementById('selectversion-lbl').style.color = '#ff0000'
    valid = false;
    return valid;
  }
  if( document.settingspage.selectplan.selectedIndex == 0 )
  {
    alert(selectbp);
    document.settingspage.getElementById('selectplan').focus();
    document.settingspage.getElementById('selectplan').style.border = '1px solid #ff0000';
    document.settingspage.getElementById('selectplan-lbl').style.color = '#ff0000';
    valid = false;
    return valid;
  }
  if( document.settingspage.selectaltdate.value == '' )
  {
    alert(selectsd);
    document.settingspage.getElementById('selectaltdate').focus();
    document.settingspage.getElementById('selectaltdate').style.border = '1px solid #ff0000';
    document.settingspage.getElementById('selectaltdate-lbl').style.color = '#ff0000';
    valid = false;
    return valid;
  }
}
function clearText() {
  var inp = document.getElementById("sentry");
  if(inp.value == selectkw)
  inp.value = '';
}
function showComLink(comhref,modal){
  var comsource = document.toolspagecom.selectcomment.value;
  if(comsource == 0){
    alert(selectcom);
    document.toolspagecom.getElementById('selectcomment').focus();
    document.toolspagecom.getElementById('selectcomment').style.border = '1px solid #ff0000';
    document.toolspagecom.getElementById('selectcomment').style.color = '#ff0000';
    return false;
  }else{
    var book = comhref.getAttribute("id");
    if(book == 'songofsongs') book = 'song';
    comhref.href = 'http://ewordtoday.com/comments/'+book+'/'+comsource+'/'+book+'intro.htm';
    if(modal) {
      SqueezeBox.fromElement(comhref, {size:{x:800,y:500}, handler:'iframe',onClose: function() {parent.location.reload(true); }});
      }else{
      window.open(comhref.href,'_blank','width=800,height=500,scrollbars=1');parent.location.reload(true);
      }
    return true;
  }
}
function reloadParentOnClose(){
  var str=window.top.location.reload();
  setTimeout(str,3000);
}
function setNTAOptions(){
  var selPlan = document.settingspage.selectplan;
  var selIndex = document.settingspage.selectversion.selectedIndex;
  if(document.settingspage.selplan.value == 0){
  document.settingspage.selplan.value = document.settingspage.selectplan.selectedIndex;
  }
  var title = document.settingspage.selectversion.options[selIndex].title;
  titlearray = title.split(/;/);
  var nt = titlearray[0];
  var audio = titlearray[1];
  var av = titlearray[2];
  document.settingspage.audioversion.value=av;
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
  document.settingspage.selectplan.selectedIndex = 0;
  return true;
}
function getdate(){
  var currentTime = new Date();
  var month = currentTime.getMonth() + 1;
  var day = currentTime.getDate();
  var year = currentTime.getFullYear();
  return year + "-" + month + "-" + day;
}