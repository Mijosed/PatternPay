<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interface de Transaction</title>
</head>
<body>
    <h1>Exemple d'utilisation de la librairie avec Stripe</h1>
    <form action="transaction.php" method="post">
        <label for="amount">Montant :</label>
        <input type="number" id="amount" name="amount" required>
        <br>
        <label for="currency">Devise :</label>
        <input type="text" id="currency" name="currency" value="USD" required readonly>
        <br>
        <label for="description">Description :</label>
        <input type="text" id="description" name="description" required>
        <br>
        <button type="submit">Payer</button>
    </form>
</body>
</html>
