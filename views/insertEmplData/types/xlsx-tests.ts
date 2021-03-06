import XLSX = require('xlsx');

const options: XLSX.ParsingOptions = {
    cellDates: true
};

const workbook: XLSX.WorkBook = XLSX.readFile('test.xlsx', options);
const otherworkbook: XLSX.WorkBook = XLSX.readFile('test.xlsx', {type: 'file'});

const author: string = workbook.Props.Author;

const firstsheet: string = workbook.SheetNames[0];

const firstworksheet: XLSX.WorkSheet = workbook.Sheets[firstsheet];

const WB1A1: XLSX.CellObject = (firstworksheet["A1"]);

interface Tester {
    name: string;
    age: number;
}

const jsonvalues: Tester[] = XLSX.utils.sheet_to_json<Tester>(firstworksheet);
const csv: string = XLSX.utils.sheet_to_csv(firstworksheet);
const formulae: string[] = XLSX.utils.sheet_to_formulae(firstworksheet);
const aoa: any[][] = XLSX.utils.sheet_to_json<any[]>(firstworksheet, {raw:true, header:1});

const aoa2: XLSX.WorkSheet = XLSX.utils.aoa_to_sheet<number>([
	[1,2,3,4,5,6,7],
	[2,3,4,5,6,7,8]
]);

const js2ws: XLSX.WorkSheet = XLSX.utils.json_to_sheet<Tester>([
	{name:"Sheet", age: 12},
	{name:"JS", age: 24}
]);

const WBProps = workbook.Workbook;
const WBSheets = WBProps.Sheets;
const WBSheet0 = WBSheets[0];
console.log(WBSheet0.Hidden);
