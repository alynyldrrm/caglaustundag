const fieldTypes = [{
    label: "Yazı",
    type: "input|text"
},
{
    label: "Sayı",
    type: "input|number"
},
{
    label: "Email",
    type: "input|email"
},
{
    label: "Şifre",
    type: "input|password"
},
{
    label: "Url",
    type: "input|url"
},
{
    label: "Tarih",
    type: "input|date"
},
{
    label: "Tarih Saat",
    type: "input|datetime"
},
{
    label: "Dosya Resim",
    type: "input|file"
},
{
    label: "Yazı Alanı",
    type: "textarea|textarea"
},
{
    label: "Seçim Alanı",
    type: "select|select"
},
{
    label: "Çoğul Seçim",
    type: "input|checkbox"
},
{
    label: "Tekil Seçim",
    type: "input|radio"
},
{
    label: "Sıfırla",
    type: "button|reset"
},
{
    label: "Kaydet Butonu",
    type: "button|submit"
},

];
const fieldList = document.getElementById("form-fields-container");



const addFormFieldRow = () => {
    let row = `
        <tr data-id="">
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
const removeFieldInDom = (e) => {
    if (confirm("Silmek istediğinize emin misiniz?")) {
        e.parentElement.parentElement.remove();
    }
}
