// returns a Date as set by str
// requires a DateString formated like "d.m.Y H:i"
// not nice but it works
// by tim schumacher

function germanDateTime(str) {
	var parts = str.split(" ");
  if (parts.length!=2) {return Number.POSITIVE_INFINITY;}
  var datum = parts[0].split(".");
	var zeit = parts[1].split(":")
	var d = new Date(0);
	d.setFullYear(datum[2]);
	d.setDate(datum[0]);
	d.setMonth(datum[1] - 1);
	d.setHours(zeit[0]);
	d.setMinutes(zeit[1]);
	return d.valueOf();
}

SortableTable.prototype.addSortType( "GermanDateTime", germanDateTime );

function timeStamp(str) {
  return parseInt(str);
}

SortableTable.prototype.addSortType( "TimeStamp", timeStamp );

function roundSort(str) {
  str = str.toUpperCase();
	var parts = str.split(" ",2);
	var txt = parts[0];
	if (parts.length>1 && parts[1]>0) {var round = parts[1];}else{var round="0";}
	var tmp = txt.length * 100 + parseInt(round);
	return tmp;
}

SortableTable.prototype.addSortType( "RoundSort", roundSort );