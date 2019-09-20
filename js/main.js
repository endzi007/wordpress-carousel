var groupCellsData = Number.parseInt(jQuery(".main-carousel").attr("data-group"));
var groupCellsValue = false; 

if(groupCellsData > 0){
    groupCellsValue = groupCellsData;
}

jQuery('.main-carousel').flickity({
    // options
    cellAlign: 'left',
    pageDots: false,
    groupCells: groupCellsValue,
	freeScroll: true, 
	wrapAround: true,
	prevNextButtons: false
});
