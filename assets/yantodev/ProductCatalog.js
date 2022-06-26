function addProduct() {
    Swal.fire({
        title: "Add Catalog",
        html: `
            <div>
                <label for="category">Category</label>
                    <select id="productCategory">
                        <option value="">Select Category</option>
                        <option value="1">Category 1</option>
                        <option value="2">Category 2</option>
                        <option value="3">Category 3</option>
                    </select>
                <label for="name">Name</label>
                    <input type="text" id="productName" class="swal2-input" placeholder="product name" >
                <label for="detail">Detail</label>
                    <input type="text" id="productDetail" class="swal2-input" placeholder="product detail" >
                <label for="price">Price</label>
                    <input type="number" id="productPrice" class="swal2-input" placeholder="product price" >
                <label for="image">Image</label>
                    <input type="text" id="productImage" class="swal2-input" placeholder="product image" >
                <label for="netto">Netto</label>
                    <input type="text" id="productNetto" class="swal2-input" placeholder="product netto" >
                <label for="pom">POM</label>
                    <input type="text" id="noPom" class="swal2-input" placeholder="Nomor POM" >
            </div>
                `,
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: "Add",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            const productCategory = Swal.getPopup().querySelector("#productCategory")
                .value;
            const productName = Swal.getPopup().querySelector("#productName").value;
            const productDetail = Swal.getPopup().querySelector("#productDetail")
                .value;
            const productPrice = Swal.getPopup().querySelector("#productPrice").value;
            const productImage = Swal.getPopup().querySelector("#productImage").value;
            const productNetto = Swal.getPopup().querySelector("#productNetto").value;
            const noPom = Swal.getPopup().querySelector("#noPom").value;
            $.ajax({
                type: "POST",
                url: configUrl + "/admin/addCatalog",
                data: {
                    productCategory: productCategory,
                    productName: productName,
                    productDetail: productDetail,
                    productPrice: productPrice,
                    productImage: productImage,
                    productNetto: productNetto,
                    noPom: noPom,
                },
                cache: false,
                dataType: "json",
                beforeSend: function (e) {
                    if (e && e.overrideMimeType) {
                        e.overrideMimeType("application/json;charset=UTF-8");
                    }
                },
                success: function () {},
            });
        },
        allowOutsideClick: () => !Swal.isLoading(),
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                icon: "success",
                title: "data added successfully!!!",
            });
            setTimeout(function () {
                window.location.reload(1);
            }, 1000);
        }
    });
}

function updateCatalog(id, name, detail, price, image, netto, pom, categoryId) {
    Swal.fire({
        title: "Edit Category",
        html: `
            <div>
                    <input type="hidden" id="id" class="swal2-input" placeholder="id" value="${id}">
                <div>
                    <label for="name">Name</label>
                    <input type="number" id="name" class="swal2-input" placeholder="product name" value="${name}">
                </div>
                <div>
                    <label for="detail">Detail</label>
                    <input type="text" id="detail" class="swal2-input" placeholder="product detail" value="${detail}">
                </div>
                <div>
                    <label for="price">Price</label>
                    <input type="number" id="price" class="swal2-input" placeholder="product price" value="${price}">
                </div>
                <div>
                    <label for="image">Image</label>
                    <input type="text" id="image" class="swal2-input" placeholder="product image" value="${image}">
                </div>
                <div>
                    <label for="netto">Netto</label>
                    <input type="text" id="netto" class="swal2-input" placeholder="product netto" value="${netto}">
                </div>
                <div>
                    <label for="pom">POM</label>
                    <input type="text" id="pom" class="swal2-input" placeholder="product pom" value="${pom}">
                </div>
                <div>
                    <select>
                        <option value="${categoryId}">${categoryId}</option>
                    </select>
                </div>
            </div>
                `,
        customClass: 'swal-wide',
        focusConfirm: false,
        showCancelButton: true,
        confirmButtonText: "Update",
        showLoaderOnConfirm: true,
        preConfirm: () => {
            const id = Swal.getPopup().querySelector("#id").value;
            const name = Swal.getPopup().querySelector("#name").value;
            const detail = Swal.getPopup().querySelector("#detail").value;
            const price = Swal.getPopup().querySelector("#price").value;
            const image = Swal.getPopup().querySelector("#image").value;
            const netto = Swal.getPopup().querySelector("#netto").value;
            const pom = Swal.getPopup().querySelector("#pom").value;
            $.ajax({
                type: "POST",
                url: configUrl + "/admin/updateCatalog/" + id,
                data: {
                    name: name,
                    detail: detail,
                    price: price,
                    image: image,
                    netto: netto,
                    pom: pom,
                },
                cache: false,
                dataType: "json",
                beforeSend: function (e) {
                    if (e && e.overrideMimeType) {
                        e.overrideMimeType("application/json;charset=UTF-8");
                    }
                },
                success: function () {},
            });
        },
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                icon: "success",
                title: "data updated successfully!!!",
            });
            setTimeout(function () {
                window.location.reload(1);
            }, 1000);
        }
    });
}

function deleteCatalog(id) {
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
            $.ajax({
                    type: "POST",
                    url: configUrl + "/admin/deleteCatalog/" + id,
                    cache: false,
                    dataType: "json",
                    beforeSend: function (e) {
                        if (e && e.overrideMimeType) {
                            e.overrideMimeType("application/json;charset=UTF-8");
                        }
                    },
                    success: function () {},
                }),
                Swal.fire("Deleted!", "Your file has been deleted.", "success");
            setTimeout(function () {
                window.location.reload(1);
            }, 1000);
        }
    });
}