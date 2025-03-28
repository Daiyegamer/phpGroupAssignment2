<?php
include('admin/reusable/conn.php');

// Delete movie if delete request is received
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $deleteQuery = "DELETE FROM movies WHERE id = $id";
    if (mysqli_query($connect, $deleteQuery)) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Error deleting movie: " . mysqli_error($connect);
    }
}

// Fetch all movies
$query = "SELECT * FROM movies";
$movies = mysqli_query($connect, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <?php include 'admin/reusable/nav.php'; ?>

    <div class="container">
        <h2>Movie List</h2>
        <a href="addmovie.php" class="btn btn-primary">Add Movie</a>
        <table border="1" class="movie-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Poster</th>
                    <th>Title</th>
                    <th>Genre</th>
                    <th>Release Year</th>
                    <th>Network</th>
                    <th>Cast</th>
                    <th>Rating</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($movie = mysqli_fetch_assoc($movies)) : ?>
                    <tr>
                        <td><?= $movie['id'] ?></td>
                        <td><img src="<?= $movie['poster_url'] ?>" alt="Poster" width="50"></td>
                        <td><?= htmlspecialchars($movie['title']) ?></td>
                        <td><?= htmlspecialchars($movie['genre']) ?></td>
                        <td><?= $movie['release_year'] ?></td>
                        <td><?= htmlspecialchars($movie['network']) ?></td>
                        <td><?= htmlspecialchars($movie['cast']) ?></td>
                        <td><?= $movie['rating'] ?></td>
                        <td>
                            <a href="editmovie.php?id=<?= $movie['id'] ?>" class="btn btn-warning">Edit</a>
                            <a href="admin.php?delete=<?= $movie['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this movie?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
