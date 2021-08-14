<!--======= SUB BANNER =========-->
<section class="sub-bnr" data-stellar-background-ratio="0.5">
    <div class="position-center-center">
        <div class="container">
            <h4>Personal Page</h4>
            <ol class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li class="active">Profile</li>
            </ol>
        </div>
    </div>
</section>
<!-- Content -->
<section class="blog-list blog-list-3 single-post padding-top-50 padding-bottom-150">
    <div id="content">
        <div class="container">
            <div class="row">
                    <div class="col-md-4">
                        <!-- ADMIN info -->
                        <div class="admin-info">
                            <div class="media-left">
                                <img src="<?= MAIN_URL ?>assets/images/avatar-profile/VectorStock.png" style="width: 255px" class="rounded mx-auto d-block"
                                     alt="..."/>
                            </div>
                            <div class="media-body">
                                <h6><?=$dataViews['profile']['uFirstName']." ".$dataViews['profile']['uLastName']?></h6>
<!--                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. NullamMorbi ac scelerisque-->
<!--                                    mauris. Etiam sodales a nulla ornare viverra. Nunc at blandit neque, bociis natoque-->
<!--                                    penatcing e scelerisque miscing elit. </p>-->
                                <p class="font-weight-bold">Registered At: <?= date("H:i:s - d/m/Y", strtotime($dataViews['profile']['uRegisteredAt']))?></p>
                                <p class="font-weight-bold">Last Update: <?=date("H:i:s - d/m/Y",strtotime($dataViews['profile']['uUpdateAt']))?> </p>
                                <p class="font-weight-bold">Last Login: <?=date("H:i:s - d/m/Y",strtotime($dataViews['profile']['uLastLogin']))?> </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">User Profile</a>
                                <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Order History</a>
                                <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false">Change Password</a>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                <div class="p-4">
                                    <form class="update-info" id="update-info" method="post" onSubmit="return false">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="first_name">First Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="first_name" placeholder="First Name" name="uFirstName" value="<?=$dataViews['profile']['uFirstName']?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="last_name">Last Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="last_name" placeholder="Last Name" name="uLastName" value="<?=$dataViews['profile']['uLastName']?>">
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="inputEmail4">Email</label>
                                                <input type="email" class="form-control" id="inputEmail4" placeholder="Email" readonly value="<?=$dataViews['profile']['uEmail']?>">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="mobile">Mobile <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="mobile" placeholder="Mobile" name="uMobile" value="<?=$dataViews['profile']['uMobile']?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label for="province">Province/City <span class="text-danger">*</span></label>
                                                <div class="form-group">
                                                    <select id="province" name="province" class="form-control" required>
                                                        <option value="">Select Province/City</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="district">District <span class="text-danger">*</span></label>
                                                <div class="form-group">
                                                    <select id="district" name="district" class="form-control" required>
                                                        <option selected>Select District</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <label for="wards">Ward/Commune <span class="text-danger">*</span></label>
                                                <div class="form-group">
                                                    <select id="wards" name="wards" class="form-control" required>
                                                        <option selected>Select Ward/Commune</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="address">Address <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="address" placeholder="Address" name="uAddress" value="<?=$dataViews['profile']['uAddress']?>">
                                        </div>
                                        <button type="submit" class="btn btn-primary" onclick="updateInfo();">Save</button>
                                    </form>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                <div class="p-4">
                                    <div class="row">

                                        <div class="table-responsive">
                                        <table class="table table-striped" style="text-align: center">
                                            <thead>
                                            <tr>
                                                <th scope="col">No.</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Order Date</th>
                                                <th scope="col">Total Price</th>
                                                <th scope="col"> Status</th>
                                                <th scope="col"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $i = 1;
                                            foreach ($dataViews['history'] as $key => $his){ ?>
                                            <tr>
                                                <td scope="row"><?=$i?></td>
                                                <td><a href="?mod=profile&act=bill&id=<?=$his['biID']?>" style="color: #0d47a1"><?=$his['biName']?></a></td>
                                                <td><?=date('H:i:s d-m-Y',strtotime($his['biCreateAt']))?></td>
                                                <td>$<?=$his['totalMoney']?></td>
                                                <td>
                                                    <?php
                                                    if($his['biStatus'] == 0 || $his['biStatus'] == null){
                                                        echo "<p class='text-secondary'>Being processed</p>";
                                                    }elseif ($his['biStatus'] == 1){
                                                        echo "<p class='text-primary'>Confirmed</p>";
                                                    }elseif ($his['biStatus'] == 2){
                                                        echo "<p class='text-warning'>Being transported</p>";
                                                    }elseif ($his['biStatus'] == 3){
                                                        echo "<p class='text-success'>Delivered</p>";
                                                    }elseif ($his['biStatus'] == 4){
                                                        echo "<p class='text-danger'>Cancelled</p>";
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php $i++; } ?>
                                            </tbody>
                                        </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                                <div class="p-4">
                                    <form id="change-password" method="post" onSubmit="return false" >
                                        <div class="form-group">
                                            <label for="currentPassword">Current Password <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="currentPassword" name="currentPassword" placeholder="Current Password">
                                        </div>
                                        <div class="form-group">
                                            <label for="newPassword">New Password <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="newPassword" name="newPassword"  placeholder="New Password">
                                        </div>
                                        <div class="form-group">
                                            <label for="confirmPassword">Confirm New Password <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"  placeholder="Confirm New Password">
                                        </div>
                                        <?php
                                            if (isset($_COOKIE['error_change_password'])){ ?>
                                                <li class="col-md-12">
                                                    <div class="alert alert-danger" role="alert">
                                                        <strong>Error change!</strong> <?= $_COOKIE['error_change_password']; ?>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        <button type="submit" id="btn-change-password" class="btn btn-primary" onclick="changePassword();">Change Password</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script>
    function sortArrayByName(item1, item2) {
        if (item1.name > item2.name) {
            return 1;
        }
        if (item1.name < item2.name) {
            return -1;
        }
        return 0;
    }

    const wardsCurr = "<?=$dataViews['profile']['uWards']?>";
    const districtCurr = "<?=$dataViews['profile']['uDistrict']?>";
    const provinceCurr = "<?=$dataViews['profile']['uProvince']?>";

    const province = document.getElementById('province');
    const district = document.getElementById('district');
    const wards = document.getElementById('wards');
    fetch('public/assets/json/nested-divisions.json')
        .then(response => response.json())
        .then(dt => {
            if (wardsCurr !== "" && districtCurr !== "" && provinceCurr !== "") {
                dt.sort(sortArrayByName);
                const tinhOp = dt.map((tinh) => `<option value="${tinh.code}">${tinh.name}</option>`)
                province.innerHTML = tinhOp;
                const arrValueProvince = [];

                const arrValueWards = [];

                $('#province option').each(function () {
                    arrValueProvince.push(this.value);
                });

                for (let i = 0; i < arrValueProvince.length; i++) {
                    if (arrValueProvince[i] == parseInt(provinceCurr) ) {
                        $('#province option').eq(i).prop('selected', true);
                    }
                }

                dt.map((tinh, index) => {
                    if (tinh.code == province.value) {
                        const arrHuyen = dt[index].districts;
                        arrHuyen.sort(sortArrayByName);
                        const huyenOp = arrHuyen.map((huyen) => `<option value="${huyen.code}">${huyen.name}</option>`)
                        huyenOp.unshift('<option value="" selected>Select District</option>');
                        district.innerHTML = huyenOp;
                        wards.innerHTML = '<option value="" selected>Select Ward/Commune</option>';
                    }
                })

                const arrValueDistrict = [];
                $('#district option').each(function () {
                    arrValueDistrict.push(this.value);
                });
                for (let i = 0; i < arrValueDistrict.length; i++) {
                    if (arrValueDistrict[i] == parseInt(districtCurr)) {
                        $('#district option').eq(i).prop('selected', true);
                    }
                }

                dt.map((tinh, indexTinh) => {
                    if (tinh.code == province.value) {
                        const arrHuyen = dt[indexTinh].districts;
                        arrHuyen.sort(sortArrayByName);
                        const huyenOp = arrHuyen.map((huyen, index) => {
                            if (huyen.code == district.value) {
                                const arrXa = dt[indexTinh].districts[index].wards;
                                arrXa.sort(sortArrayByName);
                                const xaOp = arrXa.map((xa) => `<option value="${xa.code}">${xa.name}</option>`)
                                xaOp.unshift('<option value="" selected>Select Ward/Commune</option>');
                                wards.innerHTML = xaOp;
                            }
                        });
                    }
                })

                $('#wards option').each(function () {
                    arrValueWards.push(this.value);
                });
                for (let i = 0; i < arrValueWards.length; i++) {
                    if (arrValueWards[i] == parseInt(wardsCurr)) {
                        $('#wards option').eq(i).prop('selected', true);
                    }
                }

                // event change
                province.addEventListener('change', (e) => {
                    e.preventDefault();
                    const tinhOp = dt.map((tinh, index) => {
                        if (tinh.code == e.target.value) {
                            const arrHuyen = dt[index].districts;
                            arrHuyen.sort(sortArrayByName);
                            const huyenOp = arrHuyen.map((huyen) => `<option value="${huyen.code}">${huyen.name}</option>`);
                            huyenOp.unshift('<option value="" selected>Select District</option>');
                            district.innerHTML = huyenOp;
                            wards.innerHTML = '<option value="" selected>Select Ward/Commune</option>';
                        }
                    })
                });
                district.addEventListener('change', (e) => {
                    e.preventDefault();
                    dt.map((tinh, indexTinh) => {
                        if (tinh.code == province.value) {
                            const arrHuyen = dt[indexTinh].districts;
                            arrHuyen.sort(sortArrayByName);
                            const huyenOp = arrHuyen.map((huyen, index) => {
                                if (huyen.code == e.target.value) {
                                    const arrXa = dt[indexTinh].districts[index].wards;
                                    arrXa.sort(sortArrayByName);
                                    const xaOp = arrXa.map((xa) => `<option value="${xa.code}">${xa.name}</option>`);
                                    xaOp.unshift('<option value="" selected>Select Ward/Commune</option>');
                                    wards.innerHTML = xaOp;
                                }
                            });
                        }
                    });
                });
                wards.addEventListener('change', (e) => {
                    e.preventDefault();
                });
            } else {
                dt.sort(sortArrayByName);
                const tinhOp = dt.map((tinh) => `<option value="${tinh.code}">${tinh.name}</option>`)
                province.innerHTML = tinhOp;

                province.addEventListener('change', (e) => {
                    e.preventDefault();
                    const tinhOp = dt.map((tinh, index) => {
                        if (tinh.code == e.target.value) {
                            const arrHuyen = dt[index].districts;
                            arrHuyen.sort(sortArrayByName);
                            const huyenOp = arrHuyen.map((huyen) => `<option value="${huyen.code}">${huyen.name}</option>`)
                            huyenOp.unshift('<option value="" selected>Select District</option>');
                            district.innerHTML = huyenOp;
                            wards.innerHTML = '<option value="" selected>Select Ward/Commune</option>';
                        }
                    })
                });


                district.addEventListener('change', (e) => {
                    e.preventDefault();
                    dt.map((tinh, indexTinh) => {
                        if (tinh.code == province.value) {
                            const arrHuyen = dt[indexTinh].districts;
                            arrHuyen.sort(sortArrayByName);
                            const huyenOp = arrHuyen.map((huyen, index) => {
                                if (huyen.code == e.target.value) {
                                    const arrXa = dt[indexTinh].districts[index].wards;
                                    arrXa.sort(sortArrayByName);

                                    const xaOp = arrXa.map((xa) => `<option value="${xa.code}">${xa.name}</option>`)
                                    xaOp.unshift('<option value="" selected>Select Ward/Commune</option>');
                                    wards.innerHTML = xaOp;
                                }
                            });
                        }
                    })
                })
                wards.addEventListener('change', (e) => {
                    e.preventDefault();
                });
            }

        });

</script>