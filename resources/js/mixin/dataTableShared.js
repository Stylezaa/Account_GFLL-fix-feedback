export default {
    methods: {
        initDatable(tableId) {
            setTimeout(() => {
            $('#'+tableId).dataTable({
                    searching: true,
                    paginate: true,
                    ordering: true,
                    select: false,
                    language: {
                        emptyTable: this.dataTableTransalate.emptyTable,
                        info: this.dataTableTransalate.info,
                        infoEmpty: this.dataTableTransalate.infoEmpty,
                        infoFiltered: this.dataTableTransalate.infoFiltered,
                        infoThousands: this.dataTableTransalate.infoThousands,
                        lengthMenu: this.dataTableTransalate.lengthMenu,
                        loadingRecords: this.dataTableTransalate.loadingRecords,
                        processing: this.dataTableTransalate.processing,
                        search: this.dataTableTransalate.search,
                        zeroRecords: this.dataTableTransalate.zeroRecords,
                        thousands: this.dataTableTransalate.thousands,
                        paginate: {
                            first: this.dataTableTransalate.paginate.first,
                            last: this.dataTableTransalate.paginate.last,
                            next: this.dataTableTransalate.paginate.next,
                            previous: this.dataTableTransalate.paginate.previous
                        },
                        aria: {}
                    },
                    dom: "<'row'<'col-sm-12 col-md-4 d-flex justify-content-start'l>" +
                        "<'col-sm-12 col-md-4 mt-2 justify-content-center btn-small'B>" +
                        "<'col-sm-12 col-md-4 d-flex d-flex justify-content-end'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    buttons: [
                        {extend: 'copyHtml5', className: 'btn btn-primary text-white'},
                        {extend: 'excelHtml5', className: 'btn btn-primary text-white'},
                        {extend: 'csvHtml5', className: 'btn btn-primary text-white'},
                        {extend: 'pdfHtml5', className: 'btn btn-primary text-white'}
                    ],
                    style: {
                        height: '50px'
                    }
                })
            })
        }
    }
}
