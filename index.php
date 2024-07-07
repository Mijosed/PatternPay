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
        <select id="currency" name="currency" required>
            <option value="USD">USD</option>
            <option value="EUR">EUR</option>
            <option value="GBP">GBP</option>
            <option value="JPY">JPY</option>
        </select>
        <br>
        <label for="description">Description :</label>
        <input type="text" id="description" name="description" required>
        <br>
        <button type="submit">Payer</button>
    </form>
</body>
</html>