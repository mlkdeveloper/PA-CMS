<div class="container">

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col">
        <div class="jumbotron" id="jumbotronTurnover">
            <select class="input" onchange="getData(this.value, 'turnover')">
                <option value="month">1 Mois</option>
                <option value="months">6 Mois</option>
                <option value="year">1 An</option>
                <option value="all">Depuis le début</option>
            </select>
            <h3 class="centered">Chiffre d'affaires</h3>
            <canvas id="turnover" width="170" height="60"></canvas>
        </div>
    </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col">
            <div class="jumbotron" id="jumbotronSales">
                <select class="input" onchange="getData(this.value, 'sales')">
                    <option value="month">1 Mois</option>
                    <option value="months">6 Mois</option>
                    <option value="year">1 An</option>
                    <option value="all">Depuis le début</option>
                </select>
                <h3 class="centered">Ventes</h3>
                <canvas id="chartSales" width="170" height="60"></canvas>
            </div>
        </div>

    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
<script src="../public/js/charts.js"></script>