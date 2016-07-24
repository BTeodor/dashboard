dashboard = {};

dashboard.adjustWidgetsHeight = function () {
    var maxHeight = 0;
    $(".panel-widget .panel-heading").height('auto');
    $(".panel-widget .panel-heading").each(function () {
        if ($(this).height() > maxHeight) {
            maxHeight = $(this).height();
        }
    });
    $(".panel-widget .panel-heading").height(maxHeight);
};

dashboard.initChart = function () {
    var data = {
        labels: months,
        datasets: [
            {
                label: trans.chartLabel,
                fillColor: "#605ca8",
                strokeColor: "rgba(0,0,0,0.0)",
                pointColor: "#fff",
                pointStrokeColor: "#605ca8",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "#605ca8",
                data: users
            }
        ]
    };

    var ctx = document.getElementById("myChart").getContext("2d");
    var myLineChart = new Chart(ctx).Line(data, {
        responsive: true,
        maintainAspectRatio: false,
        tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %> "+trans.new+" <%= value == 1 ? '"+trans.user+"' : '"+trans.users+"' %>",
    });
};

$(document).ready(function () {
    dashboard.adjustWidgetsHeight();
    dashboard.initChart();
});