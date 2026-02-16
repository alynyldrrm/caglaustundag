const fieldTypes = [
    { label: "Yazı", type: "input|text" },
    { label: "Sayı", type: "input|number" },
    { label: "Email", type: "input|email" },
    { label: "Şifre", type: "input|password" },
    { label: "Url", type: "input|url" },
    { label: "Tarih", type: "input|date" },
    { label: "Textarea", type: "textarea|textarea" },
    { label: "Select", type: "select|select" },
    { label: "Checkbox", type: "input|checkbox" },
    { label: "Radio", type: "input|radio" },
    { label: "Metin Editoru", type: "textarea|editor" },
    { label: "Dosya (Tekil)", type: "input|file|single" },
    { label: "Dosya (Çoğul)", type: "input|file|multiple" },
];

const addFieldRow = () => {
    const fieldList = document.getElementById("field-list");
    let row = `
    <tr>
    <input type="hidden" name="fieldIds[]">
        <td>
            <input type="text" class="form-control" name="key[]" />
        </td>
        <td>
            <select name="type[]" id="" class="form-select">
            ${fieldTypes.map((field) => `<option value="${field.type}">${field.label}</option>`).join("")}
            </select>
        </td>
        <td>
            <input type="text" class="form-control" name="name[]" />
        </td>
        <td>
            <input type="text" class="form-control" name="attr[]" />
        </td>
        <td>
            <input type="text" class="form-control" name="values[]" />
        </td>
        <td>
            <button onclick="removeFieldInDom(this)" type="button" class="btn btn-danger">
                Sil
            </button>
        </td>
    </tr>
    `;
    fieldList.insertAdjacentHTML('beforeend', row);
}
const removeFieldInDom = (e, type = null) => {
    if (confirm("Silmek istediğinize emin misiniz?")) {
        if (type === null) {
            e.parentElement.parentElement.remove();
        }
    }
}
const submitCreateTypeForm = () => {
    const createTypeForm = document.getElementById("createTypeForm");
    $.ajax({
        method: createTypeForm.method,
        url: createTypeForm.action,
        data: formSerialize(createTypeForm),
        success: function (res) {
            SuccessToast.fire({
                icon: 'success',
                title: "İşlem Başarılı."
            })
            window.location.href = res.redirect;
        },
        error: function (err) {
            ajaxErrorHandle(err);
        }
    });
}
const submitUpdateTypeForm = () => {
    const createTypeForm = document.getElementById("updateTypeForm");
    $.ajax({
        method: createTypeForm.method,
        url: createTypeForm.action,
        data: formSerialize(createTypeForm),
        success: function (res) {
            console.log(res);
            SuccessToast.fire({
                icon: 'success',
                title: "İşlem Başarılı."
            })
            window.location.href = res.redirect;
        },
        error: function (err) {
            console.log(err)
            ajaxErrorHandle(err);
        }
    });
}


const formSerialize = (form) => {
    const data = new FormData(form);
    return new URLSearchParams(data).toString();
}

const formDeserialize = (form, data) => {
    const entries = (new URLSearchParams(data)).entries();
    for (const [key, val] of entries) {
        const input = form.elements[key];
        switch (input.type) {
            case 'checkbox': input.checked = !!val; break;
            default: input.value = val; break;
        }
    }
}
