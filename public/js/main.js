window.onload = () => {
  init();
};

let init = () => {
  productsOnClick();
  }

let productsOnClick = () => {
  let products = document.querySelectorAll('.item-container .card');

  products.forEach( (product) => {
    const id = product.dataset.productId;
    product.addEventListener('click', () => { loadModalInfo(id); });
    } );

  }

let loadModalInfo = (id) => {
  document.getElementById('pModalTitle').textContent = "Producto #" + id;
  document.getElementById('pModalPrice').textContent = id * 100;
  document.getElementById('pModalDescription').textContent = "Descripción para el producto #" + id;
  document.getElementById('pModalImage').src = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAU8AAAC2CAIAAADWRZjAAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyZpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNi1jMTM4IDc5LjE1OTgyNCwgMjAxNi8wOS8xNC0wMTowOTowMSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wTU09Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9tbS8iIHhtbG5zOnN0UmVmPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvc1R5cGUvUmVzb3VyY2VSZWYjIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RDJFNjgxREZGRjgzMTFFNkE4NUZEQjA1OUJEMTUzRTUiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6RDJFNjgxREVGRjgzMTFFNkE4NUZEQjA1OUJEMTUzRTUiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIDIwMTcgKFdpbmRvd3MpIj4gPHhtcE1NOkRlcml2ZWRGcm9tIHN0UmVmOmluc3RhbmNlSUQ9InhtcC5paWQ6OTQwNzEyMzVGRjdEMTFFNjg4QkJGREVCOTBGOUUwQjciIHN0UmVmOmRvY3VtZW50SUQ9InhtcC5kaWQ6OTQwNzEyMzZGRjdEMTFFNjg4QkJGREVCOTBGOUUwQjciLz4gPC9yZGY6RGVzY3JpcHRpb24+IDwvcmRmOlJERj4gPC94OnhtcG1ldGE+IDw/eHBhY2tldCBlbmQ9InIiPz6q9Q3NAAAT+klEQVR42uydCXQU1ZrHv1tVnYTsZIGAJCwhhCSERAir4opBIgIyo7yn4owPRGdG5/hUHI4Z9Y0+PMe3zMNhznhUlPfcEGd4KiCyurBEQaISlqAEgi8sCYGEbGTpqrpT1d2BdHX1kpB0d8L/d1pMOtW3qm/d373fvXXrFqPlrQQAuAoQkAUAwHYAAGwHAMB2AABsBwDAdgAAbAcAwHYAAGwHAMB2AGA7AAC2AwBgOwAAtgMAYDsAIKBIyIKrgnih3xD2fJIwoT9lRlNsCAsT9bdrWnlVCyuuVT+voVWnOJ1SqZUjt/oqDKtZ9GVi2C+yxN+kC+nRPm1uVemdn9WFpZyOKaQi+2A76BXEsT9NEh9NEyTWlU//WE+jixU6COdhOwhmLLRwsvRqrmC54jGZfTV8whcKnYTxsB0EIQOEkplSdmy3pad14h/Yp777tYxGvg+AMfk+RJrYck93qm5rDeidPOGjuywUypDBsB0EB2NFtUAMFXsk7blD2Nd3S9QPwsN2EHAyBX6z2KMuTo5nu+ZJaOFhOwgoKYIy3R/zJq5LYGvukAi+w3YQGCJYxQxR8JeB9ySz2ZMwIwu2g0Dw2s3ikHC/trZrJwo0AMUGtgM/M0JcnOrvMygx2n6LiLyH7cCvFE0JzOm7ZSCjVAgP24HfSBWnJARsxGznJJQc2A78xftjAzk4fn0io0EoPLAd+IEINj85wOduSQYKD2wHfmAYEwJ93fvhYSg8sB30PH9MCfyJS40iisVUG9gOepjbBwbHiUuC7bAd9CgijY4OigOZ1x/lB7aDHiUy8J12O3nRaNthO+hRguZGtAEhWLIStoOetT1YDiQBN8DCdtCztAXLgZxvQ9sO20HP2h4sjtW24WTAdtCjNAaL7QcacTJgO+hRrHSsISgO5C+1WIkWtoMe5qtzwaFZNU4FbAc9zHMVgQ/mq1o4VaNth+2ghzl1IvCavfszJwzJw3bQ49TybVUBVu2pI2jYYTvwC7cdDKRsZQ1EP8N22A78Q6kSwJH5tH0KwnjYDvyFQiP3KoGpZ+qIDik4A7Ad+JFDytbKALSwmV8pBNlhO/ArnPK3yo2yX/f521JO5XAdtgP/U8OjvvCf7ntr+LNfWJHrsB0EiMPqvfv8MTx+opFP+kQmyA7bQQBZvVteeqBnhT/TzId/rFA9BuJhOwg0L38uz9nTU8IfrqPBa2Q6jwvssB0EB+u+kdlGpdvvOV9VrmZ9YKU6tOq9HjyLu29xVImrUt+/Vfxldyw4f76VJxSpVIIReLTtIDip5/d+pDfye853vTVulunJEjXhbRmq9yUYLW9FLvRZRogrs9iCYUKIz7V6aR0tPaKuO6BQE0J32A56HWGMhgpLh7BZSWxsDIuyGP9e1kB7a9T/OcV3V3CqxFAcbAd9hghGmvAhTJ/9auV0kZOMTLkqwCjd1YcjREegftWBUToAYDsAAJE8CApCqOhuS6B2/tgRtbgYF+dgO/APjE1JCNhj2KZEsmKcAkTyAADYDgCA7QAA2A4AgO0AANgOAIDtAMB2AABsBwDAdgAAbAcAwHYAAGwHAMB2AABsBwDAdgAAbAcAtgMAYDsAALYDAGA7AAC2AwBgOwAAtgMAYDsAALYDAGA7ALAdAADbAQCwHQAA2wEAsB0AANsBALAdAADbAQCwHQAA2wGA7QAA2A4A6P1IyILeShtnq6yB2ztOAGwHfoMT1XNkA0AkDwCA7QDAdgAAbAcAwHYAAGwHAMB2AABsBwDAdgAAbAcAwHYAgDOYJ99JEgWKZk7vKJxOqE7vpIrGT1k5/U31lGwco/4uNW+lSk3eZsKPFYc77638NKcqtdPfS/tSKcJTiSwziuJDWJPCz7RQUR2treRUoZDVffEZKnYlGzt+tYECRTpnaY1KtW6+eASjJJeMOqagYML27ufRTGFFrlNpO1pPo1Y53RHGZ5kIwNbKdNKNhBYqm2tJjXL5yAZv5ThZ4Dcb97X+NJ/9v52xfYS4Ybxwx2Bm2Ln23xO2n5pl8U9HeeG3somB4cz0y3ql41dbliM+k+G094omIWW1bF7TJQmue2SvwHZE8sHE97dI5MaLf54quaruC6/mmJy+OzVvB/h2WsPZO3MkfqfooroT/STSbLQusCyc5vYrdC/JEWzzLD/tC7aD7ie3PxXkmZXfgcKKnC6dhSi2aIT5B3+T44Mo8ULZLyz3D/N11xKjleOE12b6KRjMT2JLbkTgCdt7LWsniNSfGeLlHbeKAutKagtyRMnNB58exSjMY6KRrHyu2NmAolGmh79V/ZZdv8sWKBPlE7b3TsJEWnuLU3s1PFecltgl1yX6YxbzEHtfl+3pzG6YKQ2LNP94m0onGnmty9I0KqeoTUpXxv+ugGYtu5JQRLsNBEt+Zd4QprdXh1V7KP7DlK72TUeLiR5b779kiyOLFTJ1M1Mw7agX11Le1wqVKyTbfo9glCocGidmxui/Tdyt+Dj0rY9HVnu7lGD1adUdrX48WiClrbZSM1bpQdveC6mcJlI/Xba3bhajLV1MZM+1Xk6cHqWnmlclxXkmVfyqcjXv/TY62q66RhOnEiXr7bb536qFB9XiYp/HvbW4oJV7efkcIoyMorUFEjEUHNjeCxkYxpZNkyhNfHB4VzM/RZgY51T8m2R687hRoA25ZukPFMb1N7534AL96jP5sudOETx9WCS/tF0ObED00PUIQhHJ906eyWAPjeh6Pfu6yxj+K0e51vwudE5TD9cHCoaedsY1Jq3k2L0ydd/qtW9NFs60uO2hFO7vSuf/9XHCG1Ui/YTr6rA9+KP3Zp7Uz0mzxFCnX09e5EPCfYtWo9lCl6Cg8IBCZ9S9NdzQ5r+YIz67xUmtu+ONn5W1HvFxp17xN/db0iLd7n/VCf7UJk9NveeYpfAYo6qu5GH9dDH6PHrviOSDnkG7lQaPjWfyl742dw/mGK/YfX2Oa6prP+QfMCby1ChGzrVMSphRmNMXbR3pDsRZWFyo21espcez68uzfI+L2FEWOnSnRKEQHrYHOfUUvdttFLqkRPUyi75DKPayy4W3qQcdn60rVZucG90wkW7M9nKKg9CeeitNXi+fbzUeWmYMnboOM+xge/CzX/nklIlZP9bTH3b5PAaWIRq6AHrIUNpej7RyrQNv+MSfNds7nOSTLcbKYpDW+Adhf66OJ2xWXfNrcDhG59Fv7w3M3SLX32+Jco6ER2+3jZCF+pTCHpdh9iaZr5xx+SSOcpkep8+iGXl5fGt9jfq88wT0EC3J4aJ+7a2d35epw9rj/2tjaeagzgl2xzfKxgb3EcNZn4OJcmXmN7RpMhpz2N4r43muxfP8JrErMTyZXHjTSOrHFo7wYuOnucId7bYXm8UXRROFqccVavf9jZ0dYo1MgQ/qXCHZWM7pbPdMudu8R3lrIPvVcESgiOR7eTzfuRie6M3cLp6sgkG2S3F2KtWSC8YNpiSwF2+1BGdZWLhJPnAB5Qa299p43j4+74jhfSSaPXgFTdxLuZcDipx9JlXMv2ewzXdbaKjgNGstlq1M7fxOtb5DtLdXiM+ptdHY9dZ6KwoOIvleG88XJrJOxPBEi3PFKxmeeiKNPbOT0UVbWHFY3TqG35ZkTC8/ifG5Uk0rL6kjq0qpkTQisiv75HdqNYuXzvaIHUr59z5PlanhMVsVXoAOPGzvnfH8sk4VXQu9lGkU772f1fuLzOuLmMHswo1OOwgVaUa2oHWDbTpS/mdyxXzJdD5PXCi7aUDw5dhR5YFi9vZ4hKKI5HsjnZoDmiHGhxrNvP8HVR8MM3vVlSgVLss8vdbxUlw9T/6rUtbQ6aPW+iCLjgTmCv07u+UPKzC1Brb3dfblGiOBw3VEP7vvCKj02CGjGEMjGKV1SOe8mrba+vqxTvQm3jiuRr9r7Xitzq9wmr9RPlqP4gDb+zApwniXu9b+8aDieRLcJwcU2WWDzYZR/Wb+8AaZ/VVeVa5a3Vtf20a/LeVsjbx4vawFBYHMihY+aqPcLKNMdBFGy1uRC50gllEUM8bkp51dSXapQ88a56Kb1LrXuHzqHNdXcYhhxjWtNapUavN2qIMEk2GZk6p5NRHGtAOYncjGRbEBobxBpqpWWlfHy6q4vhq0u+Zcsu2lC9Ryamw/jjimr5zREa1Ierhi77p9hYqCCdsBAIjkAbj6wBU4EDj6M4qztTf6PfZYqQK2g75KP1Y+z7H0bdpOpQwZgkge9E0YvX+7aFf91WNq2Xdo2NG2g75KglBUQ0U1ahun17/BJTW/1bEYkwcAbTvoyMo7vefV25V8x7e2oDRLWOltVdlFm9rvgYsXVk7VN150XKVDHi8dDxJW5nlLdr/tnvkBwspJ+pYHG2n5F24azxB6fYakbdQg06+1g+H6TJ6VtgVtFx3mxmdFRLA7soV/ShZGRLCLKpU18LdOqVuOqIb5NjdMEB+w3W+zaLviuAnHua8+MkNYNkwYHcXiQvjpFvqqmj99zLYvl+9tT0p7e/EOhepMJgncM1XKj7d95fWIDmB7t7LQpzWh1R22/z2aIHjdfpG+mqStEIc7Ev+hnv7b83MVwpn3ZO2TYc+p+QPFZNsslOUHBao2SzZDtC90/aLmtt2mSMeRLDuplHfcMkU4W+C0SNb4/mx+iqhOFp87rC7bIV+a6qP5aU9h0VfGrviEPHHbxI4PzGBDwmliHFuSTvsviLmfy4ZJMpeSGhvDJn9gdV3u/r7BbLZtwexFKJ2wvXvpOENb89T+yMQWhSqaLr9f3mz81OE6qnP3FCTe9VmoJy/yiotu/tZqc9I2Vf7jifrPj48Rln9hYnvRGEfF8VyJx0GyfuxcgeO2nL01/LNKirXwWUmClgNaPvwmU1h2SLAveuuBP9wuPZnu2F11K99wmte06RpPT2Jaujmx1DpXCt2kmE7CnxTPfjddenoTGnDY7i9GreowVTWU8Uf0RmpLJZ/zf55WWsjaLvfEvM5/OcDXeRvc+qREseYJFoGeTWfLd5KxbUwSpiToAm+t5F4e5zBKsKv+r/vVFV86Unmc9NXsiqeJTx9RvKp+3QTRrnqbSlm7lbL9l1fFohi25lbpnmQWIlDzDLHfeZVqTCrBJenCK1Xiqe8xdH9F4Apc36WJv2Z7XFSc5uoolwdOtDfs+fu9KPRIjCOAX1HubHW5Mv69tu3fejMwnH02wXHvXehGRb/Y1vETdXz+R9Z3T+gph4n05vVu7/sv1/40BMUVtgM3PFbi8HNztrNFIfS0zf8zzZyOemmZK9ocje2r2QIZHh2heF+PPitDsC+z+4q2I9OnxHJasE2x39mmr8YVYbwFSIsptH+1IKVipuj6VwDbg4XhWrScLJi8rizjJ0W7Sdbl5rC9tsA4P4lRYoddpjtGyx4/yL2uq/FpuUPoR1KF8wstz07XH1lJob5aV5ji2PLxw9xDGPJn2+36+qbJxpRXfKcs/0n/65BwtnmWRFixCrYHJ8dvEPk8yfVFlitqo57JYObJDjUmO2m/o+l+fMzlc73D9gAZmdOHB3zoCVepebsUu6lap+CFLIEXiMrDlo//3qLVGl4/nRHVvt9qT0HEmvZ15q+LMsmZX2+TL1VbT92AwSbYDkwpVWptw4vPprc/E2aAMC3R9gB5rVff4NN1geJiRfhAfvkIr25xbC8wmnMN47eL798leR7q9XH1zEtrb5jXH1aa1P6sqN+PFSgT5bYroJrsWfTFVc+ZGWW9okVgXirlhaVmzbLrgLaVni9V/ytH0Mfq0gQqVZe0N/IPl3TmYkGVunSzulRTd7Dwd0OFpaksz/Yoi1+mCFunSKt2ur1AUN7Es2Ntxmudmia337qgv+OodjS62eYCT9ii2ha0pYs3S+HncUEObXuQoateoZq8ruyq3J56N8ma6bSifdT902yRLFRouxj2XS11aolrB1ryp9S1RfKEd6xsi8O3JR7XnH/zpOOQXhrtPuy30EPDL401uK8Hjytz9ujH3E+inwqkAWEoX7AdGKjl9tVaCwaxxVOkGNuTG8bv78y16xSzclKq2le2TQjzFKesK3WskPdvWldiqHl5e+YGKTFMb/9XaxVQo8fU9sj2y3Vp0TQ5HuPzsB24ML99rO61a/UzXt/xybBeyRL4XdKH8yxkeArdAOEa24r0P3peB7aOP2HrMmhd/cZZkrHLHcoKp0vLxjjm3ty7y1u4wWnBJkVfcheg3x5sbJwinnbz/DZ9JrnzLSVPjmS3JVpctyyuoxe2Os3YeyFdmJ1ofu5MbmixxcBH60WtPbTzH6U+LGLZbmOlbcbL3clMXWDZWsk/qeSVbTQ5hh5NFQSb/vmHvCi6Ypc8PcEy+xoWIRG/TSqdSKtPqqdbaVy03u3vb4s1VE6hn8uex+0dtPKsT+WGe6RIFF7YHlTYHodsHnAu2mO8gWxYJBsWabJlYih/wfmdnFjtZV6JGG9oaW8SHzyo7Jrq6Dn/p+9hfCtPWiO/d5N471Bd7fwklu/8SKmXj/DmEm+pyTTnY2vhTdKLWXoiGTH0QozTwf+tiQ/9XKXjPo8jVKtR22U+A6UXtvsBla+zPap1a7V5J/PNC/y2U95G3dvnqFErrfO4cfGlwLWFr/OWbHmj+fu7D6qHs0QLo23V5nPRdZqZPX2nRC7w+z6W7xsoLE4XFgxhqZEUH8qqmvnWs3zhIWMcseW8XjfpPylG4Zdtk5d9Lzw6RnhwqJAeRVo7f6aZ7zpH/3BMbT6kuN7i5jYpO0fUWbHKYsyl7QxYzQKAqwVUjQDAdgAAbAcAwHYAAGwHAMB2AABsBwDAdgAAbAcAwHYAYDsAALYDAGA7AAC2AwBgOwAgsPy/AAMAVSLRsZ2IV1oAAAAASUVORK5CYII=";
  }
