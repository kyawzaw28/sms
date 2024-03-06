require("./bootstrap");
import Noty from "noty";
// import Noty from "noty";
// import "noty/lib/noty.css";
// import "noty/lib/themes/sunset.css";

$(document).ready(function (e) {
    //select 2
    $(".js-example-basic-multiple").select2({
        placeholder: "Select days",
        allowClear: true,
    });
    $(".lecturermulti").select2({
        placeholder: "Select Lecturers",
        allowClear: true,
    });

    //colorpicker
    $("#color").on("input", () => {
        var color = $("#color").val();
        $("#hex").val(color);
    });

    //close redirect back message
    $(".alert .close").on("click", function () {
        $(this)
            .parent()
            .fadeOut("fast", function () {
                $(this).remove();
            });
    });

    // classItemSearch();

    //ajaxsearch
    $("#classitemsearch").on(
        "keyup",
        _.debounce(function (e) {
            classItemSearch();
        }, 600)
    );
    $("#coursesearchclassitem").change(function (e) {
        classItemSearch();
    });
    $("#studentsearchclassitem").change(function (e) {
        classItemSearch();
    });

    $("#keyword").on(
        "keyup",
        _.debounce(function (e) {
            studentSearch();
        }, 600)
    );
    $("#courseId").change(function (e) {
        studentSearch();
    });
    $("#classId").change(function (e) {
        studentSearch();
    });

    $("#usersearch").on(
        "keyup",
        _.debounce(function (e) {
            userSearch();
        }, 600)
    );

    $("#lecturersearch").on(
        "keyup",
        _.debounce(function (e) {
            lecturersearch();
        }, 600)
    );

    $("#paymentId").on(
        "keyup",
        _.debounce(function (e) {
            paymentSearch();
        }, 600)
    );

    $("#classPayment").on(
        "keyup",
        _.debounce(function (e) {
            // console.log('aa');
            classPaymentSearch();
        }, 600)
    );

    $("#studentId").change(function (e) {
        paymentSearch();
    });
    $("#courseIdPay").change(function (e) {
        paymentSearch();
    });
    $("#classIdPay").change(function (e) {
        paymentSearch();
    });

    function classItemSearch() {
        var classitemsearch = $("#classitemsearch").val();
        var coursesearchclassitem = $("#coursesearchclassitem").val();
        var studentsearchclassitem = $("#studentsearchclassitem").val();

        if (!coursesearchclassitem == "") {
            $(".seachby").show();
        }
        $("#liveText").text(
            $("#coursesearchclassitem").find(":selected").text()
        );

        let query = `?classitemsearch=${classitemsearch}&coursesearchclassitem=${coursesearchclassitem}&studentsearchclassitem=${studentsearchclassitem}`;

        // console.log(window.location.href + query);

        // window.location.href = window.location.href + query;
        window.history.pushState({}, "", "classitem" + query);

        if (
            classitemsearch ||
            coursesearchclassitem ||
            studentsearchclassitem
        ) {
            $(".original").hide();
            $(".find").show();
            $(".alertfind").hide();
            $(".load-more-data").hide();
            $(".load-more-data2").show();
        } else {
            $(".original").show();
            $(".find").hide();
            $(".load-more-data").show();
            $(".load-more-data2").hide();
        }

        if ($(".find tr").length < 15) {
            $(".load-more-data2").hide();
        }

        // if (!window.location.href.includes("search")) {
        $.ajax({
            url: "/classitemsearch",
            method: "GET",
            data: {
                classitemsearch,
                coursesearchclassitem,
                studentsearchclassitem,
            },
            success: function success(data) {
                $(".find").html(data);
                deletealert();
            },
        });

        // } else {
        //     $.ajax({
        //         url: "/classitemfilter",
        //         method: "GET",
        //         data: {
        //             classitemsearch: classitemsearch,
        //         },
        //         success: function success(data) {
        //             $(".find").html(data);
        //         },
        //     });
        // }
    }

    function userSearch() {
        var usersearch = $("#usersearch").val();

        let query = `?usersearch=${usersearch}`;

        // console.log(window.location.href + query);

        // window.location.href = window.location.href + query;
        window.history.pushState({}, "", "user" + query);

        if (usersearch) {
            $(".original").hide();
            $(".find").show();
            $(".load-more-data").hide();
            $(".load-more-data2").show();
        } else {
            $(".original").show();
            $(".find").hide();
            $(".load-more-data").show();
            $(".load-more-data2").hide();
        }

        if ($(".find tr").length < 15) {
            $(".load-more-data2").hide();
        }

        // if (!window.location.href.includes("search")) {
        $.ajax({
            url: "/adminmsearch",
            method: "GET",
            data: {
                usersearch,
            },
            success: function success(data) {
                $(".find").html(data);
                deletealert();
            },
        });

        // } else {
        //     $.ajax({
        //         url: "/classitemfilter",
        //         method: "GET",
        //         data: {
        //             classitemsearch: classitemsearch,
        //         },
        //         success: function success(data) {
        //             $(".find").html(data);
        //         },
        //     });
        // }
    }

    function lecturerSearch() {
        var lecturersearch = $("#lecturersearch").val();

        let query = `?lecturersearch=${lecturersearch}`;

        // console.log(window.location.href + query);

        // window.location.href = window.location.href + query;
        window.history.pushState({}, "", "lecturer" + query);

        if (lecturersearch) {
            $(".original").hide();
            $(".find").show();
            $(".load-more-data").hide();
            $(".load-more-data2").show();
        } else {
            $(".original").show();
            $(".find").hide();
            $(".load-more-data").show();
            $(".load-more-data2").hide();
        }

        if ($(".find tr").length < 15) {
            $(".load-more-data2").hide();
        }

        // if (!window.location.href.includes("search")) {
        $.ajax({
            url: "/lecturersearch",
            method: "GET",
            data: {
                lecturersearch,
            },
            success: function success(data) {
                $(".find").html(data);
                deletealert();
            },
        });

        // } else {
        //     $.ajax({
        //         url: "/classitemfilter",
        //         method: "GET",
        //         data: {
        //             classitemsearch: classitemsearch,
        //         },
        //         success: function success(data) {
        //             $(".find").html(data);
        //         },
        //     });
        // }
    }

    function studentSearch() {
        var keyword = $("#keyword").val();
        var courseId = $("#courseId").val();
        var classId = $("#classId").val();

        if (!courseId == "") {
            $(".seachby").show();
        }
        $("#liveText").text(
            $("#coursesearchclassitem").find(":selected").text()
        );

        let query = `?studentsearch=${keyword}&studentByCourse=${courseId}&studentByClass=${classId}`;

        // console.log(window.location.href + query);

        // window.location.href = window.location.href + query;
        window.history.pushState({}, "", "student" + query);

        if (keyword || courseId || classId) {
            $(".original").hide();
            $(".find").show();
            $(".load-more-data").hide();
            $(".load-more-data2").show();
        } else {
            $(".original").show();
            $(".find").hide();
            $(".load-more-data").show();
            $(".load-more-data2").hide();
        }

        if ($(".find tr").length < 15) {
            $(".load-more-data2").hide();
        }

        // if (!window.location.href.includes("search")) {
        $.ajax({
            url: "/studentsearch",
            method: "GET",
            data: {
                keyword: keyword,
                studentByCourse: courseId,
                studentByClass: classId,
            },
            success: function success(data) {
                $(".find").html(data);
                
                deletealert();
            },
        });

        // } else {
        //     $.ajax({
        //         url: "/classitemfilter",
        //         method: "GET",
        //         data: {
        //             classitemsearch: classitemsearch,
        //         },
        //         success: function success(data) {
        //             $(".find").html(data);
        //         },
        //     });
        // }
    }
    
    function paymentSearch() {
        var paymentId = $("#paymentId").val();
        var studentId = $("#studentId").val();       
        var courseId = $("#courseIdPay").val();
        var classId = $("#classIdPay").val();

        let query = `?search=${paymentId}&paymentByStudent=${studentId}&paymentByCourse=${courseId}&paymentByClass=${classId}`;

        // console.log(window.location.href + query);

        // window.location.href = window.location.href + query;
        window.history.pushState({}, "", "payment" + query);
        
        if (paymentId || studentId || courseId || classId) {
            $(".original").hide();
            $(".find").show();
            $(".load-more-data").hide();
            $(".load-more-data2").show();
        } else {
            $(".original").show();
            $(".find").hide();
            $(".load-more-data").show();
            $(".load-more-data2").hide();
        }



        // if (!window.location.href.includes("search")) {
        $.ajax({
            url: "/paymentsearch",
            method: "GET",
            data: {
                search: paymentId,
                paymentByStudent: studentId,
                paymentByCourse: courseId,
                paymentByClass: classId,
            },
            success: function success(data) {
                // console.log(data);
                $(".find").html(data); 
                if ($(".find tr").length < 15) {
                    $(".load-more-data2").hide();
                }
        
                
                console.log($(".find tr").length);       
            },
        });

        // } else {
        //     $.ajax({
        //         url: "/classitemfilter",
        //         method: "GET",
        //         data: {
        //             classitemsearch: classitemsearch,
        //         },
        //         success: function success(data) {
        //             $(".find").html(data);
        //         },
        //     });
        // }
    }

    function classPaymentSearch() {
        
        var paymentId = $("#classPayment").val();
        var selectedClassId = $("#selectedClass").val();
        console.log(paymentId);

       

        // console.log(window.location.href + query);

        // window.location.href = window.location.href + query;
       

        if (paymentId || selectedClassId) {
            $(".original").hide();
            $(".find").show();
            $(".load-more-data").hide();
            $(".load-more-data2").show();
        } else {
            $(".original").show();
            $(".find").hide();
            $(".load-more-data").show();
            $(".load-more-data2").hide();
        }

        if ($(".find tr").length < 15) {
            $(".load-more-data2").hide();
        }


        // if (!window.location.href.includes("search")) {
        $.ajax({
            url: "/classpaymentsearch",
            method: "GET",
            data: {
                search: paymentId,
                classId: selectedClassId
            },
            success: function success(data) {
                // console.log(data);
                $(".find").html(data);        
            },
        });

       
    }

    //sweetalert2
    function deletealert() {
        $(".alertbox").map(function () {
            $(this).click(function (event) {
                var form = $(this).closest("form");
                var name = $(this).data("name");
                event.preventDefault();
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire(
                            "Deleted!",
                            "Your file has been deleted.",
                            "success"
                        );
                        setTimeout(() => {
                            form.submit();
                        }, 3000);
                    }
                });
            });
        });
    }

    deletealert();

    //classitem index table expend
    $(".dropdown-arrowIcon").click(function () {
        $(this).toggleClass("dropup-arrowIcon");
    });

    $(".dropdown-arrowIcon2").click(function () {
        $(this).toggleClass("dropup-arrowIcon2");
    });

    //Scheduling
    var scheduledata = JSON.parse($("#scheduler").val());
    $("td").each(function () {
        var tdId = $(this).attr("id");
        if (tdId) {
            var sliceId = tdId.slice(2, 17);
            var arr = sliceId.split("");
            var del1 = arr.splice(2, 6);
            var del2 = arr.splice(6, 1);
            var splitarr = [
                arr.splice(0, 2).join(""),
                arr.splice(0, 4).join(""),
                arr.join(""),
            ];
            $.each(
                scheduledata,
                function (index, schedule) {
                    var dbstrtime = schedule.start_time.slice(0, 2);
                    var dbstartdate = schedule.start_date.slice(5, 7);
                    var dbstartyear = schedule.start_date.slice(0, 4);
                    var timedif =
                        schedule.end_time.slice(0, 2) -
                        schedule.start_time.slice(0, 2);
                    var monthdif =
                        schedule.end_date.slice(5, 7) -
                        schedule.start_date.slice(5, 7) +
                        1;
                    var tablemonth = parseInt(splitarr[2]) + 1;

                    for (var i = 0; i < monthdif; i++) {
                        tablemonth--;
                        var tablehour = "";
                        tablehour = parseInt(splitarr[0]) + 1;
                        for (var j = -1; j < timedif; j++) {
                            tablehour--;
                            if (
                                dbstrtime == tablehour &&
                                dbstartyear == splitarr[1] &&
                                dbstartdate == tablemonth
                            ) {
                                // $(this).css("background-color", "red");
                            }
                        }
                    }
                }.bind(this)
            );
        }
    });
});

//Course Create

//navbar menu btn
$(".nav-toggler").on("click", function (event) {
    event.preventDefault();
    $(".navbar-header").toggleClass("add-nav-header");
    $(".nav-toggler").toggleClass("add-nav-toggler");
    $(".navbar-brand").toggleClass("d-none");
    $(".logo-text").toggleClass("add-logo-text");
});

//Select 2
$(document).ready(function () {
    $(".js-example-basic-single").map(function () {
        $(this).select2();
    });
});

//tooltip
$('#asdf').on('mouseenter', function(){
    setTimeout(() => {
        $('#asdf').tooltip('show');
    }, 5000);
})

//card height
// $(".card").map(function () {
//     let cardHeight = $(this).innerHeight();
//     // console.log('card' + cardHeight);
//     let mainHeight = window.innerHeight - 120;
//     // console.log(mainHeight);
//     $(this).css("height", mainHeight);
// });

// $(".ui.dropdown").map(function () {
//     $(this).dropdown();
// });
