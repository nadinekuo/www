function NSFLink(id) {
  return "<a href='https://nsf.gov/awardsearch/showAward?AWD_ID="+id+"&HistoricalAwards=false'>"+
         id+"</a>";
}

document.write(
  '        <div class="footer">'+
  '        <hr class="separator" />'+
  '        The Einstein Toolkit has been supported by NSF '+
          NSFLink('2004157')+'/'+
          NSFLink('2004044')+'/'+
          NSFLink('2004311')+'/'+
          NSFLink('2004879')+'/'+
          NSFLink('2003893')+', NSF '+
           NSFLink('1550551')+'/'+
           NSFLink('1550461')+'/'+
           NSFLink('1550436')+'/'+
           NSFLink('1550514')+'.'+
  '        Any opinions, findings, and conclusions or recommendations expressed in this material '+
  '        are those of the author(s) and do not necessarily reflect the views of the National Science Foundation.'+
  '        </div>'
  );


      
        
        
         
        
        
