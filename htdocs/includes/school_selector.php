<?php

function bekal_school_selector() {

    require __DIR__ . '/config.php';

    /*
    |--------------------------------------------------------------------------
    | Ambil Provinsi
    |--------------------------------------------------------------------------
    */

    $daerahs = [];

    $result = $conn->query(
        "SELECT
            id,
            name
         FROM provinces
         ORDER BY name"
    );

    while($row = $result->fetch_assoc()){

        $daerahs[] = [
            'id'   => $row['id'],
            'name' => $row['name']
        ];

    }

    /*
    |--------------------------------------------------------------------------
    | Ambil Kota
    |--------------------------------------------------------------------------
    */

    $kotas = [];

    $result = $conn->query(
        "SELECT
            id,
            province_id,
            name
         FROM cities
         ORDER BY name"
    );

    while($row = $result->fetch_assoc()){

        $kotas[] = [
            'id' => $row['id'],
            'province_id' => $row['province_id'],
            'city_name' => $row['name']
        ];

    }

    /*
    |--------------------------------------------------------------------------
    | Ambil Sekolah
    |--------------------------------------------------------------------------
    */

    $schools = [];

    $result = $conn->query(
        "SELECT
            id,
            city_id,
            name
         FROM schools
         ORDER BY name"
    );

    while($row = $result->fetch_assoc()){

        $schools[] = [
            'id' => $row['id'],
            'city_id' => $row['city_id'],
            'school_name' => $row['name']
        ];

    }

    ob_start();
?>

<select id="bekal-daerah" required>
    <option value="">Pilih Provinsi</option>

    <?php foreach($daerahs as $daerah): ?>

    <option value="<?php echo $daerah['id']; ?>">
        <?php echo htmlspecialchars($daerah['name']); ?>
    </option>

    <?php endforeach; ?>

</select>

<div id="kota-wrapper" style="display:none;">

<select id="bekal-kota" required>

<option value="">Pilih Kota / Kabupaten</option>

</select>

</div>

<div id="sekolah-wrapper" style="display:none;">

<select
id="bekal-sekolah"
name="school"
required>

<option value="">Pilih Sekolah</option>

</select>

</div>

<script>

document.addEventListener('DOMContentLoaded', function(){

    const kotaData =
    <?php echo json_encode($kotas); ?>;

    const sekolahData =
    <?php echo json_encode($schools); ?>;

    const daerahSelect =
    document.getElementById('bekal-daerah');

    const kotaSelect =
    document.getElementById('bekal-kota');

    const sekolahSelect =
    document.getElementById('bekal-sekolah');

    const kotaWrapper =
    document.getElementById('kota-wrapper');

    const sekolahWrapper =
    document.getElementById('sekolah-wrapper');

    daerahSelect.addEventListener('change', function(){

        kotaSelect.innerHTML =
        '<option value="">Pilih Kota / Kabupaten</option>';

        sekolahSelect.innerHTML =
        '<option value="">Pilih Sekolah</option>';

        sekolahWrapper.style.display = 'none';

        if(!this.value){

            kotaWrapper.style.display = 'none';
            return;

        }

        kotaWrapper.style.display = 'block';

        kotaData.forEach(function(item){

            if(item.province_id == daerahSelect.value){

                kotaSelect.innerHTML +=
                '<option value="' +
                item.id +
                '">' +
                item.city_name +
                '</option>';

            }

        });

    });

    kotaSelect.addEventListener('change', function(){

        sekolahSelect.innerHTML =
        '<option value="">Pilih Sekolah</option>';

        if(!this.value){

            sekolahWrapper.style.display = 'none';
            return;

        }

        sekolahWrapper.style.display = 'block';

        sekolahData.forEach(function(item){

            if(item.city_id == kotaSelect.value){

                sekolahSelect.innerHTML +=
                '<option value="' +
                item.school_name +
                '">' +
                item.school_name +
                '</option>';

            }

        });

    });

});

</script>

<?php

    return ob_get_clean();

}

?>