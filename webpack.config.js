const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
module.exports = {
  mode: 'development',
  watch: true,
  entry: {
    'js/app' : './src/js/app.js',
    'js/inicio' : './src/js/inicio.js',
    'js/productos/index' : './src/js/productos/index.js',
    'js/Lote/index' : './src/js/Lote/index.js',
    'js/Calibre/index' : './src/js/Calibre/index.js',
    'js/Asignacion/index' : './src/js/Asignacion/index.js',
    'js/Situaciones/index' : './src/js/Situaciones/index.js',
    'js/IngresoFab/index' : './src/js/IngresoFab/index.js',
    'js/helado/index' : './src/js/helado/index.js',
    'js/IngresoAlmacen/index' : './src/js/IngresoAlmacen/index.js',
    'js/almacenComando/index' : './src/js/almacenComando/index.js',
    'js/Batallon/index' : './src/js/Batallon/index.js',
    'js/inspectoriaG/index' : './src/js/inspectoriaG/index.js',
  },
  output: {
    filename: '[name].js',
    path: path.resolve(__dirname, 'public/build')
  },
  plugins: [
    new MiniCssExtractPlugin({
        filename: 'styles.css'
    })
  ],
  module: {
    rules: [
      {
        test: /\.(c|sc|sa)ss$/,
        use: [
            {
                loader: MiniCssExtractPlugin.loader
            },
            'css-loader',
            'sass-loader'
        ]
      },
      {
        test: /\.(png|svg|jpg|gif)$/,
        loader: 'file-loader',
        options: {
           name: 'img/[name].[hash:7].[ext]'
        }
      },
    ]
  }
};