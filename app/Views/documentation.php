
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        textarea {
            width: 100%;
            height: 300px;
            margin-bottom: 20px;
            font-family: monospace;
        }
        button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>

    <div>

    <?php if (isset($error)) {
        var_dump($error);
    }
        ?>
        <h1>Project Documentation</h1>
        <form action="/documentation" method="POST">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" placeholder="Enter the title of your documentation" required>
            <input type="text" name="content" placeholder="Write your documentation in Markdown format..."></input>
            <button type="submit">Save Documentation</button>
        </form>
    </div>
