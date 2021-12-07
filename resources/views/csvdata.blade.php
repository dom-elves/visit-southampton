<body>

  <div>

    <form method="post" action="/upload-csv" enctype="multipart/form-data">

      @csrf
      <input type="file" name="file">

      <button style="width: 100px; height: 100px;" type="submit"> upload csv data</button>

    </form>

  </div>

</body>
