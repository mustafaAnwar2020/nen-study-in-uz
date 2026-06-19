
$('.add_more_2').on("click", function (e) {
    e.preventDefault();
    $(this).prev().append([
        `<div class="col-md-6">${$(this).prev().children()[0].innerHTML}</div>`,
        `<div class="col-md-6">${$(this).prev().children()[1].innerHTML}</div>`,
    ]);
});

$('.add_more_3').on("click", function (e) {
    e.preventDefault();
    $(this).prev().append([
        `<div class="col-md-4">${$(this).prev().children()[0].innerHTML}</div>`,
        `<div class="col-md-4">${$(this).prev().children()[1].innerHTML}</div>`,
        `<div class="col-md-4">${$(this).prev().children()[2].innerHTML}</div>`,
    ]);
});


/*  $(container).on("click", ".remove_field", function (e) {
      e.preventDefault();
      $(this).parent('div').remove();
      x--;
  });*/

/*

$("input[data-bootstrap-switch]").each(function () {
    $(this).bootstrapSwitch('state', $(this).prop('checked'));
})
*/

$(".bootstrap_switch").each(function () {
    //console.log($(this));
    $(this).bootstrapSwitch('state');
})

$(function () {
    $('.select2').select2();
});


function swAlert(link, text) {
    Swal.fire({
        title: text,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "تأكيد",
        cancelButtonText: "إلغاء"
    }).then((result) => {
        if (result.isConfirmed) {
            location.href = link;
            Swal.fire("تم بنجاح!", "جاري التاكيد الآن!");
        }
    });
}

let editors = [];
$('.editor').each(function (idx, ele) {
    ClassicEditor
        .create(ele, {
            language: $(ele).attr('data-lang'),
        })
        .then(editor => {
            //console.log(editor);
            editor.editing.view.change(writer => {
                writer.setStyle('height', $(ele).attr('data-height'), editor.editing.view.document.getRoot());
            });
            editors.push(editor);
        })
        .catch(error => {
            console.error('editor error:', error);
        });
});

function previewImage(ele) {
    $(ele).next().css({
        "background-image": "url('" + URL.createObjectURL(event.target.files[0]) + "')"
    })
}
