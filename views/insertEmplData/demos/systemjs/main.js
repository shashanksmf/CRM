var XLSX = require('xlsx');
console.log(XLSX);
var w = XLSX.read('abc,def\nghi,jkl', {type:'binary'});
var j = XLSX.utils.sheet_to_json(w.Sheets[w.SheetNames[0]], {header:1});
console.log(j);
