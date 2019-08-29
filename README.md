# magento2-category-list-with-thumbnail-widget

#Features
<ul>
<li>Add Category List Any Where</li>
<li>Automatic Pick Default Store Category as Parent</li>
<li>Category Image into List</li>
<li>Can Manage Image Size</li>
<li>Can Assign Custom Parent Category</li>
<li>Can list any category</li>
<li>*NEW* Use additional thumbnail as Preview image</li>
</ul>

<h2>Composer Installation Instructions</h2>
<pre>
  composer require bitpolar/categoryimgwidget
</pre>


<br/>

<h3> Enable Bitpolar/CategoryImgWidget Module</h3>
to Enable this module you need to follow these steps:

<ul>
<li>
<strong>Enable the Module</strong>
<pre>bin/magento module:enable Bitpolar_CategoryImgWidget</pre></li>
<li>
<strong>Run Upgrade Setup</strong>
<pre>bin/magento setup:upgrade</pre></li>
<li>
<strong>Re-Compile (in-case you have compilation enabled)</strong>
	<pre>bin/magento setup:di:compile</pre>
</li>
</ul>
