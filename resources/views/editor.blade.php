
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    <link
            href="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.snow.css"
            rel="stylesheet"
    />
    <style>
        /* Editörün genel kapsayıcı alanı */
        #editor {
            height: 400px;
            background-color: #f9f9f9;  /* Açık gri arka plan */
            border: 1px solid #ccc;      /* Kenarlık */
            border-radius: 8px;          /* Kenar yumuşatma */
            padding: 15px;               /* İç boşluk */
            font-family: 'Arial', sans-serif;  /* Yazı tipi */
            font-size: 16px;             /* Yazı boyutu */
        }

        /* Quill araç çubuğu görünümü */
        .ql-toolbar {
            background-color: #4CAF50;   /* Araç çubuğu için yeşil arka plan */
            border: none;                /* Kenarlığı kaldır */
            border-radius: 8px 8px 0 0;  /* Üst kenarlarda köşe yuvarlama */
            color: white;                /* Araç çubuğu simgeleri için beyaz renk */
        }

        /* Araç çubuğundaki butonların görünümü */
        .ql-toolbar .ql-formats button {
            background-color: transparent;  /* Şeffaf arka plan */
            color: white;                   /* Buton rengi beyaz */
            border: none;                   /* Kenarlığı kaldır */
            padding: 8px;                   /* İç boşluk */
            transition: background-color 0.3s ease;
        }

        /* Araç çubuğundaki butonların üzerine gelince */
        .ql-toolbar .ql-formats button:hover {
            background-color: #388E3C;      /* Üzerine gelince koyu yeşil arka plan */
        }

        /* Aktif butonlar için stil */
        .ql-toolbar .ql-formats .ql-active {
            background-color: #388E3C;      /* Aktif butonlar koyu yeşil */
            color: white;
        }

        /* Editör içeriğindeki metin */
        .ql-editor {
            background-color: white;        /* Metin alanı arka planı beyaz */
            color: #333;                    /* Metin rengi koyu gri */
            padding: 15px;                  /* İç boşluk */
            font-size: 16px;                /* Yazı boyutu */
            line-height: 1.6;               /* Satır yüksekliği */
            min-height: 200px;              /* Minimum yükseklik */
        }

        /* Editördeki linklerin görünümü */
        .ql-editor a {
            color: #4CAF50;                 /* Linkler için yeşil renk */
            text-decoration: underline;     /* Altı çizili */
        }

        /* Resimler için stil */
        .ql-editor img {
            max-width: 100%;                /* Resimlerin taşmasını önleme */
            border-radius: 8px;             /* Kenar yumuşatma */
        }

        /* Liste elemanları için özelleştirme */
        .ql-editor ul, .ql-editor ol {
            padding-left: 20px;             /* Liste öğelerinin sol boşluğu */
        }
    </style>
</head>
<body>

<!-- Create the editor container -->
<div id="aboutEditor" class="container">
   {!! $about !!}
</div>

<!-- Include the Quill library -->
<script src="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.js"></script>

<!-- Initialize Quill editor -->
<script>
    const quill = new Quill('#aboutEditor', {
        theme: 'snow', // Tema: "snow" veya "bubble"
        modules: {
            toolbar: [
                [{ 'font': [] }],  // Yazı tipi seçimi
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'script': 'sub'}, { 'script': 'super' }],
                ['blockquote', 'code-block'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'indent': '-1'}, { 'indent': '+1' }],
                [{ 'direction': 'rtl' }],
                [{ 'align': [] }],
                ['link', 'image', 'video'],
                ['clean']
            ],
            clipboard: {
                matchVisual: false,
            },
            history: {
                delay: 2000,
                maxStack: 500,
                userOnly: true
            }
        },
        placeholder: 'Buraya yazın...',
        readOnly: false,
        bounds: '#aboutEditor',
        scrollingContainer: null
    });
</script>
</body>
</html>