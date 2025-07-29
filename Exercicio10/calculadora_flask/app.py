from flask import Flask, render_template, request

app = Flask(__name__)

@app.route('/', methods=['GET', 'POST'])
def index():
    resultado = None
    if request.method == 'POST':
        try:
            num1 = float(request.form['num1'])
            num2 = float(request.form['num2'])
            operacao = request.form['operacao']

            if operacao == 'soma':
                resultado = num1 + num2
            elif operacao == 'subtracao':
                resultado = num1 - num2
            elif operacao == 'multiplicacao':
                resultado = num1 * num2
            elif operacao == 'divisao':
                if num2 != 0:
                    resultado = num1 / num2
                else:
                    resultado = "Erro: Divisão por zero!"
        except ValueError:
            resultado = "Erro: Entrada inválida!"
        except Exception as e:
            resultado = f"Ocorreu um erro: {e}"

    return render_template('index.html', resultado=resultado)

if __name__ == '__main__':
    app.run(debug=True)