<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:template match="container[@module = 'index']">
		<xsl:call-template name="index-item"/>
	</xsl:template>
	<xsl:template name="index-item">
										<div id="left">
									<div class="wrapper2">
										<div class="extra-indent">
											<div class="module_search">
												<div class="boxIndent">
													<div class="wrapper">
														<form action="#" method="get">
															<div class="search_search">
																<input name="keyword" id="mod_virtuemart_search" maxlength="80" class="inputbox" type="text" size="80" value="поиск..." onblur="if(this.value=='') this.value='поиск...';" onfocus="if(this.value=='поиск...') this.value='';"/>
																<input type="submit" value="search" class="button" onclick="this.form.keyword.focus();"/>
															</div>
														</form>
													</div>
												</div>
											</div>
											
											<div class="module-category">
												<div class="boxIndent">
													<h3>
														<span>
															<span>Направления</span>
														</span>
													</h3>
													<div class="wrapper">
														<ul id="dropdown" class="list">
															<li class="level0 parent">
																<a class="screenshot" href="#">Финляндия</a>
																<span class="VmArrowdown idCatSubcat close"/>
																<ul class="level1 child" style="display: none;">
																	<li class="level1">
																		<a class="screenshot" href="#">Лаппеенранта</a>
																	</li>
																	<li class="level1">
																		<a class="screenshot" href="#">Иматра</a>
																	</li>
																	<li class="level1">
																		<a class="screenshot" href="#">Хельсинки</a>
																	</li>
																</ul>
															</li>
															<li class="level0 parent">
																<a class="screenshot" href="#">Эстония</a>
																<span class="VmArrowdown idCatSubcat close"/>
																<ul class="level1 child" style="display: none;">
																	<li class="level1">
																		<a class="screenshot" href="#">Таллин</a>
																	</li>
																	<li class="level1">
																		<a class="screenshot" href="#">Тарту</a>
																	</li>
																</ul>
															</li>
															<li class="level0 parent">
																<a class="screenshot" href="#">Латвия</a>
																<span class="VmArrowdown idCatSubcat close"/>
																<ul class="level1 child" style="display: none;">
																	<li class="level1">
																		<a class="screenshot" href="#">Рига</a>
																	</li>
																	<li class="level1">
																		<a class="screenshot" href="#">Юрмала</a>
																	</li>
																</ul>
															</li>
														</ul>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="container">
									<div class="module_new">
										<h3>
											<span>
												<span>Популярные направления</span>
											</span>
										</h3>
										<div class="boxIndent">
											<div class="wrapper">
												<div class="vmgroup_new">
													<ul id="vmproduct" class="vmproduct_new">
														<li class="item">
															<div class="product-box spacer" style="height: 350px;">
																<div class="browseImage">
																	<div class="sale"/>
																	<a href="#" class="img2">
																		<img src="./images/menu_fin.jpg" alt="" class="browseProductImage featuredProductImage" border="0"/>
																	</a>
																	<div class="Price">
Стоимость:<span class="sales">800 р.</span>
																	</div>
																</div>
																<div class="fleft">
																	<div class="Title">
																		<span class="count">1.</span>
																		<a href="#" title="Иматра">Иматра</a>
																	</div>
																	<div class="description">
																		<p>Путешествие в финляндию... </p>
																	</div>
																	<div class="wrapper">
																		<div class="addtocart-area2">
																			<form method="post" class="product" action="№">
																				<div class="addtocart-bar2">
																					<div class="clear"/>
																					<span class="addtocart-button">
																						<input type="submit" name="" class="addtocart-button cart-click" value="Записаться" title="Записаться"/>
																					</span>
																					<div class="clear"/>
																				</div>
																			</form>
																			<div class="clear"/>
																		</div>
																		<div class="Details">
																			<a href="#">Подробнее</a>
																		</div>
																	</div>
																</div>
															</div>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="clear"/>
	</xsl:template>
</xsl:stylesheet>
