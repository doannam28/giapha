<script>
    var chart_config = {
        chart: {
            container: "#chart-genealogy",
            animation: {
                nodeSpeed: 0,
                connectorsSpeed: 0,
            },
            connectors: {
                type: "step",
                style: {
                    "arrow-end": "block-wide-long",
                },
            },
            levelSeparation: 40,
            padding: 96,
        },

        nodeStructure: <?= $processedData; ?>
    };
</script>
<style>
.Viewed {width:100%;}
@media only screen and (min-width: 600px) {
    .Treant {overflow: unset !important;}
}
</style>
<div class="chart" id="chart">
    <div class="legend__note">
        Nhấn vào tên mỗi người để biết thông tin chi tiết<br />
        Nhấn vào dấu [ + ] để xem các đời sau (nếu có)
    </div>
    <div class="Viewed" id="wraper-chart" style="overflow: auto;"><div id="chart-genealogy"></div></div>
    <div class="legend">
        <div class="legend__title">CHÚ THÍCH</div>
        <div class="legend__list">
            <ul>
                <li>
                    <span class="label label--text label--origin"></span>Chồng
                </li>
                <li>
                    <span class="label label--text label--partner"></span>Vợ
                </li>
                <li>
                    <span class="label label--bg label--male"></span>Con
                    trai
                </li>
                <li>
                    <span class="label label--bg label--female"></span>Con
                    gái
                </li>
            </ul>
        </div>
        <div class="legend__note">
            Nhấn vào tên mỗi người để biết thông tin chi tiết<br />
            Nhấn vào dấu [ + ] để xem các đời sau (nếu có)
        </div>
    </div>
    <div class="buttons phado-controls">
        <button id="zoom-in"></button>
        <button id="zoom-out"></button>
        <button id="reset">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-crosshair2" viewBox="0 0 16 16">
              <path d="M8 0a.5.5 0 0 1 .5.5v.518A7 7 0 0 1 14.982 7.5h.518a.5.5 0 0 1 0 1h-.518A7 7 0 0 1 8.5 14.982v.518a.5.5 0 0 1-1 0v-.518A7 7 0 0 1 1.018 8.5H.5a.5.5 0 0 1 0-1h.518A7 7 0 0 1 7.5 1.018V.5A.5.5 0 0 1 8 0m-.5 2.02A6 6 0 0 0 2.02 7.5h1.005A5 5 0 0 1 7.5 3.025zm1 1.005A5 5 0 0 1 12.975 7.5h1.005A6 6 0 0 0 8.5 2.02zM12.975 8.5A5 5 0 0 1 8.5 12.975v1.005a6 6 0 0 0 5.48-5.48zM7.5 12.975A5 5 0 0 1 3.025 8.5H2.02a6 6 0 0 0 5.48 5.48zM10 8a2 2 0 1 0-4 0 2 2 0 0 0 4 0"/>
            </svg>
        </button>
    </div>
</div>