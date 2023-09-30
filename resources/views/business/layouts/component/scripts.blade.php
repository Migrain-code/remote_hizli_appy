
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="/business_admin/assets/plugins/global/plugins.bundle.js"></script>
<script src="/business_admin/assets/js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->

<script src="/business_admin/assets/plugins/custom/datatables/datatables.bundle.js"></script>

<!--end::Vendors Javascript-->

<!--begin::Custom Javascript(used for this page only)-->
<script src="/business_admin/assets/js/widgets.bundle.js"></script>
<script src="/business_admin/assets/js/custom/widgets.js"></script>
<!--end::Custom Javascript-->

<!--end::Javascript-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.1.60/inputmask/jquery.inputmask.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.14.1/dist/sweetalert2.min.js"></script>

@include('business.layouts.component.alert')
<script>
    $(function () {
        $("#phone").inputmask({"mask": "(999)-999-9999"});
        $("#verification_code").inputmask({"mask": "999-999"});

        $("#datepicker").datepicker({
            autoclose: true,
            todayHighlight: true
        }).datepicker('update', new Date());

    });

    $(document).ready(function(){
        $(".booking-calender .fa.fa-clock-o").removeClass(this);
        $(".booking-calender .fa.fa-clock-o").addClass('fa-clock');
    });

</script>
<script>
    function showNote(note_url){
        $.ajax({
            url: note_url,
            type: "GET",
            dataType:"JSON",
            success:function (res){
                $('#note-title').val(res.title);
                $('#note-content').val(res.content);
                $('#show-note-modal').modal('show');
            }
        });
    }
    function deleteNote(note_url, index){

        Swal.fire({
            title: 'Notu Silmek istediğinize eminmisiniz?',
            icon: 'info',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: 'Sil',
            denyButtonText: `İptal Et`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    url: note_url,
                    type: "POST",
                    data:{
                        _token:'{{csrf_token()}}',
                        '_method':'DELETE',
                    },
                    dataType:"JSON",
                    success:function (res){
                        if(res.status=="success"){
                            Swal.fire({
                                text: "Not Silindi!.",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Tamam!",
                                customClass: {
                                    confirmButton: "btn btn-primary",
                                }
                            });
                            document.getElementById(index).remove();
                        }
                    }
                })
            } else if (result.isDenied) {
                Swal.fire('İşlem İptal Edildi', '', 'info')
            }
        })
    }
</script>
@yield('scripts')
<!--end::Custom Javascript-->
<!--end::Javascript-->
