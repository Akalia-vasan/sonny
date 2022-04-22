$(function(){
	
	/* Morris Area Chart */
	
	// window.mA = Morris.Area({
	//     element: 'morrisArea',
	//     data: [
	//         // { y: '2013', a: 60},
	//         // { y: '2014', a: 100},
	//         // { y: '2015', a: 240},
	//         // { y: '2016', a: 120},
	//         { w: '1', a: 0},
	//         { w: '2', a: 100},
	//         { w: '3', a: 300},
	// 		{ w: '4', a: 400},
	// 		{ w: '5', a: 350},
	//     ],
	//     xkey: 'w',
	//     ykeys: ['a'],
	//     labels: ['Revenue'],
	//     lineColors: ['#1b5a90'],
	//     lineWidth: 2,
		
    //  	fillOpacity: 0.5,
	//     gridTextSize: 10,
	//     hideHover: 'auto',
	//     resize: true,
	// 	redraw: true
	// });
	
	/* Morris Line Chart */
	
	var day_data = [
		{"weak": "Sun", "value": 0},
		{"weak": "Mon", "value": 100},
		{"weak": "Tue", "value": 80},
		{"weak": "Wed", "value": 120},
		{"weak": "Thu", "value": 500},
		{"weak": "Fri", "value": 300},
		{"weak": "Sat", "value": 410},
	  ];
	  Morris.Line({
		element: 'morrisArea',
		data: day_data,
		xkey: 'weak',
		ykeys: ['value'],
		// labels: ['value'],
		parseTime: false,
		labels: ['Revenue'],
	    lineColors: ['#1b5a90'],
	    lineWidth: 5,
		
     	fillOpacity: 0.5,
	    gridTextSize: 10,
	    hideHover: 'auto',
	    resize: true,
		redraw: true
	  });


	// window.mL = Morris.Line({
	//     element: 'morrisLine',
	//     data: [
	//         // { y: '2015', a: 100, b: 30},
	//         // { y: '2016', a: 20,  b: 60},
	//         { y: '2017', a: 90,  b: 120},
	//         { y: '2018', a: 50,  b: 80},
	//         { y: '2019', a: 120,  b: 150},
	// 		{ y: '2020', a: 120,  b: 220},
	// 		{ y: '2021', a: 120,  b: 250},
	//     ],
	//     xkey: 'y',
	//     ykeys: ['a', 'b'],
	//     labels: ['Doctors', 'Patients'],
	//     lineColors: ['#1b5a90','#ff9d00'],
	//     lineWidth: 1,
	//     gridTextSize: 10,
	//     hideHover: 'auto',
	//     resize: true,
	// 	redraw: true
	// });
	// $(window).on("resize", function(){
	// 	mA.redraw();
	// 	mL.redraw();
	// });

	var day_data = [
		{"month": "jan", "a": 5, "b": 20},
		{"month": "feb", "a": 2, "b": 26},
		{"month": "mar", "a": 3, "b": 10},
		{"month": "apr", "a": 2, "b": 32},
		{"month": "may", "a": 10, "b": 59},
		{"month": "jun", "a": 2, "b": 24},
		{"month": "jul", "a": 4, "b": 34},
		{"month": "aug", "a": 5, "b": 50},
		{"month": "sep", "a": 1, "b": 90},
		{"month": "oct", "a": 2, "b": 10},
		{"month": "nov", "a": 18, "b": 49},
		{"month": "dec", "a": 8, "b": 40},
	  ];
	  Morris.Line({
		element: 'morrisLine',
		data: day_data,
		xkey: 'month',
		ykeys: ['a','b'],
		// labels: ['value'],
		parseTime: false,
		labels: ['Doctors', 'Patients'],
	    lineColors: ['#1b5a90','#ff9d00'],
	    // lineWidth: 2,
		
     	fillOpacity: 0.5,
	    gridTextSize: 10,
	    hideHover: 'auto',
	    resize: true,
		redraw: true
	  });

});