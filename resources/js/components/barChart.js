import axios from "axios";

const init = async () => {
    // data [{"count" : "", date: ""}]
    const chart = $("#js-bar-chart");

    if (chart.length) {
        var barChart = document.getElementById("js-bar-chart").getContext("2d");
        import("chart.js/auto").then(async ({ default: Chart }) => {
            const res = await axios.get("/admin/dashboard/chart");
            var chartId = new Chart(barChart, {
                type: "bar",
                data: {
                    labels: res.data.items.map((item) => item.date),
                    datasets: [
                        {
                            label: "online tutorial subjects",
                            data: res.data.items.map((item) => item.count),
                            backgroundColor: ["blue"],
                            borderColor: ["black"],
                        },
                    ],
                },
                options: {
                    responsive: true,
                },
            });
        });
    }
};

export default {
    init,
};
