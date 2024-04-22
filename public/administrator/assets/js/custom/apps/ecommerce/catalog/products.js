// Define form element
const form = document.getElementById("form_add");

// Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
var validator = FormValidation.formValidation(form, {
    fields: {
        name: {
            validators: {
                notEmpty: {
                    message: "Product name is required",
                },
            },
        },
        category: {
            validators: {
                notEmpty: {
                    message: "Please select category",
                },
            },
        },
        brand: {
            validators: {
                notEmpty: {
                    message: "Please select brand",
                },
            },
        },
        "variants[0][sku]": {
            validators: {
                notEmpty: {
                    message: "SKU is required",
                },
            },
        },
        "variants[0][name]": {
            validators: {
                notEmpty: {
                    message: "Name is required",
                },
            },
        },
        "variants[0][weight]": {
            validators: {
                notEmpty: {
                    message: "Weight is required",
                },
            },
        },
        "variants[0][price]": {
            validators: {
                notEmpty: {
                    message: "Price is required",
                },
            },
        },
        "variants[0][minimal_stock]": {
            validators: {
                notEmpty: {
                    message: "Minimal Stock is required",
                },
            },
        },
        "variants[0][stock]": {
            validators: {
                notEmpty: {
                    message: "Stock is required",
                },
            },
        },
    },

    plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap: new FormValidation.plugins.Bootstrap5({
            rowSelector: ".fv-row",
            eleInvalidClass: "",
            eleValidClass: "",
        }),
    },
});

// Submit button handler
const submitButton = document.getElementById("kt_ecommerce_add_product_submit");
submitButton.addEventListener("click", function (e) {
    // Prevent default button action
    e.preventDefault();

    // Validate form before submit
    if (validator) {
        validator.validate().then(function (status) {
            if (status == "Valid") {
                let stat = true;
                $(".data-ingredient").each(function () {
                    let index = $(this).data("index");
                    let stok = $(".stok_" + index).val();
                    var item_variant_name = $(
                        ".item_variant_name_" + index
                    ).text();

                    if (
                        parseInt(stok) < parseInt($(".quantity_" + index).val())
                    ) {
                        Swal.fire({
                            title: "Error!",
                            text:
                                "Stok item variant " +
                                item_variant_name +
                                " tidak mencukupi!",
                            icon: "error",
                            confirmButtonText: "Close",
                        });

                        stat = false;
                        return false;
                    }

                    if (stok == "") {
                        Swal.fire({
                            title: "Error!",
                            text:
                                "Silahkan pilih stok item variant " +
                                item_variant_name +
                                " terlebih dahulu!",
                            icon: "error",
                            confirmButtonText: "Close",
                        });

                        stat = false;
                        return false;
                    }
                });

                if (stat == true) {
                    // Show loading indication
                    submitButton.setAttribute("data-kt-indicator", "on");

                    // Disable button to avoid multiple click
                    submitButton.disabled = true;

                    // Simulate form submission. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                    setTimeout(function () {
                        // Remove loading indication
                        submitButton.removeAttribute("data-kt-indicator");

                        // Enable button
                        submitButton.disabled = false;

                        form.submit(); // Submit form
                    }, 2000);
                } else {
                    return false;
                }
            }
        });
    }
});

$(document).ready(function() {
    resetData();

    $(".kt_datepicker_1").flatpickr({
        dateFormat: "d-m-Y",
    });

    $('#gudang_data_table').dataTable({
        ordering: false,
        searching: true,
        dom: 'lrtip',
    });

    $('#items_data_table').dataTable({
        ordering: false,
        searching: true,
        dom: 'lrtip',
    });

    $('#item_variants_data_table').dataTable({
        ordering: false,
        searching: true,
        dom: 'lrtip'
    });

    $('#stok_data_table').dataTable({
        ordering: false,
        searching: true,
        dom: 'lrtip'
    });

    $('#btnToggleNomorProduksi').off().on('click', function(e) {
        var nomorProduksiInput = document.getElementsByName("nomor_produksi")[0];
        nomorProduksiInput.readOnly = !nomorProduksiInput.readOnly;
        if (nomorProduksiInput.readOnly == false) {
            nomorProduksiInput.classList.remove("bg-secondary")
        } else {
            nomorProduksiInput.classList.add("bg-secondary")
            $.ajax({
                url: "{{ route('admin.produksi.generate-nomor') }}",
                type: "get",
                cache: false,
                async: false,
                success: function(data) {
                    $('#nomor_produksi').val(data)
                }
            });

            $("#status_nomor_produksi").val(false)
        }

        var nomorProduksiHelp = document.getElementById("nomorProduksiHelp");
        nomorProduksiHelp.innerHTML = nomorProduksiInput.readOnly ?
            "Klik tombol 'Ubah' untuk mengisi manual!" :
            "Klik tombol 'Ubah' untuk mengisi otomatis!";
    });

    $("#nomor_produksi").keyup(function() {
        let no_produksi = $("#nomor_produksi").val()
        $.ajax({
            url: "{{ route('admin.produksi.cek-nomor') }}",
            data: {
                'no_produksi': no_produksi
            },
            type: "get",
            cache: false,
            async: false,
            success: function(data) {
                if (data == 1) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Nomor Produksi ' +
                            no_produksi +
                            ' sudah ada!',
                        icon: 'error',
                        confirmButtonText: 'Close'
                    })
                    $("#status_nomor_produksi").val("")
                }
            }
        });
    });

    $('#gudang-data').off().on('click', function(e) {
        $('#gudang-modal').modal('show');
        $.ajax({
            url: "{{ route('admin.produksi.gudang-data') }}",
            type: "get",
            cache: false,
            async: false,
            success: function(data) {
                var table = $('#gudang_data_table').DataTable();

                table.rows().remove().draw();
                $.each(data, function(i) {
                    table.row.add($(
                        '<tr class="item"><td><input type="checkbox" class="form-check-input list_item_name" name="list_item_name" id="item' +
                        data[i].id + '" value="' + data[i].id +
                        '" /></td><td><label for="gudang' + data[i]
                        .id + '">' + data[i].code +
                        '</label></td><td>' + data[i].name +
                        '</td><td>' + data[i].pic +
                        '</td></tr>'
                    )).draw(false);

                    $("#item" + data[i].id).on('click', function() {
                        var $box = $(this);
                        if ($box.is(":checked")) {
                            var group =
                                "input:checkbox[name='list_item_name']";
                            $(group).prop("checked", false);
                            $box.prop("checked", true);
                        } else {
                            $box.prop("checked", false);
                        }

                        $('#selectData-Gudang').attr('data-id', data[i]
                            .id).attr('data-gudang', data[i].name);
                    });

                });

                $('#selectData-Gudang').click(function() {
                    let id = $(this).data('id');
                    let gudang = $(this).data('gudang');
                    $('#gudang_id').val(id)
                    $('#gudang_name').val(gudang)

                    $('#gudang-modal').modal('hide');
                })
            }
        });
        e.preventDefault();
    });

    $('#item-data').off().on('click', function(e) {
        $('#item-data-modal').modal('show');
        $.ajax({
            url: "{{ route('admin.produksi.item-data') }}",
            type: "get",
            cache: false,
            async: false,
            success: function(data) {
                console.log(data)
                var table = $('#items_data_table').DataTable();

                table.rows().remove().draw();
                $.each(data, function(i) {
                    table.row.add($(
                        '<tr class="item"><td><input type="checkbox" class="form-check-input list_item_name" name="list_item_name" id="item' +
                        data[i].id + '" value="' + data[i].id +
                        '" /></td><td><label for="variant' + data[i]
                        .id + '">' + data[i].name +
                        '</label></td><td>' + data[i].brands.name +
                        '</td><td>' + data[i].categories.name +
                        '</td></tr>'
                    )).draw(false);

                    $("#item" + data[i].id).on('click', function() {
                        var $box = $(this);
                        if ($box.is(":checked")) {
                            var group =
                                "input:checkbox[name='list_item_name']";
                            $(group).prop("checked", false);
                            $box.prop("checked", true);
                        } else {
                            $box.prop("checked", false);
                        }

                        $('#selectData-item').attr('data-id', data[i]
                            .id).attr('data-item', data[i].name);
                    });

                });

                $('#selectData-item').click(function() {
                    let id = $(this).data('id');
                    let item = $(this).data('item');
                    $('#item_id').val(id)
                    $('#item_name').val(item)

                    $('#item-data-modal').modal('hide');
                })
            }
        });
        e.preventDefault();
    });

    $('#item-variant-data').off().on('click', function(e) {
        $('#item-variant-data-modal').modal('show');

        var id = $('#gudang_id').val()

        $.ajax({
            url: "{{ route('admin.produksi.variant-data') }}",
            data: {
                'id': id
            },
            type: "get",
            cache: false,
            async: false,
            success: function(data) {
                var table = $('#item_variants_data_table').DataTable();

                table.rows().remove().draw();
                $.each(data, function(i) {
                    table.row.add($(
                        '<tr class="item_variants"><td><input type="checkbox" class="form-check-input" name="list_item_variant_name" id="variant' +
                        data[i].id + '" value="' + data[i].id +
                        '" /></td><td><label for="variant' + data[i]
                        .id + '">' + data[i].name + '</label></td></tr>'
                    )).draw(false);

                    $("#variant" + data[i].id).on('click', function() {
                        var $box = $(this);
                        if ($box.is(":checked")) {
                            var group =
                                "input:checkbox[name='list_item_variant_name']";
                            $(group).prop("checked", false);
                            $box.prop("checked", true);
                        } else {
                            $box.prop("checked", false);
                        }

                        $('#selectData-item-variant').attr('data-id',
                                data[i]
                                .id).attr('data-item', data[i].name)
                            .attr('data-supplier_name', data[i]
                                .supplier_name).attr('data-supplier_id',
                                data[i].supplier_id);
                    });
                });


            }
        });

        $('#selectData-item-variant').click(function() {
            let id = $(this).data('id');
            let item = $(this).data('item');
            let supplier_name = $(this).data('supplier_name');
            let supplier_id = $(this).data('supplier_id');
            let index = 0;
            let number = 1;

            $('#item_variant_name').val(item)
            $('#item_variant_id').val(id)
            $('#supplier_name').val(supplier_name)
            $('#supplier_id').val(supplier_id)

            $.ajax({
                url: "{{ route('admin.produksi.ingredient-data') }}",
                data: {
                    'id': id
                },
                type: "get",
                cache: false,
                async: false,
                success: function(data) {
                    $.each(data, function(i) {
                        $('#get-item-data').append(
                            '<tr id="ingredient_' + index +
                            '" class="data-ingredient" data-index="' +
                            index +
                            '" ><td>' +
                            number + '</td><td>' + data[i]
                            .item_name +
                            '</td><td class="item_variant_name_' +
                            index + '">' + data[i]
                            .item_variant_name +
                            '</td><td><input type="text" class="form-control withseparator format-number text-end bg-secondary quantity_' +
                            index + ' mb-2" name="ingredients[' +
                            index +
                            '][quantity]" value = "" readonly><input type="hidden" class="form-control withseparator format-number text-end quantity_act_' +
                            index + ' mb-2" value = "' + data[i]
                            .quantity_after_conversion +
                            '"><input type="hidden" class="form-control item_variant_id_' +
                            index +
                            ' mb-2" value = "" name="ingredients[' +
                            index +
                            '][item_variant_id]" ><input type="hidden" class="form-control warehouse_id_' +
                            index +
                            ' mb-2" value = "" name="ingredients[' +
                            index +
                            '][warehouse_id]" ></td><td><div style="display:flex"><input type="text" class="form-control withseparator format-number text-end bg-secondary stok_' +
                            index + ' mb-2" name="ingredients[' +
                            index +
                            '][stok]" value="" style="width:50%;margin-right:5px;" readonly><a class="btn btn-sm btn-icon btn-light btn-active-light-primary stokData" type="button" data-bs-toggle="tooltip" data-item_variant_id = "' +
                            data[i]
                            .item_variant_id +
                            '"data-index="' + index +
                            '" data-bs-placement="top"><span class="svg-icon svg-icon-2"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"><path  d="M21.7 18.9L18.6 15.8C17.9 16.9 16.9 17.9 15.8 18.6L18.9 21.7C19.3 22.1 19.9 22.1 20.3 21.7L21.7 20.3C22.1 19.9 22.1 19.3 21.7 18.9Z" fill="white" /><path opacity="0.5" d="M11 20C6 20 2 16 2 11C2 6 6 2 11 2C16 2 20 6 20 11C20 16 16 20 11 20ZM11 4C7.1 4 4 7.1 4 11C4 14.9 7.1 18 11 18C14.9 18 18 14.9 18 11C18 7.1 14.9 4 11 4ZM8 11C8 9.3 9.3 8 11 8C11.6 8 12 7.6 12 7C12 6.4 11.6 6 11 6C8.2 6 6 8.2 6 11C6 11.6 6.4 12 7 12C7.6 12 8 11.6 8 11Z" fill="white" /></svg></span></a></div></td><td>' +
                            data[i].unit_name + '</td></tr>');
                        number++;
                        index++;
                        resetData();
                    });
                }
            });

            $('#item-variant-data-modal').modal('hide');
        })
        e.preventDefault();
    });

    $("#jumlah_produksi").keyup(function() {
        $(".data-ingredient").each(function() {

            let index = $(this).data("index");
            let quantity_act = $(".quantity_act_" + index).val();
            let stok = $(".stok_" + index).val();
            let jumlah_produksi = $("#jumlah_produksi").val();
            var item_variant_name = $('.item_variant_name_' + index).text();

            if (jumlah_produksi > 0) {
                let total = quantity_act * jumlah_produksi
                $(".quantity_" + index).val(total);
            } else {
                $(".quantity_" + index).val("");
            }

            if (parseInt(stok) < parseInt($(".quantity_" + index).val())) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Stok item variant ' +
                        item_variant_name +
                        ' tidak mencukupi!',
                    icon: 'error',
                    confirmButtonText: 'Close'
                })
                $(".stok_" + index).val("");
            }
        })
    })

    function addValidation() {
        index = 0;
        validator.addField("gudang_name", {
            validators: {
                notEmpty: {
                    message: 'Silahkan pilih gudang'
                }
            }
        });

        validator.addField("item_variant_name", {
            validators: {
                notEmpty: {
                    message: 'Silahkan pilih item variant'
                }
            }
        });

        validator.addField("supplier_name", {
            validators: {
                notEmpty: {
                    message: 'Silahkan pilih item supplier'
                },

            }
        });

        validator.addField("jumlah_produksi", {
            validators: {
                notEmpty: {
                    message: 'Silahkan pilih jumlah produksi'
                }
            }
        });

        validator.addField("status_nomor_produksi", {
            validators: {
                notEmpty: {
                    message: 'Nomor Produksi sudah ada!'
                }
            }
        });

    }

    function resetData() {
        $(".data-ingredient").each(function() {
            var another = this;

            $(this).find(".format-number").keydown(function(e) {
                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 || (e
                        .keyCode == 65 && (e
                            .ctrlKey === true || e.metaKey === true)) || (e.keyCode >= 35 &&
                        e.keyCode <=
                        40)) {
                    return;
                }
                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 ||
                        e.keyCode >
                        105)) {
                    e.preventDefault();
                }
            });

            $(this).find('.withseparator').on({
                keyup: function() {
                    formatCurrency($(this));
                },
                blur: function() {
                    formatCurrency($(this), "blur");
                }
            });

            function formatCurrency(input, blur) {
                // appends $ to value, validates decimal side
                // and puts cursor back in right position.

                // get input value
                var input_val = input.val();

                // don't validate empty input
                if (input_val === "") {
                    return;
                }

                // original length
                var original_len = input_val.length;

                // initial caret position
                var caret_pos = input.prop("selectionStart");

                // check for decimal
                if (input_val.indexOf(".") >= 0) {

                    // get position of first decimal
                    // this prevents multiple decimals from
                    // being entered
                    var decimal_pos = input_val.indexOf(".");

                    // split number by decimal point
                    var left_side = input_val.substring(0, decimal_pos);
                    var right_side = input_val.substring(decimal_pos);

                    // add commas to left side of number
                    left_side = formatNumber(left_side);

                    // validate right side
                    right_side = formatDecimal(right_side);

                    // On blur make sure 2 numbers after decimal
                    if (blur === "blur") {
                        right_side += "00";
                    }

                    // Limit decimal to only 2 digits
                    right_side = right_side.substring(0, 2);

                    // join number by .
                    input_val = "" + left_side + "." + right_side;

                } else {
                    // no decimal entered
                    // add commas to number
                    // remove all non-digits
                    input_val = formatNumber(input_val);
                    input_val = "" + input_val;

                    // final formatting
                    if (blur === "blur") {
                        input_val += ".00";
                    }
                }

                // send updated string to input
                input.val(input_val);

                // put caret back in the right position
                var updated_len = input_val.length;
                caret_pos = updated_len - original_len + caret_pos;
                input[0].setSelectionRange(caret_pos, caret_pos);
            }

            function formatNumber(n) {
                // format number 1000000 to 1,234,567
                var xx = n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                // console.log(xx)/
                return xx;

            }

            $(this)
                .find(".stokData")
                .off()
                .on("click", function() {
                    let item_variant_id = $(this).data("item_variant_id");
                    let index = $(this).data("index");
                    let jumlah_produksi = $("#jumlah_produksi").val();
                    let stok = "";
                    let warehouse_id = "";

                    if (jumlah_produksi.length < 1) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Silahkan isi jumlah produksi terlebih dahulu ',
                            icon: 'error',
                            confirmButtonText: 'Close'
                        })

                        return false
                    }

                    $("#stok-modal").modal("show");

                    $.ajax({
                        url: "{{ route('admin.produksi.stok-data') }}",
                        data: {
                            'item_variant_id': item_variant_id
                        },
                        type: "get",
                        cache: false,
                        async: false,
                        success: function(data) {
                            var table = $('#stok_data_table').DataTable();

                            table.rows().remove().draw();
                            $.each(data, function(i) {
                                table.row.add($(
                                    '<tr class="item_stok"><td><input type="checkbox" class="form-check-input" name="list_item_stok" id="stok' +
                                    data[i].id + '" value="' + data[
                                        i].id +
                                    '" /></td><td><label for="stok' +
                                    data[i]
                                    .id + '">' + data[i]
                                    .variant_name +
                                    '</label></td><td><label for="stok' +
                                    data[i]
                                    .id + '">' + data[i]
                                    .warehouse_name +
                                    '</label></td><td><label for="stok' +
                                    data[i]
                                    .id + '">' + data[i].stock +
                                    '</label></td></tr>'
                                )).draw(false);

                                $("#stok" + data[i].id).on('click',
                                    function() {
                                        var $box = $(this);
                                        if ($box.is(":checked")) {
                                            var group =
                                                "input:checkbox[name='list_item_stok']";
                                            $(group).prop("checked",
                                                false);
                                            $box.prop("checked", true);
                                        } else {
                                            $box.prop("checked", false);
                                        }
                                        stok = data[i].stock
                                        warehouse_id = data[i]
                                            .warehouse_id
                                    });
                            });
                        }
                    });

                    $('#selectData-Stock').click(
                        function(e) {

                            var data_min = $(
                                '.quantity_' +
                                index).val();
                            var item_variant_name = $(
                                    '.item_variant_name_' +
                                    index)
                                .text();

                            if (parseInt(stok) < parseInt(data_min)) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Stok item variant ' +
                                        item_variant_name +
                                        ' tidak mencukupi!',
                                    icon: 'error',
                                    confirmButtonText: 'Close'
                                })

                                $('#stok-modal')
                                    .modal(
                                        'hide');
                                e
                                    .preventDefault();
                            } else {

                                $('.stok_' +
                                        index)
                                    .val(stok)

                                $('.warehouse_id_' +
                                        index)
                                    .val(warehouse_id)

                                $('.item_variant_id_' +
                                        index)
                                    .val(item_variant_id)

                                $('#stok-modal')
                                    .modal(
                                        'hide');
                                e
                                    .preventDefault();
                            }

                        })
                });
        });

        addValidation();
    }

});
