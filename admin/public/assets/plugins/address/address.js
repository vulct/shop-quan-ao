const province = document.getElementById('province');
const district = document.getElementById('district');
const wards = document.getElementById('wards');

function sortArrayByName(item1, item2){
    if (item1.name > item2.name){
        return 1;
    }
    if (item1.name < item2.name){
        return -1;
    }
    return 0;
}


fetch('public/assets/plugins/address/nested-divisions.json')
    .then(response => response.json())
    .then(dt => {
        dt.sort(sortArrayByName);
        const tinhOp = dt.map((tinh) => `<option value="${tinh.code}">${tinh.name}</option>`)
        province.innerHTML = tinhOp;

        province.addEventListener('change', (e) => {
            e.preventDefault();
            const tinhOp = dt.map((tinh, index) => {
                if (tinh.code == e.target.value){
                    const arrHuyen = dt[index].districts;
                    arrHuyen.sort(sortArrayByName);
                    const huyenOp = arrHuyen.map((huyen) => `<option value="${huyen.code}">${huyen.name}</option>`)
                    huyenOp.unshift('<option selected>Chọn Quận/Huyện</option>');
                    district.innerHTML = huyenOp;
                    wards.innerHTML = '<option selected>Chọn Phường/Xã</option>';
                }
            })
        });


        district.addEventListener('change', (e) => {
            e.preventDefault();
            dt.map((tinh, indexTinh) => {
                if (tinh.code == province.value){
                    const arrHuyen = dt[indexTinh].districts;
                    arrHuyen.sort(sortArrayByName);
                    const huyenOp = arrHuyen.map((huyen, index) => {
                        if (huyen.code == e.target.value){
                            const arrXa = dt[indexTinh].districts[index].wards;
                            arrXa.sort(sortArrayByName);

                            const xaOp = arrXa.map((xa) => `<option value="${xa.code}">${xa.name}</option>`)
                            xaOp.unshift('<option selected>Chọn Phường/Xã</option>');
                            wards.innerHTML = xaOp;
                        }
                    });
                }
            })
        })
        wards.addEventListener('change', (e) => {
            e.preventDefault();
        });
    })
