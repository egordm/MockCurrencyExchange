<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="buyandsell.css">
</head>
<body> 
	<div id="wrap">
		<div className="buy" id="form">
			<h3>Buy BTC</h3>
			<form action="" method="POST" className="form-inline"> <!-- add action="filename.php" -->
				<div>
					<label className="block">Price:<input type="text" name="price" className="money" placeholder="0.00"></label><br>
				</div>
				<div>
					<label className="block">Amount:<input type="text" name="amount" className="money"></label><br>
				</div>
				<div>
					<label>Total:</label> <label style="color: #ddd;">0.00000</label> <label style="color: #ddd;">USDT</label>
				</div>
				<br>
				<input type="submit" name="submit" value="Buy" className="submitpurchase">
			</form>
		</div>
		<div className="saleform">
			<div className="sell" id="form">
				<h3>Sell BTC</h3>

				<form action="" method="POST" className="form-inline"> <!-- add action="filename.php" -->
					<div>
						<label className="block">Price:<input type="text" name="price" className="money" placeholder="0.00"><div className="input-group mb-2 mr-sm-2"><div className="input-group-prepend"><div className="input-group-text">@</div></div></div></label><br>
					</div>
					<div>
						<label className="block">Amount:<input type="text" name="amount" className="money"></label><br>
					</div>
					<div>
						<label>Total:</label> <label style="color: #ddd;">0.00000</label> <label style="color: #ddd;">USDT</label>
					</div>
					<br>
					<input type="submit" name="submit" value="Sell" className="submitsale">
				</form>
			</div>
		</div>
	</div>
</body>
</html>