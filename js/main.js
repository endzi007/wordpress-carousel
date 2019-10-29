var groupCellsData = Number.parseInt(jQuery(".main-carousel").attr("data-group"));
var groupCellsValue = false; 

if(groupCellsData > 0){
    groupCellsValue = groupCellsData;
}

var lightbox = GLightbox({
    touchNavigation: true,
    loopAtEnd: true
});


jQuery('.main-carousel').flickity({
    // options
    cellAlign: 'left',
    pageDots: false,
    groupCells: groupCellsValue,
	freeScroll: true, 
	wrapAround: true,
	prevNextButtons: false
});

lightbox.onOpen(function(){
    console.log("oppened");
});