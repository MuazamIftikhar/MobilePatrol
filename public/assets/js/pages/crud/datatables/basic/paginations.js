"use strict";
var KTDatatablesBasicPaginations = function() {

    var initTable1 = function() {
        var table = $('#kt_datatable');

        // begin first table
        table.DataTable({
            responsive: true,
            pagingType: 'full_numbers',
            // columnDefs: [
            // 	{
            // 		targets: -1,
            // 		width: '125px',
            // 		title: 'Actions',
            // 		orderable: false,
            // 	},
            // 	// {
            // 	// 	targets: 8,
            // 	// 	width: '75px',
            // 	// 	render: function(data, type, full, meta) {
            // 	// 		var status = {
            // 	// 			1: {'title': 'Pending', 'class': 'label-light-success'},
            // 	// 			2: {'title': 'Delivered', 'class': ' label-light-danger'},
            // 	// 			3: {'title': 'Canceled', 'class': ' label-light-primary'},
            // 	// 			4: {'title': 'Success', 'class': ' label-light-success'},
            // 	// 			5: {'title': 'Info', 'class': ' label-light-info'},
            // 	// 			6: {'title': 'Danger', 'class': ' label-light-danger'},
            // 	// 			7: {'title': 'Warning', 'class': ' label-light-warning'},
            // 	// 		};
            // 	// 		if (typeof status[data] === 'undefined') {
            // 	// 			return data;
            // 	// 		}
            // 	// 		return '<span class="label label-lg font-weight-bold' + status[data].class + ' label-inline">' + status[data].title + '</span>';
            // 	// 	},
            // 	// },
            //
            // ],
        });
    };

    return {

        //main function to initiate the module
        init: function() {
            initTable1();
        },

    };

}();

jQuery(document).ready(function() {
    KTDatatablesBasicPaginations.init();
});
