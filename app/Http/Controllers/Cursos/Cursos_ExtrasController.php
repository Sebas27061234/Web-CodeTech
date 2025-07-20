<?php

namespace App\Http\Controllers\Cursos;

use App\Http\Controllers\Controller;
use App\Models\Cursos\Cursos_Cursos;
use App\Models\Cursos\Cursos_Modulos;
use App\Models\Cursos\Cursos_Lecciones;
use App\Models\Cursos\Cursos_Lecciones_Files;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Defuse\Crypto\Crypto;
use Defuse\Crypto\Key;
use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;

class Cursos_ExtrasController extends Controller
{
    private Drive $driveService;
    public function __construct(Drive $driveService)
    {
        $this->driveService = $driveService;
    }

    public function storeModule(Request $request){
        $validatedData = $request->validate([
            'titulo' => 'required|string|max:250',
            'descripcion' => 'nullable|string|max:500',
            'orden' => 'required|integer',
            'idCurso' => 'required|exists:cursos_cursos,idCurso',
        ]);
        Cursos_Modulos::create([
            'titulo' => $validatedData['titulo'],
            'descripcion' => $validatedData['descripcion'],
            'orden' => $validatedData['orden'],
            'idCurso' => $validatedData['idCurso'],
            'visible' => 0,
            'estado' => 1,
        ]);
        return Redirect::route('admin.cursos.cursos.show',['curso'=>$validatedData['idCurso']])->with('success', 'Modulo creado');
    }

    public function storeLection(Request $request){
        $validatedData = $request->validate([
            'titulo' => 'nullable|string|max:250',
            'tipo_leccion' => 'required|string|max:250',
            'ordenL' => 'required|integer',
            'idModulo' => 'required|exists:cursos_modulo,idModulo',
        ]);
        $leccion = Cursos_Lecciones::create([
            'titulo' => $validatedData['titulo'] ?? '',
            'tipo_leccion' => $validatedData['tipo_leccion'],
            'orden' => $validatedData['ordenL'],
            'idModulo' => $validatedData['idModulo'],
            'visible' => 0,
            'estado' => 1,
        ]);
        return Redirect::route('admin.cursos.leccion.edit',['curso_id'=>$request->idCursoL,'id'=>$leccion->idLeccion,'tipo'=>$leccion->tipo_leccion])->with('success', 'Leccion creada');
    }

    public function updateLection(Request $request){
        if ($request->get('tipo_leccion') == 'Recurso'){
            $validatedData = $request->validate([
                'titulor' => 'required|string|max:250',
                'fileResource' => 'required',
                'idLeccionR' => 'required|exists:cursos_leccion,idLeccion',
                'sizeFile' => 'required|string|max:50',
                'nameFile' => 'required|string|max:512',
                'extFile' => 'required|string|max:50',
                'idCursoR' => 'required|exists:cursos_cursos,idCurso',
            ]);
    
            $extensionesPermitidas = ['py', 'js', 'css', 'html', 'cs', 'ts', 'php', 'sql', 'csv', 'txt', 'pdf', 'docx', 'pptx', 'xlsx'];
    
            if (!in_array($request->file('fileResource')->getClientOriginalExtension(), $extensionesPermitidas)) {
                return back()->withErrors(['fileResource' => 'Extensión no permitida.']);
            }
    
            $leccion= Cursos_Lecciones::findOrFail($validatedData['idLeccionR']);
            $curso = Cursos_Cursos::where('idCurso','=', $request->get('idCursoR'))->first();
    
            if ($request->file('fileResource')){
                $file = $request->file('fileResource');
                $carpeta = 'files/cursos/cursos/'.$curso->slug.'/leccion/'.$leccion->idLeccion.'/';
                $file->storeAs($carpeta, $file->getClientOriginalName(), 'public');
                $url = 'cursos/cursos/'.$curso->slug.'/leccion/'.$leccion->idLeccion.'/'.$file->getClientOriginalName();
                $oldFile=Cursos_Lecciones_Files::where('idLeccion',$leccion->idLeccion)->first();
                if ($oldFile) {
                    Storage::disk('public')->delete('files/'.$oldFile->url);
                    $oldFile->delete();
                }
                $fileLection = Cursos_Lecciones_Files::create([
                    'nombre' => $request->get('nameFile'),
                    'extension' => $request->get('extFile'),
                    'tamaño' => $request->get('sizeFile'),
                    'url' => $url,
                    'idLeccion' => $leccion->idLeccion,
                ]);
            }
    
            $leccion->update([
                'titulo' => $validatedData['titulor'] ?? '',
                'visible' => 0,
                'estado' => 1,
            ]);
            $cursoId = $validatedData['idCursoR'];
            return Redirect::route('admin.cursos.cursos.show',['curso'=>$cursoId])->with('success', 'Leccion actualizada');
        } else if ($request->get('tipo_leccion') == 'Leccion'){

        }
    }

    public function editLection(Request $request, $curso_id){
        $id = $request->query('id');
        $tipo = $request->query('tipo');
        $leccion = Cursos_Lecciones::find($id);
        $nav = $this->sections();
        return view('admin.cursos.cursos.leccion.edit',compact('leccion','tipo','nav','curso_id'));
    }

    public function updateLectionLec(Request $request){
        $validatedData = $request->validate([
            'titulol' => 'required|string|max:250',
            'idCursoL' => 'required|exists:cursos_cursos,idCurso',
            'idLeccionL' => 'required|exists:cursos_leccion,idLeccion',
            'contenidol' => 'required|string',
        ]);
        $leccion = Cursos_Lecciones::findOrFail($validatedData['idLeccionL']);
        $leccion->update([
            'titulo' => $validatedData['titulol'] ?? '',
            'contenido' => $validatedData['contenidol'] ?? '',
            'visible' => 0,
            'estado' => 1,
        ]);
        return Redirect::route('admin.cursos.cursos.show',['curso'=>$validatedData['idCursoL']])->with('success', 'Leccion actualizada');
    }

    public function updateLectionQuiz(Request $request){
        
    }

    public function subir(Request $request)
    {
        $request->validate([
            'video' => 'required|mimes:mp4,avi,mov',
            'poster' => 'required|mimes:jpg,jpeg,png',
            'idCurso' => 'required|exists:cursos_cursos,idCurso',
            'idLeccion' => 'required|exists:cursos_leccion,idLeccion',
            'nameFile' => 'required|string|max:512',
            'extFile' => 'required|string|max:50',
            'sizeFile' => 'required|string|max:50',
        ]);

        $curso = Cursos_Cursos::where('idCurso','=', $request->get('idCurso'))->first();
        $leccion = Cursos_Lecciones::where('idLeccion','=', $request->get('idLeccion'))->first();
        $carpeta = 'files/cursos/cursos/'.$curso->slug.'/leccion/'.$leccion->idLeccion.'/';
        $request->file('video')->storeAs($carpeta,$request->file('video')->getClientOriginalName(), 'public');
        $request->file('poster')->storeAs($carpeta, $request->file('poster')->getClientOriginalName(), 'public');
        $url = 'cursos/cursos/'.$curso->slug.'/leccion/'.$leccion->idLeccion.'/'.$request->file('video')->getClientOriginalName();
        $urlPoster = 'cursos/cursos/'.$curso->slug.'/leccion/'.$leccion->idLeccion.'/'.$request->file('poster')->getClientOriginalName();
        $oldFile=Cursos_Lecciones_Files::where('idLeccion',$leccion->idLeccion)->first();
        if ($oldFile) {
            Storage::disk('public')->delete('files/'.$oldFile->url);
            $oldFile->delete();
        }
        $fileLection = Cursos_Lecciones_Files::create([
            'nombre' => $request->get('nameFile'),
            'extension' => $request->get('extFile'),
            'tamaño' => $request->get('sizeFile'),
            'url' => $url,
            'poster' => $urlPoster,
            'idLeccion' => $leccion->idLeccion,
        ]);
        $key = Key::loadFromAsciiSafeString(env('APP_ENCRYPTION_KEY'));
        $cadena = $fileLection->idLeccionFile.';'.$fileLection->nombre.';'.$fileLection->extension.';'.$fileLection->tamaño;
        $encrypted = Crypto::encrypt($cadena, $key);
        $ruta = route('reproCursos', ['video' => $encrypted]);

        return response()->json(['url' => asset($ruta)]);
    }

    public function showVideos($url)
    {
        $key = Key::loadFromAsciiSafeString(env('APP_ENCRYPTION_KEY'));
        $descrypted = Crypto::decrypt($url, $key);
        $parametros = explode(';', $descrypted);
        $video = Cursos_Lecciones_Files::where('idLeccionFile','=',$parametros[0])->first();
        $lista = Cursos_Lecciones_Files::where('idLeccion','=',$video->idLeccion)->get();
        $videosArray = $lista->values();
        $siguienteVideo = null;

        foreach ($videosArray as $index => $videoA) {
            if ($videoA->idLeccion == $video->idLeccion) {
                if (isset($videosArray[$index + 1])) {
                    $siguienteVideo = $videosArray[$index + 1];
                }
                break;
            }
        }
        return view('admin.cursos.cursos.leccion.reprovideo',compact('video','lista','siguienteVideo'));
    }
}
