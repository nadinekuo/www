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
           NSFLink('1550514')+', NSF '+
           NSFLink('1212401')+'/'+
           NSFLink('1212426')+'/'+
           NSFLink('1212433')+'/'+
           NSFLink('1212460')+', NSF '+
           NSFLink('0903973')+'/'+
           NSFLink('0903782')+'/'+
           NSFLink('0904015')+' (CIGR), '+
           NSFLink('0701566')+'/'+
           NSFLink('0855892')+' (XiRel), '+
           NSFLink('0721915')+' (Alpaca), '+
           NSFLink('0905046')+'/'+
           NSFLink('0941653')+'(PetaCactus/PRAC).'+
  '        Any opinions, findings, and conclusions or recommendations expressed in this material '+
  '        are those of the author(s) and do not necessarily reflect the views of the National Science Foundation.'+
  '        </div>'
  );


      
        
        
         
        
        
