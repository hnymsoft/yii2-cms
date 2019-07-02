<table class="layui-table">
    <thead>
        <tr>
            <th width="20%">选择器</th>
            <th width="25%">实例</th>
            <th width="55%">选取</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>*</td>
            <td>$("*")</td>
            <td>所有元素</td>
        </tr>
        <tr>
            <td>#<em>id</em></td>
            <td>$("#lastname")</td>
            <td>id="lastname" 的元素</td>
        </tr>
        <tr>
            <td>.<em>class</em></td>
            <td>$(".intro")</td>
            <td>class="intro" 的所有元素</td>
        </tr>
        <tr>
            <td>.<em>class,</em>.<em>class</em></td>
            <td>$(".intro,.demo")</td>
            <td>class 为 "intro" 或 "demo" 的所有元素</td>
        </tr>
        <tr>
            <td><em>element</em></td>
            <td>$("p")</td>
            <td>所有 &lt;p&gt; 元素</td>
        </tr>
        <tr>
            <td><em>el1</em>,<em>el2</em>,<em>el3</em></td>
            <td>$("h1,div,p")</td>
            <td>所有 &lt;h1&gt;、&lt;div&gt; 和 &lt;p&gt; 元素</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>:first</td>
            <td>$("p:first")</td>
            <td>第一个 &lt;p&gt; 元素</td>
        </tr>
        <tr>
            <td>:last</td>
            <td>$("p:last")</td>
            <td>最后一个 &lt;p&gt; 元素</td>
        </tr>
        <tr>
            <td>:even</td>
            <td>$("tr:even")</td>
            <td>所有偶数 &lt;tr&gt; 元素，索引值从 0 开始，第一个元素是偶数 (0)，第二个元素是奇数 (1)，以此类推。</td>
        </tr>
        <tr>
            <td>:odd</td>
            <td>$("tr:odd")</td>
            <td>所有奇数 &lt;tr&gt; 元素，索引值从 0 开始，第一个元素是偶数 (0)，第二个元素是奇数 (1)，以此类推。</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>:first-child</td>
            <td>$("p:first-child")</td>
            <td>属于其父元素的第一个子元素的所有 &lt;p&gt; 元素</td>
        </tr>
        <tr>
            <td>:first-of-type</td>
            <td>$("p:first-of-type")</td>
            <td>属于其父元素的第一个 &lt;p&gt; 元素的所有 &lt;p&gt; 元素</td>
        </tr>
        <tr>
            <td>:last-child</td>
            <td>$("p:last-child")</td>
            <td>属于其父元素的最后一个子元素的所有 &lt;p&gt; 元素</td>
        </tr>
        <tr>
            <td>:last-of-type</td>
            <td>$("p:last-of-type")</td>
            <td>属于其父元素的最后一个 &lt;p&gt; 元素的所有 &lt;p&gt; 元素</td>
        </tr>
        <tr>
            <td>:nth-child(<em>n</em>)</td>
            <td>$("p:nth-child(2)")</td>
            <td>属于其父元素的第二个子元素的所有 &lt;p&gt; 元素</td>
        </tr>
        <tr>
            <td>:nth-last-child(<em>n</em>)</td>
            <td>$("p:nth-last-child(2)")</td>
            <td>属于其父元素的第二个子元素的所有 &lt;p&gt; 元素，从最后一个子元素开始计数</td>
        </tr>
        <tr>
            <td>:nth-of-type(<em>n</em>)</td>
            <td>$("p:nth-of-type(2)")</td>
            <td>属于其父元素的第二个 &lt;p&gt; 元素的所有 &lt;p&gt; 元素</td>
        </tr>
        <tr>
            <td>:nth-last-of-type(<em>n</em>)</td>
            <td>$("p:nth-last-of-type(2)")</td>
            <td>属于其父元素的第二个 &lt;p&gt; 元素的所有 &lt;p&gt; 元素，从最后一个子元素开始计数</td>
        </tr>
        <tr>
            <td>:only-child</td>
            <td>$("p:only-child")</td>
            <td>属于其父元素的唯一子元素的所有 &lt;p&gt; 元素</td>
        </tr>
        <tr>
            <td>:only-of-type</td>
            <td>$("p:only-of-type")</td>
            <td>属于其父元素的特定类型的唯一子元素的所有 &lt;p&gt; 元素</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>parent &gt; child</td>
            <td>$("div &gt; p")</td>
            <td>&lt;div&gt; 元素的直接子元素的所有 &lt;p&gt; 元素</td>
        </tr>
        <tr>
            <td>parent descendant</td>
            <td>$("div p")</td>
            <td>&lt;div&gt; 元素的后代的所有 &lt;p&gt; 元素</td>
        </tr>
        <tr>
            <td>element + next</td>
            <td>$("div + p")</td>
            <td>每个 &lt;div&gt; 元素相邻的下一个 &lt;p&gt; 元素</td>
        </tr>
        <tr>
            <td>element ~ siblings</td>
            <td>$("div ~ p")</td>
            <td>&lt;div&gt; 元素同级的所有 &lt;p&gt; 元素</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>:eq(<em>index</em>)</td>
            <td>$("ul li:eq(3)")</td>
            <td>列表中的第四个元素（index 值从 0 开始）</td>
        </tr>
        <tr>
            <td>:gt(<em>no</em>)</td>
            <td>$("ul li:gt(3)")</td>
            <td>列举 index 大于 3 的元素</td>
        </tr>
        <tr>
            <td>:lt(<em>no</em>)</td>
            <td>$("ul li:lt(3)")</td>
            <td>列举 index 小于 3 的元素</td>
        </tr>
        <tr>
            <td>:not(<em>selector</em>)</td>
            <td>$("input:not(:empty)")</td>
            <td>所有不为空的输入元素</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>:header</td>
            <td>$(":header")</td>
            <td>所有标题元素 &lt;h1&gt;, &lt;h2&gt; ...</td>
        </tr>
        <tr>
            <td>:animated</td>
            <td>$(":animated")</td>
            <td>所有动画元素</td>
        </tr>
        <tr>
            <td>:focus</td>
            <td>$(":focus")</td>
            <td>当前具有焦点的元素</td>
        </tr>
        <tr>
            <td>:contains(<em>text</em>)</td>
            <td>$(":contains('Hello')")</td>
            <td>所有包含文本 "Hello" 的元素</td>
        </tr>
        <tr>
            <td>:has(<em>selector</em>)</td>
            <td>$("div:has(p)")</td>
            <td>所有包含有 &lt;p&gt; 元素在其内的 &lt;div&gt; 元素</td>
        </tr>
        <tr>
            <td>:empty</td>
            <td>$(":empty")</td>
            <td>所有空元素</td>
        </tr>
        <tr>
            <td>:parent</td>
            <td>$(":parent")</td>
            <td>匹配所有含有子元素或者文本的父元素。</td>
        </tr>
        <tr>
            <td>:hidden</td>
            <td>$("p:hidden")</td>
            <td>所有隐藏的 &lt;p&gt; 元素</td>
        </tr>
        <tr>
            <td>:visible</td>
            <td>$("table:visible")</td>
            <td>所有可见的表格</td>
        </tr>
        <tr>
            <td>:root</td>
            <td>$(":root")</td>
            <td>文档的根元素</td>
        </tr>
        <tr>
            <td>:lang(<em>language</em>)</td>
            <td>$("p:lang(de)")</td>

            <td>所有 lang 属性值为  "de" 的 &lt;p&gt; 元素</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>[<em>attribute</em>]</td>

            <td>$("[href]")</td>
            <td>所有带有 href 属性的元素</td>
        </tr>
        <tr>
            <td>[<em>attribute</em>=<em>value</em>]</td>
            <td>$("[href='default.htm']")</td>

            <td>所有带有 href 属性且值等于 "default.htm" 的元素</td>
        </tr>
        <tr>
            <td>[<em>attribute</em>!=<em>value</em>]</td>
            <td>$("[href!='default.htm']")</td>
            <td>所有带有 href 属性且值不等于 "default.htm" 的元素</td>

        </tr>
        <tr>
            <td>[<em>attribute</em>$=<em>value</em>]</td>
            <td>$("[href$='.jpg']")</td>
            <td>所有带有 href 属性且值以 ".jpg" 结尾的元素</td>
        </tr>
        <tr>

            <td>[<i>attribute</i>|=<i>value</i>]</td>
            <td>$("[title|='Tomorrow']")</td>
            <td>所有带有 title 属性且值等于 'Tomorrow' 或者以 'Tomorrow' 后跟连接符作为开头的字符串</td>
        </tr>
        <tr>
            <td>[<i>attribute</i>^=<i>value</i>]</td>

            <td>$("[title^='Tom']")</td>
            <td>所有带有 title 属性且值以 "Tom" 开头的元素</td>
        </tr>
        <tr>
            <td>[<i>attribute</i>~=<i>value</i>]</td>
            <td>$("[title~='hello']")</td>

            <td>所有带有 title 属性且值包含单词 "hello" 的元素</td>
        </tr>
        <tr>
            <td>[<i>attribute*</i>=<i>value</i>]</td>
            <td>$("[title*='hello']")</td>
            <td>所有带有 title 属性且值包含字符串 "hello" 的元素</td>

        </tr>
        <tr>
            <td>[<i>name</i>=<i>value</i>][<i>name2</i>=<i>value2</i>]</td>
            <td>$( "input[id][name$='man']" )</td>
            <td>带有 id 属性，并且 name 属性以 man 结尾的输入框</td>

        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>:input</td>
            <td>$(":input")</td>
            <td>所有 input 元素</td>
        </tr>
        <tr>

            <td>:text</td>
            <td>$(":text")</td>
            <td>所有带有 type="text" 的 input 元素</td>
        </tr>
        <tr>
            <td>:password</td>
            <td>$(":password")</td>

            <td>所有带有 type="password" 的 input 元素</td>
        </tr>
        <tr>
            <td>:radio</td>
            <td>$(":radio")</td>
            <td>所有带有 type="radio" 的 input 元素</td>
        </tr>
        <tr>
            <td>:checkbox</td>

            <td>$(":checkbox")</td>
            <td>所有带有 type="checkbox" 的 input 元素</td>
        </tr>
        <tr>
            <td>:submit</td>
            <td>$(":submit")</td>
            <td>所有带有 type="submit" 的 input 元素</td>

        </tr>
        <tr>
            <td>:reset</td>
            <td>$(":reset")</td>
            <td>所有带有 type="reset" 的 input 元素</td>
        </tr>
        <tr>
            <td>:button</td>
            <td>$(":button")</td>

            <td>所有带有 type="button" 的 input 元素</td>
        </tr>
        <tr>
            <td>:image</td>
            <td>$(":image")</td>
            <td>所有带有 type="image" 的 input 元素</td>
        </tr>
        <tr>
            <td>:file</td>

            <td>$(":file")</td>
            <td>所有带有 type="file" 的 input 元素</td>
        </tr>
        <tr>
            <td>:enabled</td>
            <td>$(":enabled")</td>
            <td>所有启用的元素</td>

        </tr>
        <tr>
            <td>:disabled</td>
            <td>$(":disabled")</td>
            <td>所有禁用的元素</td>
        </tr>
        <tr>
            <td>:selected</td>
            <td>$(":selected")</td>

            <td>所有选定的下拉列表元素</td>
        </tr>
        <tr>
            <td>:checked</td>
            <td>$(":checked")</td>
            <td>所有选中的复选框选项</td>
        </tr>
        <tr>
            <td>.selector</td>
            <td>$(selector).selector</td>
            <td><span class="deprecated">在jQuery 1.7中已经不被赞成使用。</span>返回传给jQuery()的原始选择器</td>
        </tr>
        <tr>
            <td>:target</td>
            <td>$( "p:target" )</td>
            <td>选择器将选中ID和URI中一个格式化的标识符相匹配的&lt;p&gt;元素</td>
        </tr>
    </tbody>
</table>