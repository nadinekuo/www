// from https://www.npmjs.com/package/latex-to-unicode-converter MIT license
// version 0.5.1
var l2u = window["latex-to-unicode-converter"]

// joins strings a and b using separator sep or returns a or b if only one of
// them is non-empty
function joinif(a,b,sep)
{
  if(a) {
    if(b) {
      return a + sep + b;
    } else {
      return a;
    }
  } else {
    return b;
  }
} 

// checks if a string is a url
function isValidURL(s)
{
  return s.startsWith("https://") || s.startsWith("http://");
}

// takes a citation object from BibTeX.data and turns it into a <span> of
// content for and html table cell
function makeCitation(cite)
{
  var retval = document.createElement("span");

  var authorString = "";
  if(typeof  cite['author'] != 'undefined') {
    var authors = cite['author'];
    for (au in authors) {
      var author = authors[au];
      var thisAuthorString = author.first;
      thisAuthorString = joinif(thisAuthorString, author.von, " ");
      thisAuthorString = joinif(thisAuthorString, author.last, " ");
      thisAuthorString = joinif(thisAuthorString, author.jr, ", ");
      authorString = joinif(authorString, thisAuthorString, ", ");
      authorString = l2u.convertLaTeXToUnicode(authorString);
    }
  }
  var titleString = "";
  if(typeof  cite['title'] !== 'undefined') {
    titleString = l2u.convertLaTeXToUnicode(cite['title']);
  }
  var journalString = "";
  if(typeof  cite['journal'] !== 'undefined') {
    journalString = l2u.convertLaTeXToUnicode(cite['journal']);
  }
  var volumeString = "";
  if(typeof  cite['volume'] !== 'undefined') {
    volumeString = l2u.convertLaTeXToUnicode(cite['volume']);
  }
  var pagesString = "";
  if(typeof  cite['pages'] !== 'undefined') {
    pagesString = l2u.convertLaTeXToUnicode(cite['pages']);
  }
  var yearString = "";
  if(typeof  cite['year'] !== 'undefined') {
    yearString = l2u.convertLaTeXToUnicode(cite['year']);
  }
  var doiString = "";
  if(typeof  cite['doi'] !== 'undefined') {
    doiString = l2u.convertLaTeXToUnicode(cite['doi']);
  }
  var urlString = "";
  if(typeof  cite['url'] !== 'undefined') {
    urlString = l2u.convertLaTeXToUnicode(cite['url']);
  }
  var noteString = "";
  if(typeof  cite['note'] !== 'undefined') {
    noteString = l2u.convertLaTeXToUnicode(cite['note']);
  }
  var booktitleString = "";
  if(typeof  cite['booktitle'] !== 'undefined') {
    booktitleString = l2u.convertLaTeXToUnicode(cite['booktitle']);
  }
  var howpublishedString = "";
  if(typeof  cite['howpublished'] !== 'undefined') {
    howpublishedString = l2u.convertLaTeXToUnicode(cite['howpublished']);
  }

  // hopefully this more or less mimics what bibtex (or one of its bst files) does
  // TODO: handle more than just article and misc types
  var entryType = cite['entryType'].toLowerCase();
  if(entryType == "article") {
    retval.appendChild(document.createTextNode(authorString + ". "));
    if(urlString) {
      var anchorNode = document.createElement("a");
      retval.appendChild(anchorNode);
      anchorNode.href = urlString;
      anchorNode.appendChild(document.createTextNode(titleString));
      retval.appendChild(document.createTextNode(". "));
    } else {
      retval.appendChild(document.createTextNode(titleString + ". "));
    }
    var emNode = document.createElement("em");
    retval.appendChild(emNode);
    emNode.appendChild(document.createTextNode(journalString + ", "));
    var tmpString = "";
    if(volumeString) {
      tmpString += volumeString;
      if(pagesString) {
        tmpString += ":";
      } else {
        tmpString += ", ";
      }
    }
    if(pagesString) {
      tmpString += pagesString + ", ";
    }
    tmpString += yearString;
    retval.appendChild(document.createTextNode(tmpString));
    if(doiString) {
      retval.appendChild(document.createTextNode(" ("));
      var anchorNode = document.createElement("a");
      retval.appendChild(anchorNode);
      anchorNode.href = "http://dx.doi.org/" + doiString.replace(/^doi:/,"");
      anchorNode.appendChild(document.createTextNode("doi:"+doiString.replace(/^doi:/,"")));
      retval.appendChild(document.createTextNode(")"));
    }
    // this returns the INSPIRE bibtex entry for this DOI which is almost but
    // not exactly the ET einsteintoolkit.bib entry. The latter would have to
    // be stored in the cite[] entry in BibTeX.js then made available using
    // something like the download function in
    // https://github.com/rndme/download and something like:
    // <a onclick="download(cite[i]['raw'], cite[i]['key']+'.bib', 'text/plain')">BibTeX</a>
    // but one has to figure out how to actually pass the cite[i] data to the
    // browser at that point
    if(typeof cite['doi'] !== 'undefined') {
      retval.appendChild(document.createTextNode(" ("));
      var anchorNode = document.createElement("a");
      retval.appendChild(anchorNode);
      anchorNode.href = "https://inspirehep.net/search?p=find+"+encodeURIComponent(cite['doi'])+"&of=hx";
      anchorNode.appendChild(document.createTextNode("BibTeX"));
      retval.appendChild(document.createTextNode(")"));
    }
  } else if(entryType == "inproceedings" || entryType == "incollection") {
    retval.appendChild(document.createTextNode(authorString + ". "));
    if(urlString) {
      var anchorNode = document.createElement("a");
      retval.appendChild(anchorNode);
      anchorNode.href = urlString;
      anchorNode.appendChild(document.createTextNode(titleString));
      retval.appendChild(document.createTextNode(". In "));
    } else {
      retval.appendChild(document.createTextNode(titleString + ". In "));
    }
    var emNode = document.createElement("em");
    retval.appendChild(emNode);
    emNode.appendChild(document.createTextNode(booktitleString + ", "));
    var tmpString = "";
    if(volumeString) {
      tmpString += volumeString;
      if(pagesString) {
        tmpString += ":";
      } else {
        tmpString += ", ";
      }
    }
    if(pagesString) {
      tmpString += pagesString + ", ";
    }
    tmpString += yearString;
    retval.appendChild(document.createTextNode(tmpString));
    if(doiString) {
      retval.appendChild(document.createTextNode(" ("));
      var anchorNode = document.createElement("a");
      retval.appendChild(anchorNode);
      anchorNode.href = "http://dx.doi.org/" + doiString.replace(/^doi:/,"");
      anchorNode.appendChild(document.createTextNode("doi:"+doiString.replace(/^doi:/,"")));
      retval.appendChild(document.createTextNode(")"));
    }
    if(typeof cite['doi'] !== 'undefined') {
      retval.appendChild(document.createTextNode(" ("));
      var anchorNode = document.createElement("a");
      retval.appendChild(anchorNode);
      anchorNode.href = "https://inspirehep.net/search?p=find+"+encodeURIComponent(cite['doi'])+"&of=hx";
      anchorNode.appendChild(document.createTextNode("BibTeX"));
      retval.appendChild(document.createTextNode(")"));
    }
  } else if(entryType == "misc") {
    if(authorString) {
      retval.appendChild(document.createTextNode(authorString + ". "));
    }

    // build one nice label + url if possible, then everything else listed after
    var url = "";
    if(urlString) {
      url = urlString;
      urlString = "";
    } else if(noteString && isValidURL(noteString)) {
      url = noteString;
      noteString = "";
    } else if(howpublishedString && isValidURL(howpublishedString)) {
      url = howpublishedString;
      howpublishedString = "";
    }
    var label = "";
    if(titleString) {
      label = titleString;
      titleString = "";
    } else if(noteString && !isValidURL(noteString)) {
      label = noteString;
      noteString = "";
    } else if(howpublishedString && !isValidURL(howpublishedString)) {
      label = howpublishedString;
      howPublishedString = "";
    } else {
      label = url;
    }
    if(url) {
      var anchorNode = document.createElement("a");
      retval.appendChild(anchorNode);
      anchorNode.href = url;
      anchorNode.appendChild(document.createTextNode(label));
    } else if(label) {
      var emNode = document.createElement("em");
      retval.appendChild(emNode);
      emNode.appendChild(document.createTextNode(label + "."));
    }

    // ok we got the main output now everything else
    if(urlString) {
      retval.appendChild(document.createTextNode(" ("));
      var anchorNode = document.createElement("a");
      retval.appendChild(anchorNode);
      anchorNode.href = urlString;
      anchorNode.appendChild(document.createTextNode(urlString));
      retval.appendChild(document.createTextNode(")"));
    }

    if(doiString) {
      retval.appendChild(document.createTextNode(" ("));
      var anchorNode = document.createElement("a");
      retval.appendChild(anchorNode);
      anchorNode.href = "http://dx.doi.org/" + doiString.replace(/^doi:/,"");
      anchorNode.appendChild(document.createTextNode(doiString));
      retval.appendChild(document.createTextNode(")"));
    }

    if(noteString) {
      if(isValidURL(noteString)) {
        retval.appendChild(document.createTextNode(" ("));
        var anchorNode = document.createElement("a");
        retval.appendChild(anchorNode);
        anchorNode.href = noteString;
        anchorNode.appendChild(document.createTextNode(noteString));
        retval.appendChild(document.createTextNode(")"));
      } else {
        retval.appendChild(document.createTextNode(" " + noteString + "."));
      }
    }

    if(howpublishedString) {
      if(isValidURL(howpublishedString)) {
        retval.appendChild(document.createTextNode(" ("));
        var anchorNode = document.createElement("a");
        retval.appendChild(anchorNode);
        anchorNode.href = howpublishedString;
        anchorNode.appendChild(document.createTextNode(howpublishedString));
        retval.appendChild(document.createTextNode(")"));
      } else {
        retval.appendChild(document.createTextNode(" " + howpublishedString + "."));
      }
    }
  } else {
    retval.appendChild(document.createTextNode(cite['cite']));
  }

  return retval;
}

function makeTable(cites, tableNode)
{
  for (var thorn in cites) {
    for(var cite in cites[thorn]) {
      var rowNode = document.createElement("tr");
      tableNode.appendChild(rowNode);

      if(cite == 0) {
        var cell1Node = document.createElement("td");
        cell1Node.rowSpan = cites[thorn].length;
        rowNode.appendChild(cell1Node);
        var boldNode = document.createElement("b");
        cell1Node.appendChild(boldNode);
        var textNode = document.createTextNode(thorn);
        boldNode.appendChild(textNode);
      }

      var cell2Node = document.createElement("td");
      rowNode.appendChild(cell2Node);
      var h5Node = document.createElement("h5");
      cell2Node.appendChild(h5Node);
      var italicNode = document.createElement("i");
      h5Node.appendChild(italicNode);
      var textNode = document.createTextNode(cites[thorn][cite]['cite']);
      italicNode.appendChild(textNode);

      var cell3Node = document.createElement("td");
      rowNode.appendChild(cell3Node);
      var textNode = makeCitation(cites[thorn][cite]);
      cell3Node.appendChild(textNode);
    }
  }
}

function makeTables(content)
{
  // from https://sourceforge.net/projects/jsbibtex/ GPL license
  var bibtex = new BibTex();
  bibtex.content = content; // the bibtex content as a string
  bibtex.parse();

  // requested refs
  var requested = new Array();
  for (var i in bibtex.data) {
    var requested_for = bibtex.data[i]['requested-for'];
    if (typeof requested_for !== 'undefined') {
      var thorns = requested_for.split(' ');
      for (var thorn in thorns) {
        if (typeof requested[thorns[thorn]] === 'undefined') {
          requested[thorns[thorn]] = new Array();
        }
        requested[thorns[thorn]].push(bibtex.data[i]);
      }
    }
  }

  // suggested refs
  var suggested = new Array();
  for (var i in bibtex.data) {
    var suggested_for = bibtex.data[i]['suggested-for'];
    if (typeof suggested_for !== 'undefined') {
      var thorns = suggested_for.split(' ');
      for (var thorn in thorns) {
        if (typeof suggested[thorns[thorn]] === 'undefined') {
          suggested[thorns[thorn]] = new Array();
        }
        suggested[thorns[thorn]].push(bibtex.data[i]);
      }
    }
  }

  // requested
  makeTable(requested, document.getElementById("requestedcites"));

  // suggested
  makeTable(suggested, document.getElementById("suggestedcites"));
}

function httpGetAsync(theURL, callback)
{
  var xmlHttp = new XMLHttpRequest();
  xmlHttp.onreadystatechange = function() { 
    if (xmlHttp.readyState == 4 && xmlHttp.status == 200)
        callback(xmlHttp.responseText);
  }
  xmlHttp.open("GET", theURL, true); // true for asynchronous 
  xmlHttp.send(null);
}

function getCites()
{
  httpGetAsync("https://bitbucket.org/einsteintoolkit/manifest/raw/master/einsteintoolkit.bib", makeTables);
}
