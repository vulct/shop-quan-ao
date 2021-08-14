<!--======= SUB BANNER =========-->
<section class="sub-bnr" data-stellar-background-ratio="0.5">
    <div class="position-center-center">
        <div class="container">
            <h4>The Best Shop Collection</h4>
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#">Pages</a></li>
                <li class="active">Search</li>
            </ol>
        </div>
    </div>
</section>

<!-- Content -->
<div id="content">

    <!-- Products -->
    <section class="shop-page padding-top-100 padding-bottom-100">
        <div class="container-full">
            <div class="row">
                <!-- Item Content -->
                <div class="col-md-12">
                    <div class="input-group">
                        <input type="text" id="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon"/>
                    </div>
                    <div class="sidebar-layout padding-top-50">
                        <!-- Item -->
                        <div id="products" class="arrival-block col-item-4 list-group">
                            <div class="row" id="result"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(function () {
        $('#search').keyup(function () {
            var txt = $(this).val();
            if (txt !== '') {
                $.ajax({
                    url: "?mod=search&act=get",
                    method: "post",
                    data: {search: txt},
                    success: function (data) {
                        $("#result").html(data);
                    }
                });
            }
        });
    });
</script>