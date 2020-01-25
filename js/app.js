function getUsers() {
    const apiUrl = "http://localhost";
    const $list = $('.users-list');

    $.ajax({
            url: apiUrl + '/admin/users',
            dataType: 'json'
        })
        .done((res) => {
            $list.empty();

            res.forEach(el => {
                $list.append(`<tr>
                        <td>${el.id_user}</td>
                        <td>${el.email}</td>
                        <td>${el.name}</td>
                        <td>${el.surname}</td>
                        </tr>`);
            });
        });
}