$(document).ready(function () {
  /* Default Image */
  if (document.getElementById("image").files.length == 0) {
    document.getElementById("image-preview").src = "img/no-image.jpg";
  }

  /* Tooltip */
  $("#browse").popover();

  /* Pass Selected Value */
  $("#subjects-select").change(function () {
    $("#subjects").val($(this).val());
  });

  /* Date picker */
  $("#dates").click(function () {
    var dates = $("#dates").val();
    var gettheDate = new Date(dates);
    $("#dates").datepicker("setDate", gettheDate);
  });
  $("#dates").datepicker({
    uiLibrary: "bootstrap4",
    format: "MM d, yyyy",
    autoclose: true,
    todayHighlight: true,
  });

  /* Video */
  $("#video-add-button").click(function () {
    $("#video-form")[0].reset();
    $(".modal-title").text("Add Lesson");
    $("#video-action").val("Add");
    $("#video-operation").val("Add");
  });

  var dataTable = $("#video-table").DataTable({
    paging: false,
    ordering: false,
    processing: false,
    scrollY: "367px",
    scrollX: "1000px",
    scrollCollapse: true,
    serverSide: true,
    responsive: true,
    columns: [
      {
        responsivePriority: 1,
      },
      {
        responsivePriority: 2,
      },
      {
        responsivePriority: 6,
      },
      {
        responsivePriority: 5,
      },
      {
        responsivePriority: 8,
      },
      {
        responsivePriority: 3,
      },
      {
        responsivePriority: 4,
      },
      {
        responsivePriority: 0,
      },
    ],
    language: {
      searchPlaceholder: "Search for Lesson",
      search: "",
      /* "lengthMenu": "", */
      zeroRecords: "No records available",
    },

    order: [],
    info: false,
    ajax: {
      url: "php/fetch.php",
      type: "POST",
    },
    columnDefs: [
      {
        targets: [0, 3, 4],
        orderable: false,
      },
      {
        targets: [6],
        className: "text-right pr-3",
        autoWidth: false,
      },
      {
        targets: [4],
        createdCell: function (td) {
          $(td).addClass("dipnone");
        },
      },
      {
        targets: [7],
        className: "text-right pr-3",
        autoWidth: false,
      },
      {
        targets: [0, 5],
        visible: false,
      },
      {
        targets: [0, 2, 3, 4, 5, 6],
        className: "dt-body-center",
      },
      {
        targets: [1],
        className: "dt-first-last",
      },
    ],
  });

  $("#input-search").keyup(function () {
    dataTable.search($(this).val()).draw();
  });

  $(document).on("submit", "#video-form", function (event) {
    event.preventDefault();
    var id = $("#id").val();
    var titles = $("#titles").val();
    var subjects = $("#subjects").val();
    var dates = $("#dates").val();
    var links = $("#links").val();
    var linkcode = $("#linkcode").val();
    $.ajax({
      url: "php/controller.php",
      method: "POST",
      data: new FormData(this),
      contentType: false,
      processData: false,
      success: function (data) {
        $("#video-form")[0].reset();
        $("#video-modal").modal("hide");
        dataTable.ajax.reload();
      },
    });
  });

  $(document).on("click", ".video-update", function () {
    var video_id = $(this).attr("id");
    $.ajax({
      url: "php/fetch.php",
      method: "POST",
      data: {
        video_id: video_id,
      },
      dataType: "json",
      success: function (data) {
        $("#video-modal").modal("show");
        $("#id").val(data.id);

        $("#titles").val(data.titles);
        $("#subjects-select").val(data.subjects);
        $("#subjects").val(data.subjects);
        $("#dates").val(data.dates);
        $("#links").val(data.links);
        $("#linkcode").val(data.linkcode);

        $(".modal-title").text("Edit Video Details");
        $("#video_id").val(video_id);
        $("#video-action").val("Save");
        $("#video-operation").val("Edit");
      },
    });
  });

  $(document).on("click", ".video-delete", function () {
    var video_id = $(this).attr("id");
    if (confirm("Are you sure you want to delete?")) {
      $.ajax({
        url: "php/controller.php",
        method: "POST",
        data: {
          video_id: video_id,
        },
        success: function (data) {
          dataTable.ajax.reload();
        },
      });
    } else {
      return false;
    }
  });
});

/* Video */
$(document).ready(function () {
  $("#subject-add-button").click(function () {
    $("#subject-form")[0].reset();
    $(".modal-title").text("Add Subject");
    $("#subject-action").val("Add");
    $("#subject-operation").val("Add");
  });

  var fetch_subject = true;
  var dataTable = $("#subject-table").DataTable({
    paging: false,
    ordering: false,
    processing: false,
    serverSide: true,
    responsive: true,
    searching: false,
    scrollY: "367px",
    scrollX: "1000px",
    scrollCollapse: true,
    order: [],
    language: {
      /* "lengthMenu": "", */
      zeroRecords: "No records available",
    },
    info: false,
    ajax: {
      url: "php/fetch.php",
      method: "POST",
      data: {
        fetch_subject: fetch_subject,
      },
    },
    columnDefs: [
      {
        targets: [0, 3, 4],
        orderable: false,
      },
      {
        targets: [0, 2, 3],
        visible: false,
      },
      {
        targets: [4],
        className: "text-right pr-3",
        autoWidth: false,
      },
      {
        targets: [0, 1, 2, 3],
        className: "text-left pl-3",
      },
      {
        targets: [1],
        className: "text-left pl-3",
      },
    ],
  });

  $(document).on("submit", "#subject-form", function (event) {
    event.preventDefault();
    var id = $("#id").val();
    var subjects = $("#subjects").val();
    var subjectcode = $("#subjectcode").val();
    $.ajax({
      url: "php/controller.php",
      method: "POST",
      data: new FormData(this),
      contentType: false,
      processData: false,
      success: function (data) {
        $("#subject-form")[0].reset();
        $("#subjects-select").load(" #subjects-select > *");
        $("#subject-modal").modal("hide");
        dataTable.ajax.reload();
      },
    });
  });

  $(document).on("click", ".subject-delete", function () {
    var subject_id = $(this).attr("id");
    if (confirm("Are you sure you want to delete?")) {
      $.ajax({
        url: "php/controller.php",
        method: "POST",
        data: {
          subject_id: subject_id,
        },
        success: function (data) {
          dataTable.ajax.reload();
          $("#subjects-select").load(" #subjects-select > *");
        },
      });
    } else {
      return false;
    }
  });
});
